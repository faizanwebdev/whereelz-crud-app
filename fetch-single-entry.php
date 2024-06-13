<?php
session_start();
include 'config-pdo.php';

if (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
	$id = htmlspecialchars($_REQUEST['id']);
    
    $query = "SELECT * FROM entries WHERE id = '$id'";
    $stmt1 = $con->prepare($query);
    $stmt1->execute();
    $count = $stmt1->rowCount();
    
    if ($count == 1) {
      if ($row = $stmt1->fetch()) {
          
        $output = "
         
                    <form method='POST' id='edit' name='edit' action='updateentry.php'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Account Number <strong class='text-danger'>**</strong></label>
                              <input type='hidden' id='id' name='id' value='$row->id'>
                              <input type='text' id='account_number' name='account_number' class='form-control' placeholder='Enter Account Number' value='$row->account_number' required>
                              <input type='hidden' id='old_account_number' name='old_account_number' value='$row->account_number'>
                            </div>
                          </div>
                          <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Narration <strong class='text-danger'>**</strong></label>
                              <input type='text' id='narration' name='narration' class='form-control' placeholder='Enter Narration' value='$row->narration' required>
                              <input type='hidden' id='old_narration' name='old_narration' value='$row->narration'>
                            </div>
                          </div>
                          <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Currency <strong class='text-danger'>**</strong></label>
                              <input type='text' id='currency' name='currency' class='form-control' placeholder='Enter Currency' value='$row->currency' required>
                              <input type='hidden' id='old_currency' name='old_currency' value='$row->currency'>
                            </div>
                          </div>
                        <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Credit Card Number <strong class='text-danger'>**</strong></label>
                              <input type='text' id='credit_card' name='credit_card' class='form-control' placeholder='Enter Credit Card Number' value='$row->credit_card_number' required>
                            </div>
                            <input type='hidden' id='old_credit_card' name='old_credit_card' value='$row->credit_card_number'>
                          </div>
                          
                          <div class='col-md-12'>
                            <div class='form-group'>
                              <label for='title'>Debit Card Number <strong class='text-danger'>**</strong></label>
                              <input type='text' id='debit_card' name='debit_card' class='form-control' placeholder='Enter Debit Card Number' value='$row->debit_card_number' required>
                            </div>
                            <input type='hidden' id='old_debit_card' name='old_debit_card' value='$row->debit_card_number'>
                          </div>
                        
                    </div>
                    <button class='btn btn-primary update' onclick='return update()' type='submit' name='updateentry' id='updateentry'>Update</button>
                    </form>";
        

          echo $output;
      }
    }
}
?>