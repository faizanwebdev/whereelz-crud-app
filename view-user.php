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
          <li class="breadcrumb-item active">Users Details</li>
        </ol>
        <!-- DataTables Example -->
        <div class="card mb-3">
        <div class="card-header bg-dark text-white">
                    <i class="fas fa-table"></i>
                   Users
                   <?php 
                    if($getrole == "Admin"){
                    ?>
                    <span style="float: right;"><a class="btn btn-primary modalButton1" data-toggle="modal" href="javascript:void(0);"><i class="fas fa-plus"></i> Add New User</a></span>
                    <?php    
                    }
                    ?> 
                   
                    </div>
          <div class="card-body">
            <div class="table-responsive">
             <table class="table table-bordered table-condensed" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-dark text-white">
                  <tr>
                    <th>Sr. No.</th> 
                    <th>Name</th> 
                    <th>Email</th>                  
                    <th>Username</th>                  
                    <th>Password</th>
                    <th>Role</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Last Login</th>
                    <th>Last Updated</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
//Queries based on role of user
if($getrole == "Admin"){
    $table_data = "SELECT * FROM users";
    $stmt1 = $con->prepare($table_data);
    $stmt1->execute();  
}
else{
    $table_data = "SELECT * FROM users WHERE id = :id";
    $stmt1 = $con->prepare($table_data);
    $stmt1->execute(['id' => $_SESSION['userid']]);
}

