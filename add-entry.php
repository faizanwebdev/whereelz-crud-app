<?php

include 'config-pdo.php';
session_start();

date_default_timezone_set("Asia/Calcutta");
$date = date("Y-m-d");
$added_on = date('Y-m-d H:i:s');
$lastlogin = "0000-00-00 00:00:00";

//Sanitize function
function cleanup( $data ) {
    
    $data = trim( $data );
    $data = htmlspecialchars( $data );
    return $data;
}

   if(isset($_POST['addentry']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
       
        //Retrieving POST data
        $account_number = cleanup($_POST['account_number']);
        $narration = cleanup($_POST['narration']);
        $currency = cleanup($_POST['currency']);
        $credit_card = cleanup($_POST['credit_card']);
        $debit_card = cleanup($_POST['debit_card']);
        $userid = $_SESSION['userid'];

        //Validation check for empty
        if(empty($account_number) || empty($narration) || empty($currency) || empty($credit_card) || empty($debit_card)){
            echo "mandatory";    
        }
        else{

            $insertqry="INSERT INTO `entries`(`userid`,`account_number`,`narration`,`currency`,`credit_card_number`,`debit_card_number`,`created_date`,`updated_date`) VALUES            (:userid,:account_number,:narration,:currency,:credit_card_number,:debit_card_number,:created_date,:updated_date)";
            $stmt = $con->prepare($insertqry);
            $stmt->execute(["userid"=>$userid,"account_number"=>$account_number,"narration"=>$narration,"currency"=>$currency,"credit_card_number"=>$credit_card,"debit_card_number"=>$debit_card,"created_date"=>$added_on,"updated_date"=>$lastlogin
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