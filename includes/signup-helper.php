<?php

/**************************************************
 * sigup-helper.php is used to sign a user up
 * when they submit their sign up form. It connects
 * to the database and inserts a new user with their
 * information.
 ***************************************************/

 //checks that the submit button was pressed
if (isset($_POST['signup-submit'])) {
	require 'dbhandler.php';

	//collects all the signup information and stores in variables
	$username = $_POST['uname'];
	$email = $_POST['email'];
	$pass = $_POST['pwd'];
	$pass2 = $_POST['con-pwd'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$genre = $_POST['genre'];
	$phone = $_POST['phone'];

	if ($pass !== $pass2) {
		header("Location: ../signup.php?error=diffPasswords&fname=".$fname."&lname=".$lname."&uname=".$username);
		exit();
	} else {

		//SQL statment and connection to the database
		$sql = "SELECT uname FROM users WHERE uname=?";
		$stmt = mysqli_stmt_init($conn);

		//prepares SQL statement and ensures protection agaisnt
		//SQL injection
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../signup.php?error=SQLInjection");
			exit();
		} else {

			//SQL statement binded, executed and stored
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$check = mysqli_stmt_num_rows($stmt);

			//checks the database to see if the username is already taken
			if ($check > 0) {
				header("Location: ../signup.php?error=UsernameTaken");
				exit();
			} else {

				//SQL statement for inserting the signup information into the users table in the database
				$sql = "INSERT INTO users (lname, fname, email, uname, password) VALUES (?,  ?, ?, ?, ?)";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: ../signup.php?error=SQLInjection");
					exit();
				} else {

					//hashes the user's passsword using built in function password_hash
					$hashedPass = password_hash($pass, PASSWORD_BCRYPT);
					mysqli_stmt_bind_param($stmt, "sssss", $lname, $fname, $email, $username, $hashedPass);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);

					//Stores username and favorite genre into the profile table in the database
					$sqlimg = "INSERT INTO profile (uname, fav_genre, phone) VALUES (?, ?, ?)";
					$stmt = mysqli_stmt_init($conn);
					mysqli_stmt_prepare($stmt, $sqlimg);
					mysqli_stmt_bind_param($stmt, "sss", $username, $genre, $phone);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);

					header("Location: ../signup.php?signup=success");
					exit();
				}
			}
		}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}

} else {
	header("Location: ../signup-php");
	exit();
}