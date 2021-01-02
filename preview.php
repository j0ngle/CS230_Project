<!--
preview.php
	- is basically the same as the game entry page
	- gets the game id from addaccept.php & displays the page from the add request tables
-->

<?php 
	// pulls all the info from the game add request db & stores the relevant rows in variables
	require 'includes/header.php';
	include_once 'includes/dbhandler.php';
	$gid = $_GET['id'];
	$sql = "SELECT * FROM addition_requests WHERE request_id=$gid";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sql)){
		echo 'SQL Failure';
	}
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);

	$sql2 = "SELECT * FROM picture_add_requests WHERE pic_id=$gid;";
	$picQuery = mysqli_query($conn, $sql2);
	$row2 = mysqli_fetch_assoc($picQuery);

	$sql3 = "SELECT * FROM tag_add_requests WHERE tag_id=$gid;";
	$tagQuery = mysqli_query($conn, $sql3);
	$row3 = mysqli_fetch_assoc($tagQuery);

?>

<!-- alert to redirect back to addaccept.php -->
<div class="alert alert-warning navbar-fixed-bottom" role="alert" align="center">
  <a class="alert-link">Notice:</a> <em>You are currently viewing the preview of a game page that has not yet been added. Click <a class = "alert-link" href="addaccept.php">here</a> to return to the decision page.</em>
</div>

<!-- this is all duplicate code from entry.php except the review form is disabled -->
<main class = "container">
<link rel="stylesheet" href="css/entry.css">
<div class="row">
	<div class="game-info">
		<h1 style="font-family:'Consolas'">X/5GP</h1>

		<div id="slides" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#slides" data-slide-to="0" class="active"></li>
				<li data-target="#slides" data-slide-to="1"></li>
				<li data-target="#slides" data-slide-to="2"></li>
			</ol>
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img src="images/game_entry_images/<?php echo $row2['pic1']?>" class="d-block mx-auto" style="width:960px; height:540px">
				</div>
				<div class="carousel-item">
					<img src="images/game_entry_images/<?php echo $row2['pic2']?>" class="d-block mx-auto" style="width:960px; height:540px">
				</div>
				<div class="carousel-item">
					<img src="images/game_entry_images/<?php echo $row2['pic3']?>" class="d-block mx-auto" style="width:960px; height:540px">
				</div>
			</div>
			<a class="carousel-control-prev" href="#slides" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#slides" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
			</div>

		<div class="description">
			<h1><?php echo $row['title']?></h1>
			<p><?php echo $row['descript'] ?></p>
			<?php echo '
				<a class="btn btn-outline-secondary btn-sm" href="#" role="button">'.$row3['tag1'].'</a>
				<a class="btn btn-outline-secondary btn-sm" href="#" role="button">'.$row3['tag2'].'</a>
				<a class="btn btn-outline-secondary btn-sm" href="#" role="button">'.$row3['tag3'].'</a>
				<a class="btn btn-outline-secondary btn-sm" href="#" role="button">'.$row3['tag4'].'</a>
				<a class="btn btn-outline-secondary btn-sm" href="#" role="button">'.$row3['tag5'].'</a>
				'
			?>
		</div>
	</div>

</div>

<!-- Links -->
<div class="row">
	<h1 class="break mx-auto">Store links</h1>
</div>

<div class="row">
	<div class="mx-auto">
	<div class="links">
		<?php
		// Initializing pad to 0 and updating it to 128 after every if call allows entries that do not
		// have a PC release to center properly
			$pad = 0;
			if ($row['steam_link'] != null) {
				echo '<div><a href="'.$row['steam_link'].'" target="_blank">
					<img src="images/PC.jpg" style="border-radius:150px; width:8vw; height:8vw;" alt="steam_link">
					</a></div>';
					$pad = 128;
			}
			if ($row['xbox_link'] != null) {
				echo '<div><a href="'.$row['xbox_link'].'" target="_blank" style="padding-left:'.$pad.'px">
					<img src="images/xbox.png" style="border-radius:50px; width:8vw; height:8vw;" alt="xbox_link">
					</a></div>';
					$pad = 128;
			}
			if ($row['ps_link'] != null) {
				echo '<div><a href="'.$row['ps_link'].'" target="_blank" style="padding-left:'.$pad.'px">
					<img src="images/PS.jpg" style="border-radius:150px; width:8vw; height:8vw;" alt="ps_link">
					</a></div>';
					$pad = 128;
			}
			if ($row['nintendo_link'] != null) {
				echo '<div><a href="'.$row['nintendo_link'].'" target="_blank" style="padding-left:'.$pad.'px">
					<img src="images/ninswitch.png" style="border-radius:150px; width:8vw; height:8vw;" alt="ps_link">
					</a></div>';
					$pad = 128;
			}
		?>
	</div>
	</div>
</div>

<div class="row">
	<h1 class="break mx-auto">Reviews</h1>
</div>

<div class="container" align="center" style="max-width: 800px">
	<div class="form-group" style="margin-top:40px;">
	    <label class="title-label" for="review-title" style="font-size: 16px; font-weight: bold; margin-right:20px">Leave a Review!</label>
	    <input type="range" class="custom-range" min="0" max="5" step="0.5" id="formControlRange">
	    <input type="text" name="review-title" id="review-title" style="width: 100%; margin-bottom: 10px;">
	    <textarea class="form-control" id="review-text" name="review" cols="50" rows="3" placeholder="Enter a comment..."></textarea>
	</div>
	<div class="form-group"> 
	    <button class="btn btn-outline-success" style="width: 100%">Submit</button>
	</div>
</div>


<div style="margin-bottom:100px;"></div>

</main>