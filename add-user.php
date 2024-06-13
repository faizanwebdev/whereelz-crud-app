<?php
include 'config-pdo.php';
session_start();

date_default_timezone_set("Asia/Calcutta");
$date = date("Y-m-d");
$added_on = date('Y-m-d H:i:s');
$lastlogin = "0000-00-00 00:00:00";

//Sanitize Function
function cleanup( $data ) {
    
    $data = trim( $data );
    $data = htmlspecialchars( $data );
    return $data;
}
   if(isset($_POST['adduser']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

        //Retrieving POST values
        $name = cleanup($_POST['name']);
        $username = cleanup($_POST['username']);
        $uemail = cleanup($_POST['uemail']);
        $pwd = cleanup($_POST['pwd']);
        $usertype = cleanup($_POST['usertype']);
        
       
        //Validation Check for Empty
        if(empty($name) || empty($username) || empty($uemail)||empty($pwd) || empty($usertype)){
            echo "mandatory";
    
        }
        else{
            //Checking if User Already Exists
            $checkuser = "SELECT * from `users` WHERE `email`=:email OR `username`=:username";
            $stmt2 = $con->prepare($checkuser);
            $stmt2->execute(["email"=>$uemail,"username"=>$username]);
            $count = $stmt2->rowCount();
            if($count > 0){
                echo "duplicate";
                die();
            }
            
            $insertqry="INSERT INTO `users`(`name`,`email`,`username`,`password`,`role`,`created_date`,`lastlogin`,`updated_date`) VALUES            (:name,:email,:username,:password,:role,:created_date,:lastlogin,:updated_date)";
            $stmt = $con->prepare($insertqry);
            $stmt->execute(["name"=>$name,"email"=>$uemail,"username"=>$username,"password"=>$pwd,"role"=>$usertype,"created_date"=>$added_on,"lastlogin"=>$lastlogin,"updated_date"=>$lastlogin
            ]);
        if($stmt){
            echo "success";
        }
        else{
            echo "fail";
        }
        }
   }
?>