<?php
include 'config-pdo.php';
session_start();

date_default_timezone_set("Asia/Calcutta");
$date = date("Y-m-d");
$added_on = date('Y-m-d H:i:s');
$updated_on = date('Y-m-d H:i:s');


//Sanitize function
function cleanup( $data ) {
    $data = trim( $data );
    $data = htmlspecialchars( $data );
    return $data;
}
   if(isset($_POST['updateentry']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
       
        //Array fields to store field, old value, new value
        $updatefields = array();
        $old_value = array();
        $new_value = array();
        $table_log = "Entries";
        $id = cleanup($_POST['id']);
       
        //Data retrieval from POST along with data checking
        $account_number = cleanup($_POST['account_number']);
        $old_account_number = cleanup($_POST['old_account_number']);
        if($account_number != $old_account_number){
            array_push($updatefields, "Account Number");
            array_push($old_value, $old_account_number);
            array_push($new_value, $account_number);
        }
       
        $narration = cleanup($_POST['narration']);
        $old_narration = cleanup($_POST['old_narration']);
        if($narration != $old_narration){
            array_push($updatefields, "Narration");
            array_push($old_value, $old_narration);
            array_push($new_value, $narration);
        }
       
        $currency = cleanup($_POST['currency']);
        $old_currency = cleanup($_POST['old_currency']);
        if($currency != $old_currency){
            array_push($updatefields, "Currency");
            array_push($old_value, $old_currency);
            array_push($new_value, $currency);
        }
       
        $credit_card = cleanup($_POST['credit_card']);
        $old_credit_card = cleanup($_POST['old_credit_card']);
        if($credit_card != $old_credit_card){
            array_push($updatefields, "Credit Card");
            array_push($old_value, $old_credit_card);
            array_push($new_value, $credit_card);
        }
       
        $debit_card = cleanup($_POST['debit_card']);
        $old_debit_card = cleanup($_POST['old_debit_card']);
        if($debit_card != $old_debit_card){
            array_push($updatefields, "Debit Card");
            array_push($old_value, $old_debit_card);
            array_push($new_value, $debit_card);
        }
       
        $updatedfields = implode(",",$updatefields);
        $oldvalues = implode(",",$old_value);
        $newvalues = implode(",",$new_value);

        if(empty($account_number) || empty($narration) || empty($currency) || empty($credit_card) || empty($debit_card)){
            echo "mandatory";
        }
        else{
            //Updating entries table
            $updateqry="UPDATE `entries` SET `account_number`=:account_number,`narration`=:narration,`currency`=:currency,            `credit_card_number`=:credit_card_number,`debit_card_number`=:debit_card_number, `updated_date`=:updated_date WHERE `id`=:id";
            $stmt = $con->prepare($updateqry);
            $stmt->execute(["account_number"=>$account_number,
            "narration"=>$narration,"currency"=>$currency,        "credit_card_number"=>$credit_card,"debit_card_number"=>$debit_card,
            "updated_date"=>$updated_on,"id"=>$id
                ]);
            
            if($stmt){
                //Inseting in Audit Table
                $insertqry="INSERT INTO `audit`(`userid`,`entryid`,`table_log`,`fields`,`old_value`,`new_value`,`created_date`) VALUES            (:userid,:entryid,:table_log,:fields,:old_value,:new_value,:created_date)";
                $stmt11 = $con->prepare($insertqry);
                $stmt11->execute(["userid"=>$_SESSION['userid'],"entryid"=>$id,"table_log"=>$table_log,"fields"=>$updatedfields,"old_value"=>$oldvalues,"new_value"=>$newvalues,"created_date"=>$added_on
                ]);
                echo "success";
            }
            else{
                echo "fail";
            }
        }
   }
?>