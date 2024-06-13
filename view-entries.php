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
          <li class="breadcrumb-item active">Entries</li>
        </ol>
        <!-- DataTables Example -->
        <div class="card mb-3">
        <div class="card-header bg-dark text-white">
                    <i class="fas fa-table"></i>
                   Entries
                    <span style="float: right;"><a class="btn btn-primary modalButton1" data-toggle="modal" href="javascript:void(0);"><i class="fas fa-plus"></i> Add New Entry</a></span>
                     
                   
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
                     
                    <th>Account Number</th> 
                    <th>Narration</th>                  
                    <th>Currency</th>                  
                    <th>Credit Card Number</th>
                    <th>Debit Card Number</th>
                    <th>Edit</th>
                    <th>Created Date</th>
                    <th>Last Updated</th>
                    
                  </tr>
                </thead>

                <tbody>
                  <?php
//Queries based on role of user
if($getrole == "Admin"){
    $table_data = "SELECT e.id, e.userid, u.name, e.account_number, e.narration, e.currency, e.credit_card_number, e.debit_card_number, e.created_date, e.updated_date FROM Entries e JOIN Users u ON e.userid = u.id;";
    $stmt1 = $con->prepare($table_data);
    $stmt1->execute();  
}
else{
    $table_data = "SELECT * FROM entries WHERE userid = :userid";
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
                    
                    $lastupdated = $row->updated_date;
                    if($lastupdated == "0000-00-00 00:00:00"){
                        $lastupdated = $row->updated_date;
                    }
                    else{
                        $lastupdated =strtotime($lastupdated);
                        $lastupdated = date('d M Y H:i:s',$lastupdated);
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
                      
                      <td><?php echo $row->account_number; ?></td>
                      <td><?php echo $row->narration; ?></td>
                      <td><?php echo $row->currency; ?></td>
                      <td><?php echo $row->credit_card_number; ?></td>
                      <td><?php echo $row->debit_card_number; ?></td>
                      <td>
                          <a href="javascript:void(0);" class="btn btn-sm btn-info edit modalButton" data-toggle="modal" data-id="<?php echo $row->id;?>"><i class="fas fa-fw fa-edit" title="EDIT/UPDATE"></i></a>
                      </td>
                      <td><?php echo $created_date; ?></td>
                      <td><?php echo $lastupdated; ?></td>
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
      <!--Modal starts Here-->
<div class="modal fade" id="dynamicModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:#ef1932;">
                <h5 class="modal-title">Update Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body responsetxt" id="modtext">
              

            </div>
            <div class="modal-footer text-white" style="background:#ef1932;">
                <button type="button" class="btn bg-dark text-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dynamicModal1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:#ef1932;">
                <h5 class="modal-title">Add Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form method='POST' id='insert' name='insert' action='add-entry.php'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Account Number <strong class='text-danger'>**</strong></label>
                              <input type='text' id='account_number' name='account_number' class='form-control' placeholder='Enter Account Number' required>
                            </div>
                          </div>
                          <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Narration <strong class='text-danger'>**</strong></label>
                              <input type='text' id='narration' name='narration' class='form-control' placeholder='Enter Narration' required>
                            </div>
                          </div>
                          <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Currency <strong class='text-danger'>**</strong></label>
                              <input type='text' id='currency' name='currency' class='form-control' placeholder='Enter Currency' required>
                            </div>
                          </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Credit Card Number <strong class='text-danger'>**</strong></label>
                              <input type='text' id='credit_card' name='credit_card' class='form-control' placeholder='Enter Credit Card Number' required>
                            </div>
                          </div>
                          
                          <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Debit Card Number <strong class='text-danger'>**</strong></label>
                              <input type='text' id='debit_card' name='debit_card' class='form-control' placeholder='Enter Debit Card Number' required>
                            </div>
                          </div>
                        
                    </div>
                    <button class='btn btn-primary add' onclick='return add()' type='submit' name='addentry' id='addentry'>Add</button>
                    </form>

            </div>
            <div class="modal-footer text-white" style="background:#ef1932;">
                <button type="button" class="btn bg-dark text-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>          
      <!-- /.container-fluid -->

 <?php include "footer.php"; ?>
 
   
<script>
$(document).ready(function(){
    
$("#dataTable").on('click','.modalButton',function(){
    
        var id =$(this).data('id');
        $.ajax({
            url:"fetch-single-entry.php",
            method:"post",
            data:{id:id},
            success:function(response){
                $(".responsetxt").html(response);
                $("#dynamicModal").modal('show'); 
            }
        });
    });
    
$(".card-header").on('click','.modalButton1',function(){
        $("#dynamicModal1").modal('show');
    });
});

</script>

<script>
function add(){
    var account_number = $('#account_number').val().trim();
    var narration = $('#narration').val().trim();
    var currency = $('#currency').val().trim();
    var credit_card = $('#credit_card').val().trim();
    var debit_card = $('#debit_card').val().trim();
        
    if(account_number !== ""){
       if(narration !== ""){
           if(currency !== ""){
               if(credit_card !== ""){
                    if(debit_card !== ""){
                        $.ajax({
                          url: 'add-entry.php',
                          type: 'POST',
                          data:{account_number:account_number,narration:narration,currency:currency,credit_card:credit_card,debit_card:debit_card,addentry:"addentry"},
                          beforeSend: function(){
                              $('.add').prop("disabled",true);
                              $('.add').text("Inserting....");
                          },
                          success: function(data){
                              $('.add').prop("disabled",false);
                              $('.add').text("Add"); 
                              if(data == 'success'){
                                  alert("Entry Added Successfully");
                                  $("#insert")[0].reset();
                                  $("#dynamicModal1").modal('hide');
                                  location.reload();
                               }
                              if(data == 'mandatory'){
                                  alert("Please Fill All Fields Properly");
                              }
                              if(data == 'fail'){
                                  alert("There was some while submitting, please try again later or contact website administrator");
                              }
                          }
                      });
                    }
                    else{
                        alert("Please Enter Debit Card Number");
                        $('#debit_card').focus();
                    }
                }
                else{
                    alert("Please Enter Credit Card Number");
                    $('#credit_card').focus();
                }
           }
           else{
               alert("Please Enter Currency");
                $('#currency').focus();
           }
        }
        else{
            alert("Please Enter Narration");
            $("#narration").focus();
        }
    }
    else{
        alert("Please Enter Account Number");
        $("#account_number").focus();   
    }
    return false;
}
    
function update(){
    var id = $('#id').val().trim();
    var account_number = $('#account_number').val().trim();
    var old_account_number = $('#old_account_number').val().trim();
    var narration = $('#narration').val().trim();
    var old_narration = $('#old_narration').val().trim();
    var currency = $('#currency').val().trim();
    var old_currency = $('#old_currency').val().trim();
    var credit_card = $('#credit_card').val().trim();
    var old_credit_card = $('#old_credit_card').val().trim();
    var debit_card = $('#debit_card').val().trim();
    var old_debit_card = $('#old_debit_card').val().trim();
        
    if(account_number !== ""){
       if(narration !== ""){
           if(currency !== ""){
               if(credit_card !== ""){
                    if(debit_card !== ""){
                        $.ajax({
                          url: 'updateentry.php',
                          type: 'POST',
                          data:{id:id,account_number:account_number,old_account_number:old_account_number,narration:narration,old_narration:old_narration,currency:currency,old_currency:old_currency,credit_card:credit_card,old_credit_card:old_credit_card,debit_card:debit_card,old_debit_card:old_debit_card,updateentry:"updateentry"},
                          beforeSend: function(){
                                  $('.update').prop("disabled",true);
                                  $('.update').text("Updating....");
                              },
                              success: function(data){
                                  $('.update').prop("disabled",false);
                                  $('.update').text("Update"); 
                                  if(data == 'success'){
                                      alert("Entry Updated Successfully");
                                      $("#edit")[0].reset();
                                      $("#dynamicModal").modal('hide');
                                      location.reload();
                                   }
                                  if(data == 'mandatory'){
                                      alert("Please Fill All Fields Properly");
                                  }
                                  if(data == 'fail'){
                                      alert("There was some while submitting, please try again later or contact website administrator");
                                  }
                              }
                      });
                    }
                    else{
                        alert("Please Enter Debit Card Number");
                        $('#debit_card').focus();
                    }
                }
                else{
                    alert("Please Enter Credit Card Number");
                    $('#credit_card').focus();
                }
           }
           else{
               alert("Please Enter Currency");
                $('#currency').focus();
           }
        }
        else{
            alert("Please Enter Narration");
            $("#narration").focus();
        }
    }
    else{
        alert("Please Enter Account Number");
        $("#account_number").focus();   
    }
    return false;
} 
</script>