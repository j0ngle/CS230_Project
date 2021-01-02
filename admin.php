<?php 

/**************************************
 * Main page for the administrator user 
 * to interact with and go to the
 * necessary pages to add game entries,
 * review edits, and review additions to
 * either accept or reject them
 **************************************/


require 'includes/header.php';
require 'includes/dbhandler.php';
?>

<main>
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="css/gallery.css">
<script src="js/upload-display.js"></script>

<?php

//checks to see that the session UID is set and that the value
//of it is 0, meaning they are the admin user and will be granted access
//to the page.
if (isset($_SESSION['uid']) && $_SESSION['uid'] == 0) {
?>    

<main class = "container">
	<h1 style="margin-bottom: 20px; margin-top:20px; text-align:center;">Admin Page</h1>

	<div class="gallery-container">
		<div class="card">
			<a href="editaccept.php">
				<img src="images/edit.png">
				<h3>Review Edits</h3>
				<p>View requested page edits and choose to accept or decline them.</p>
			</a>
		</div>
		<div class="card">
			<a href="addaccept.php">
				<img src="images/balance.png">
				<h3>Review Additions</h3>
				<p>View requested game additions and choose to accept or decline.</p>
			</a>
		</div>
		<div class="card">
			<a href="directadd.php">
				<img src="images/plus-sign.png">
				<h3>Direct Add</h3>
				<p>Use the add request form to manually add games directly to the site.</p>
			</a>
		</div>
	</div>

</main>

<?php 

//if not the admin user, they will be redirected back to the home page
}else{
    header("Location: ../index.php");
    exit();
}
?>