$i = 1;
?>
<?php  
                while($row = $stmt1->fetch())  
                {
                    $lastlogin = $row->lastlogin;
                    if($lastlogin == "0000-00-00 00:00:00"){
                        $lastlogin = $row->lastlogin;
                    }
                    else{
                        $lastlogin =strtotime($lastlogin);
                        $lastlogin = date('d M Y H:i:s',$lastlogin);
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
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row->name; ?></td>
                      <td><?php echo $row->email; ?></td>
                      <td><?php echo $row->username; ?></td>
                      <td><?php echo $row->password; ?></td>
                      <td><?php echo $row->role; ?></td>
                      <td>
                          <a href="javascript:void(0);" class="btn btn-sm btn-info edit modalButton" data-toggle="modal" data-id="<?php echo $row->id;?>"><i class="fas fa-fw fa-edit" title="EDIT/UPDATE"></i></a>
                      </td>
                      <td>
                      <a href="javascript:void(0);" class="btn btn-sm btn-danger delete <?php if($getrole == "General"){echo "disabled";} ?>" data-user-name="<?php echo $row->name; ?>" id="<?php echo $row->id; ?>"><i class="fas fa-fw fa-trash" title="DELETE"></i></a>
                      </td>
                      <td><?php echo $lastlogin; ?></td>
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
                <h5 class="modal-title">Update User</h5>
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
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form method='POST' id='insert' name='insert' action='add-user.php'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Name <strong class='text-danger'>**</strong></label>
                              <input type='text' id='name' name='name' class='form-control' placeholder='Enter Full Name (Example Sachin Tendulkar)' required>
                            </div>
                          </div>
                          <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Email <strong class='text-danger'>**</strong></label>
                              <input type='email' id='uemail' name='uemail' class='form-control' placeholder='Enter Email ID (Example sachin@example.com)' required>
                            </div>
                          </div>
                          <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Username <strong class='text-danger'>**</strong></label>
                              <input type='text' id='username' name='username' class='form-control' placeholder='Enter Username (Example sachin)' required>
                            </div>
                          </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Password <strong class='text-danger'>**</strong></label>
                              <input type='text' id='pwd' name='pwd' class='form-control' placeholder='Enter Password' required>
                            </div>
                          </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Role <strong class='text-danger'>**</strong></label>
                              <select class="form-control" name="usertype" id="usertype" required>
                                  <option value="">Please Select User Role</option>
                                  <option value="Admin">Admin</option>
                                  <option value="General">General</option>
                              </select>
                            </div>
                          </div>
                    </div>
                    <button class='btn btn-primary add' onclick='return add()' type='submit' name='adduser' id='adduser'>Add</button>
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

 $("#dataTable").on('click','.delete',function(){
     var id = $(this).attr("id");
     var user = $(this).data("user-name");
     var ask = confirm("Are you sure you want to delete "+user+"?");
     if(ask){
         $.ajax({
         url:'delete-user.php',
         type:'POST',
         data:{id:id,user:user},
         cache:false,
         beforeSend: function(){
             $('.delete').addClass("disabled");
         },
         success: function(data){
             $('.delete').removeClass("disabled");
             if(data == "success"){
                 alert(user+' has been deleted');
             }
             if(data == "fail"){
                 alert('There was some error, please try again later or contact your website administrator');
             }
             if(data == "invalid"){
                 alert("Please refresh page again properly and then try");
             }
         }
        });
        $(this).closest('tr').remove();
     }
 
 });
    
    
$("#dataTable").on('click','.modalButton',function(){
    
        var id =$(this).data('id');

        $.ajax({
            url:"fetch-single-user.php",
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
    var name = $('#name').val().trim();
    var username = $('#username').val().trim();
    var uemail = $('#uemail').val().trim();
    var pwd = $('#pwd').val().trim();
    var usertype = $('#usertype').val().trim();
        
    if(name !== ""){
       if(username !== ""){
            if(pwd !== ""){
                if(usertype !== ""){
                    $.ajax({
                      url: 'add-user.php',
                      type: 'POST',
                      data:{name:name,username:username,uemail:uemail,pwd:pwd,usertype:usertype,adduser:"adduser"},
                      beforeSend: function(){
                          $('.add').prop("disabled",true);
                          $('.add').text("Inserting....");
                      },
                      success: function(data){
                          $('.add').prop("disabled",false);
                          $('.add').text("Add"); 
                          if(data == 'success'){
                              alert(username+" Added Successfully");
                              $("#insert")[0].reset();
                              $("#dynamicModal1").modal('hide');
                              location.reload();
                           }
                          if(data == 'duplicate'){
                              alert("User already exists, Please Enter Unique Email ID or Username");
                              $("#state_name").focus();
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
                    alert("Please Select Usertype");
                    $('#usertype').focus();
                }
            }
            else{
                alert("Please Enter Passowrd");
                $('#pwd').focus();
            }
        }
        else{
            alert("Please Enter Username");
            $("#username").focus();
        }
    }
    else{
        alert("Please Enter Name");
        $("#name").focus();   
    }
    return false;
}  
    
function update(){
        var id = $('#id').val().trim();
        var name = $('#name').val().trim();
        var username = $('#username').val().trim();
        var uemail = $('#uemail').val().trim();
        var pwd = $('#pwd').val().trim();
        var usertype = $('#usertype').val().trim();
        
        if(name !== ""){
            if(username !== ""){
                if(uemail !== ""){
                    if(pwd !== ""){
                        if(usertype !== ""){
                            $.ajax({
                              url: 'updateuser.php',
                              type: 'POST',
                              data:{id:id,name:name,username:username,uemail:uemail,
                            pwd:pwd,usertype:usertype,updateuser:"updateuser"},
                              beforeSend: function(){
                                  $('.update').prop("disabled",true);
                                  $('.update').text("Updating....");
                              },
                              success: function(data){
                                  $('.update').prop("disabled",false);
                                  $('.update').text("Update"); 
                                  if(data == 'success'){
                                      alert("User Updated Successfully");
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
                            alert("Please Select Usertype");
                            $('#usertype').focus();
                        }
                    }
                    else{
                        alert("Please Enter Passowrd");
                        $('#pwd').focus();
                    }
                }
                else{
                    alert("Please Select Usertype");
                    $('#uemail').focus();
                }
            }
            else{
                alert("Please Enter Username");
                $("#username").focus();
            }
        }
        else{
            alert("Please Enter Name");
            $("#name").focus();
        }
        return false;
    }
</script>