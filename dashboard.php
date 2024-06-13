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
          <li class="breadcrumb-item active">Overview</li>
        </ol>


        <!-- DataTables Example -->
        <div class="row">
            <div class="col-xl-4 col-md-4">
                             <div class="card mb-3" style="border:1px solid black;">
                  <div class="card-header bg-dark text-white">
                    <i class="fas fa-table"></i>
                   Stats
                    </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-condensed" width="100%" cellspacing="0">
                        <thead class="bg-dark text-white">
                          <tr>
                            <th>Total Entries</th>
                            <th><?php echo entries_count(); ?></th>
                          </tr>
                          <?php 
                          if($getrole == "Admin"){
                          ?>
                          <tr>
                            <th>Total Users</th>
                            <th><?php echo users_count(); ?></th>
                          </tr>
                          <?php
                          }    
                          ?>
                        </thead>
                      </table>
                    </div>
                  </div>

                </div>
            </div>
            
            <div class="col-xl-4 col-md-4">
                             <div class="card mb-3" style="border:1px solid black;">
                  <div class="card-header bg-dark text-white">
                    <i class="fas fa-table"></i>
                   Joining Details
                    </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-condensed" width="100%" cellspacing="0">
                        <thead class="bg-dark text-white">
                          <tr>
                            <th>Joining Date</th>
                            <th><?php echo $getcreated_date; ?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>

                </div>
            </div>
            
            <div class="col-xl-4 col-md-4">
                             <div class="card mb-3" style="border:1px solid black;">
                  <div class="card-header bg-dark text-white">
                    <i class="fas fa-table"></i>
                   Recent Login
                    </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-condensed" width="100%" cellspacing="0">
                        <thead class="bg-dark text-white">
                          <tr>
                            <th>Last Loggedin</th>
                            <th><?php echo $getlastlogin; ?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>

                </div>
            </div>
            

        </div>
        

      </div>
      <!-- /.container-fluid -->

 <?php include "footer.php"; ?>     
