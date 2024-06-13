<?php
//Security Parameter for Session hijacking and Cross-Site Scription
$cookieParams = session_get_cookie_params();
session_set_cookie_params(
    $cookieParams['lifetime'],
    $cookieParams['path'],
    $cookieParams['domain'],
    true,  // Secure
    true   // HTTPOnly
);
session_start();

date_default_timezone_set("Asia/Kolkata");

$datenow = date("Y-m-d H:i:s");
$datenowcomment =strtotime($datenow);
$datenowcomment = date('d M Y H:i:s',$datenowcomment);
$dateout = "0000-00-00 00:00:00";

if (isset($_POST['logincheck'])) {
    
	include "config-pdo.php";
	$uname = htmlspecialchars(trim($_POST['username']));
	$upass = htmlspecialchars(trim($_POST['password']));
    
    //Checking if user exist in system or not
	$checkuser = "SELECT * FROM users WHERE username = :username";
	$stmt = $con->prepare($checkuser);
	$stmt->execute(['username' => $uname]);

	if ($stmt) {
	    $result = $stmt->rowCount();
		if ($result == 1){
			while($row = $stmt->fetch()) {
				$password = $row->password;

				if ($upass == $password) {
					$updatelogin = "UPDATE users SET lastlogin = :login WHERE username = :username";
					$stmt1 = $con->prepare($updatelogin);
					$stmt1->execute(['login' => $datenow, 'username' => $uname]);
				
					if ($stmt1) {
						$user_id = $row->id;
                        $user_name = $row->username;
                        $user_role = $row->role;
                        //Session and cookie setting
						$_SESSION['userid'] = $user_id;
						$_SESSION['username'] = $user_name;
						$_SESSION['role'] = $user_role;
                        setcookie('user', $user_name, time() + (86400 * 3), "/");
                        setcookie('userid', $user_id, time() + (86400 * 3), "/");
						echo "success";
					}
					else{
						echo "fail";
					}
				}
				else{
					echo "fail";
				}
			}
		}
		else{
			echo "fail";
		}	
	}
	else{
		echo "fail";
	}
}
else{
	echo "fail";
}
?>