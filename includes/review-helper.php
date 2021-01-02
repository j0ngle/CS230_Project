<?php 

/****************************************************************************
* review-helper.php                                                         *
*	- handles post requests from entry.php whenever a review is left        *
* 	- 'review-submit' is the name of the button to post a review            *
* 	- reviews can be submitted anonymously or by a user of the site         *
*	- reviews have a title, date, review text, and rating to be displayed   *
****************************************************************************/

require_once 'dbhandler.php';
date_default_timezone_set('UTC');

// make sure the button was pressed
if(isset($_POST['review-submit'])) {
	session_start();

	if (!empty($_SESSION)) {
		$uname = $_SESSION['username'];
	} else {
		$uname = 'Anonymous';
	}
	$title = $_POST['review-title']; // connects to the title input of the review
	$date = date('Y-m-d H:i:s');     // current date in y-m-d hour:min:sec format
	$review = $_POST['review'];      // content of the review (the big text box)
	$game_id = $_POST['item_id'];    // id of the game being reviewed (invisible input)
	$rating = $_POST['rating'];      // rating out of 5 (left by the slider)

	// we want to insert all this info into the reviews table with its associated game_id so it can be displayed on that game's page based on id
	$sql = "INSERT INTO reviews (game_id, uname, title, review_text, rev_date, rating_num) VALUES (?, ?, ?, ?, ?, ?);";
	$stmt = mysqli_stmt_init($conn);
	
	if (!mysqli_stmt_prepare($stmt, $sql)) { // prepare the sql
        header("Location: ../login.php?error=SQLInjection");
        exit(); // error checking for sql failures
    } else {
    	// execute the sql
    	$stmt->bind_param("ssssss", $game_id, $uname, $title, $review, $date, $rating);
        $stmt->execute();
        $stmt->store_result();
        header("Location: ../entry.php?id=$game_id");
    }

}

