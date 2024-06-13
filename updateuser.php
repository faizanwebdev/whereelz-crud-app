<?php
include 'config-pdo.php';
session_start();

date_default_timezone_set("Asia/Calcutta");
$date = date("Y-m-d");
$added_on = date('Y-m-d H:i:s');
$updated_on = date('Y-m-d H:i:s');


//Sanitize Function
function cleanup( $data ) {
    $data = trim( $data );
    $data = htmlspecialchars( $data );
    return $data;
}
   if(isset($_POST['updateuser']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
       
        //Data Retrieval from POST
        $id = cleanup($_POST['id']);
        $name = cleanup($_POST['name']);
        $username = cleanup($_POST['username']);
        $uemail = cleanup($_POST['uemail']);
        $pwd = cleanup($_POST['pwd']);
        $usertype = cleanup($_POST['usertype']);

        //Validation check for empty
        if(empty($username) || empty($uemail) || empty($pwd) || empty($usertype)){
            echo "mandatory";
        }
        else{
            $updateqry="UPDATE `users` SET `name`=:name,`email`=:email,`username`=:username,
            `password`=:password,`role`=:role, `updated_date`=:updated_date WHERE `id`=:id";
            $stmt = $con->prepare($updateqry);
            $stmt->execute(["name"=>$name,
            "email"=>$uemail,"username"=>$username,
            "password"=>$pwd,"role"=>$usertype,
            "updated_date"=>$updated_on,"id"=>$id
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