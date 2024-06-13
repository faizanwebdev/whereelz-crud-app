<?php
//ob_start();
include "config-pdo.php";
session_start();
date_default_timezone_set("Asia/Kolkata");

//Checking whether Session already set or not and user is loggedin or not
if (!isset($_SESSION['userid']) && !isset($_SESSION['username'])) {
  header("Location: index.php");
}
else{
    //Fetching user detail
    $getuserdetail = "SELECT * FROM users WHERE id = :id";
	$stmtgetuser = $con->prepare($getuserdetail);
	$stmtgetuser->execute(['id' => $_SESSION['userid']]);
    $getresult = $stmtgetuser->rowCount();
    if($getresult == 1){
        $getrow = $stmtgetuser->fetch();
        $getid = $getrow->id;
        $getname = $getrow->name;
        $getemail = $getrow->email;
        $getrole = $getrow->role;
        $getlastlogin = $getrow->lastlogin;
        $getlastlogin =strtotime($getlastlogin);
        $getlastlogin = date('d M Y H:i:s',$getlastlogin);
        $getcreated_date = $getrow->created_date;
        $getcreated_date =strtotime($getcreated_date);
        $getcreated_date = date('d M Y H:i:s',$getcreated_date);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <?php 
  $uri = $_SERVER['REQUEST_URI'];
  
  ?>

  <title><?php echo basename($uri,".php"); ?></title>

  <!-- Custom fonts for this template-->
  <link href="vendor11/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor11/fontawesome-free/css/brands.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor11/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="dashboard.php">
    <img class="img-responsive" width="150px" src="images/wherrelz.png">
    </a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" hidden>
        <div class="input-group-append">
          <button class="btn btn-primary" type="button" hidden>
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i> 
          <?php
if (isset($_SESSION['username'])) {
  echo $getname;
}
else{
  echo "Username";
}
?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>