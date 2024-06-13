<?php
include "config-pdo.php";

//Count for Entries Table
function entries_count(){
  global $con;
    
  if($_SESSION['role'] == "Admin"){
      $entries_count = "SELECT COUNT(id) AS entry_count FROM entries";
      $stmt = $con->prepare($entries_count);
      $stmt->execute();
      $run_count = $stmt->rowCount();
        if ($run_count == 1) {
          if ($row = $stmt->fetch()) {
            $number_entries = $row->entry_count;
            echo $number_entries;
          }
        }
  }
  else{
      $entries_count = "SELECT COUNT(id) AS entry_count FROM entries  WHERE userid = :userid";
      $stmt = $con->prepare($entries_count);
      $stmt->execute(['userid' => $_SESSION['userid']]);
      $run_count = $stmt->rowCount();
        if ($run_count == 1) {
          if ($row = $stmt->fetch()) {
            $number_entries = $row->entry_count;
            echo $number_entries;
          }
        }
  }
  
}

//Count for Users Table
function users_count(){
  global $con;
    
  $users_count = "SELECT COUNT(id) AS user_count FROM users";
  $stmt = $con->prepare($users_count);
  $stmt->execute();
  $run_count = $stmt->rowCount();
  if ($run_count == 1) {
    if ($row = $stmt->fetch()) {
        $number_users = $row->user_count;
        echo $number_users;
    }
  }
  
}

?>