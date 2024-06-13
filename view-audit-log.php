<?php include "header.php"; ?>
<?php include "functions/functions.php";?>
  <div id="wrapper">

<?php include "sidebar.php"; ?>    
<?php include "config-pdo.php"; ?>
    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Audit Logs</li>
        </ol>
        <!-- DataTables Example -->
        <div class="card mb-3">
        <div class="card-header bg-dark text-white">
                    <i class="fas fa-table"></i>
                   Audit Logs
<!--                    <span style="float: right;"><a class="btn btn-primary modalButton1" data-toggle="modal" href="javascript:void(0);"><i class="fas fa-plus"></i> Add New Entry</a></span>-->
                     
                   
                    </div>
          <div class="card-body">
            <div class="table-responsive">
             <table class="table table-bordered table-condensed" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-dark text-white">
                  <tr>
                    <th>ID</th>
                    <?php 
                    if($getrole == "Admin"){
                    ?>
                    <th>User</th>
                    <?php
                    }
                    ?>
                     
                    <th>EntryID</th> 
                    <th>Table</th>                  
                    <th>Fields</th>                  
                    <th>Old Values</th>
                    <th>New Values</th>
                    <th>Updated Date</th>
                    
                  </tr>
                </thead>

                <tbody>
                 
                  <?php
//Queries based on role of user
if($getrole == "Admin"){
    $table_data = "SELECT a.id, a.userid, a.entryid, a.table_log, a.fields, a.old_value, a.new_value, a.created_date, u.name FROM audit a JOIN users u ON a.userid = u.id;";
    $stmt1 = $con->prepare($table_data);
    $stmt1->execute();  
}
else{
    $table_data = "SELECT * FROM audit WHERE userid = :userid";
    $stmt1 = $con->prepare($table_data);
    $stmt1->execute(['userid' => $_SESSION['userid']]);
}

$i = 1;

?>
<?php  
                while($row = $stmt1->fetch())  
                {
                    $created_date = $row->created_date;
                    if($created_date == "0000-00-00 00:00:00"){
                        $created_date = $row->created_date;
                    }
                    else{
                        $created_date =strtotime($created_date);
                        $created_date = date('d M Y H:i:s',$created_date);
                    }
                    
                ?>
                  <tr>
                      <td><?php echo $row->id; ?></td>
                      <?php 
                        if($getrole == "Admin"){
                        ?>
                        <td><?php echo $row->name; ?></td>
                        <?php
                        }
                        ?>
                      
                      <td><?php echo $row->entryid; ?></td>
                      <td><?php echo $row->table_log; ?></td>
                      <td><?php echo $row->fields; ?></td>
                      <td><?php echo $row->old_value; ?></td>
                      <td><?php echo $row->new_value; ?></td>
                      <td><?php echo $created_date; ?></td>
                  </tr>

                <?php 
                    $i++;
                }  
                ?>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
       
      <!-- /.container-fluid -->

 <?php include "footer.php"; ?>