<?php
session_start();
include 'config-pdo.php';

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])) {

	$id = htmlspecialchars(trim($_POST['id']));
    $user = htmlspecialchars(trim($_POST['user']));
	if (!empty($id)) {
		$delete = "DELETE FROM `users` WHERE `id` = :id";
        $stmt = $con->prepare($delete);
        $stmt->execute(["id"=>$id]);

        if($stmt){
            echo "success"; 
        }
        else{
            echo "fail";
        }
	}
    else{
        echo "invalid";
    }
}
?>