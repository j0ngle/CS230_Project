<!-- 
entryadd.php
	- has a bunch of inputs to get information from the user
	- all inputted information gets submitted to the db as an add request
	- add requests are stored in the add request table
	- connects to game-request-helper.php
-->

<?php 
require 'includes/header.php';
?>

<main>
<link rel="stylesheet" href="css/admin.css">
<script src="js/upload-display.js"></script>
<?php
if (isset($_SESSION['uid'])) {
?>    

<main class = "container">
	<h1 style="margin-bottom: 20px; margin-top:20px; text-align:center;">Game Addition</h1>

	<!-- The form for inputting all the game entry addition request info -->
	<form enctype="multipart/form-data" id="review-form" action="includes/game-request-helper.php" method="post">
		<div class="container" align="center">
			<div class="form-group" style="margin-top:80px;">
				<label for="review-title">Info</label>
			    <input type="text" name="game-title" id="review-title" style="width: 100%; margin-bottom: 10px;" required placeholder=" Title...">
			    <textarea class="form-control" id="review-text" name="game-descript" cols="50" rows="3" required placeholder="Description..." style="margin-bottom: 10px;"></textarea>
			   
			    <label for="image" style="margin-top: 40px;">Game Page Images</label>
				<input type="file" name="image1" id="image1" required class="form-control">
				<input type="file" name="image2" id="image2"  required class="form-control">
				<input type="file" name="image3" id="image3" required class="form-control">
				<label for="image" style="margin-top: 40px;">Game Cover Image</label>
				<input type="file" name="cover-image" id="cover-image" class="form-control">
				<label for="image" style="margin-top: 40px;">Store Links</label>
				<input type="text" name="steam-link"  id="review-link"  style="width: 100%; margin-bottom: 10px;" placeholder=" PC Link...">
			    <input type="text" name="xbox-link" id="review-link2" style="width: 100%; margin-bottom: 10px;" placeholder=" Xbox Link...">
				<input type="text" name="ps-link" id="review-link3" style="width: 100%; margin-bottom: 10px;" placeholder=" PS Link...">
				<input type="text" name="nintendo-link" id="review-link4" style="width: 100%; margin-bottom: 10px;" placeholder=" Nintendo Link...">
				<label for="tag-title">Tags</label>
				<input type="text" name="tag-1" id="tag-1" required style="width: 100%; margin-bottom: 10px;" placeholder=" Tag...">
				<input type="text" name="tag-2" id="tag-2" required style="width: 100%; margin-bottom: 10px;" placeholder=" Tag...">
				<input type="text" name="tag-3" id="tag-3" required style="width: 100%; margin-bottom: 10px;" placeholder=" Tag...">
				<input type="text" name="tag-4" id="tag-4" required style="width: 100%; margin-bottom: 10px;" placeholder=" Tag...">
				<input type="text" name="tag-5" id="tag-5" required style="width: 100%; margin-bottom: 10px;" placeholder=" Tag...">


			</div>
			<div class="form-group"> 
			    <button class="btn btn-outline-success" id="add-submit" name="add-submit" type="submit" style="width: 100%; height: 100px; margin-top: 40px; font-size: 30px">Submit Game Entry Add Request</button>
			</div>
		</div>
	</form>
</main>

<?php 
}else{
    header("Location: ../index.php");
    exit();
}
?>