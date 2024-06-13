<?php
session_start();
include 'config-pdo.php';

if (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
	$id = htmlspecialchars($_REQUEST['id']);
    
    $query = "SELECT * FROM users WHERE id = '$id'";
    $stmt1 = $con->prepare($query);
    $stmt1->execute();
    $count = $stmt1->rowCount();
    
    if ($count == 1) {
      if ($row = $stmt1->fetch()) {
          //for dropdown option based on user role
          if($_SESSION['role'] == "General"){
              $word = "<div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Role <strong class='text-danger'>**</strong></label>
                              <select class='form-control' name='usertype' id='usertype' required disabled>
                                  <option value=''>Please Select User Type</option>
                                  <option value='Admin'>Admin</option>
                        <option value='General' selected>General</option>
                              </select>
                            </div>
                          </div>";
              
          }
          if($_SESSION['role'] == "Admin"){
              $word = "<div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Role <strong class='text-danger'>**</strong></label>
                              <select class='form-control' name='usertype' id='usertype' required>
                                  <option value=''>Please Select User Type</option>
                                  <option value='Admin' selected>Admin</option>
                        <option value='General'>General</option>
                              </select>
                            </div>
                          </div>";
          }
        $output = "
         
                    <form method='POST' id='edit' name='edit' action='updateuser.php'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Name <strong class='text-danger'>**</strong></label>
                              <input type='hidden' id='id' name='id' value='$row->id'>
                              <input type='text' id='name' name='name' value='$row->name' class='form-control' placeholder='Enter Full Name' required>
                            </div>
                          </div>
                          <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Email <strong class='text-danger'>**</strong></label>
                              <input type='email' id='uemail' name='uemail' value='$row->email' class='form-control' placeholder='Enter Email ID' required>
                            </div>
                          </div>
                          <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Username <strong class='text-danger'>**</strong></label>
                              <input type='text' id='username' name='username' value='$row->username' class='form-control' placeholder='Enter Full Name' required>
                            </div>
                          </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Password <strong class='text-danger'>**</strong></label>
                              <input type='text' id='pwd' name='pwd' value='$row->password' class='form-control' placeholder='Enter Password' required>
                            </div>
                          </div>
                        $word
                    </div>
                    <button class='btn btn-primary update' onclick='return update()' type='submit' name='updateuser' id='updateuser'>Update</button>
                    </form>";
        

          echo $output;
      }
    }
}
?>