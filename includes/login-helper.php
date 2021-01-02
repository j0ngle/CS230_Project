<?php

/*********************************************
 * login-helpher.php is used to log a user in
 * when they enter their credentials. It
 * interfaces with the database to compare and
 * either authenticate or deny access.
 ********************************************/

 //File is triggered when user clicks on the login
 //button and sets it through the $_POST variable
if(isset($_POST["login-submit"])) {
	require "dbhandler.php";
	$uname_email = $_POST["uname"];
	$passw = $_POST["pwd"];

	if(empty($uname_email) || empty($passw)) {
		header("Location: ../login.php?error=EmptyField");
		exit();
	}

	//Preparing SQL statement and connect to the database
	$sql = "SELECT * FROM users WHERE uname=? OR email=?;";
	$stmt = mysqli_stmt_init($conn);

	//prepares statement and gives an error if detects
	//a SQL injection
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: ../login.php?error=SQLInjection");
		exit();
	}
	
	else {

		//SQL statement is binded and executed
		mysqli_stmt_bind_param($stmt, "ss", $uname_email, $uname_email);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$data = mysqli_fetch_assoc($result);

		if(empty($data)) {
			header("Location: ../login.php?error=UserDNE");
			exit();
		}
		else {

			//verifies the password and creates a new session
			$pass_check = password_verify($passw, $data["password"]);
			if ($pass_check) {
				session_start();
				$_SESSION["uid"] = $data["uid"];
				$_SESSION["fname"] = $data["fname"];
				$_SESSION["username"] = $data["uname"];

				if ($_SESSION['uid'] == 0)
					header("Location: ../admin.php?login=success");
				else
					header("Location: ../profile.php?login=success");
					
				exit();
			}
			else {
				header("Location: ../login.php?error=IncorrectPassword");
				exit();
			}
		}
	}

}
else {
	header("Location: ../login.php");
	exit();
}