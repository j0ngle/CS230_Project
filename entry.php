<!-- 
Game Entry Display Page
	Linked to by gallery.php or index.php
	When linked to, the desired game id is passed in the url
	Game id info is pulled from the database & displayed in a webpage
	Info includes: name, description, tags, pictures, purchase links, reviews
	New reviews can also be left on a game entry
-->

<?php
	# Fetch game info from the database to be displayed 
	require 'includes/header.php';
	include_once 'includes/dbhandler.php';

	# general info fetch
	$gid = $_GET['id'];
	$sql = "SELECT * FROM games WHERE game_id=$gid;";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: oops.php");
	}
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);

	# picture data fetch
	$sql2 = "SELECT * FROM pictures WHERE pic_id=$gid;";
	$picQuery = mysqli_query($conn, $sql2);
	$row2 = mysqli_fetch_assoc($picQuery);

	# tag data fetch
	$sql3 = "SELECT * FROM tags WHERE tag_id=$gid;";
	$tagQuery = mysqli_query($conn, $sql3);
	$row3 = mysqli_fetch_assoc($tagQuery);

	# links data fetch
	$sql4 = "SELECT steam_link, xbox_link, ps_link, nintendo_link FROM games WHERE game_id=$gid;";
	$tagQuery = mysqli_query($conn, $sql4);
	$row4 = mysqli_fetch_assoc($tagQuery);

	if (empty($row2) || empty($row3) || empty($row4)) {
		header("Location: oops.php");
	}

?>

<main class = "container">
<link rel="stylesheet" href="css/entry.css">
<div class="row">
	<div class="game-info">

<!-- Calculate Gamer Points Rating -->
	<h1 style="font-family:'Consolas'">
		<?php
			// this is just code to take the average of the rating number column that I copied from lab
			$sqlAvg = "SELECT AVG(rating_num) AS AVGRATE FROM reviews WHERE game_id='$gid';";

			$query10 = mysqli_query($conn, $sqlAvg);
			$row10 = mysqli_fetch_array($query10);

			$avg = round($row10['AVGRATE'],1);

			// this is a query to figure out if any reviews actually exist for the game entry
			$sqlCount = "SELECT * FROM reviews WHERE game_id='$gid';";
			$query = mysqli_query($conn, $sqlCount);

			$count = 0;
			while (mysqli_fetch_assoc($query)) {
				$count = $count + 1;
			}

			if ($count != 0) {
				echo $avg.'/5 Gamer Points';
			} else {
				echo 'X/5 Gamer Points';
			}
		?>
	</h1>	
		

<!-- Carousel -->
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

<!-- Description -->
		<div class="description">
			<h1><?php echo $row['title']?></h1>
			<p><?php echo $row['descript'] ?></p>
			<?php echo '
				<a class="btn btn-outline-secondary btn-sm" href="gallery.php?id='.$row3['tag1'].'" role="button">'.$row3['tag1'].'</a>
				<a class="btn btn-outline-secondary btn-sm" href="gallery.php?id='.$row3['tag2'].'" role="button">'.$row3['tag2'].'</a>
				<a class="btn btn-outline-secondary btn-sm" href="gallery.php?id='.$row3['tag3'].'" role="button">'.$row3['tag3'].'</a>
				<a class="btn btn-outline-secondary btn-sm" href="gallery.php?id='.$row3['tag4'].'" role="button">'.$row3['tag4'].'</a>
				<a class="btn btn-outline-secondary btn-sm" href="gallery.php?id='.$row3['tag5'].'" role="button">'.$row3['tag5'].'</a>
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


<!-- Reviews -->
<div class="row">
	<h1 class="break mx-auto">Reviews</h1>
</div>

<!-- Display Reviews From DB -->

<?php
	$sql = "SELECT * FROM reviews WHERE game_id = ?;";
	$stmt = mysqli_stmt_init($conn);

	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: oops.php");
	}
	else {
		mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s", $gid);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		while ($r = mysqli_fetch_assoc($result)) {
			echo '
			<div class="row" style="margin-bottom:10px;">
				<div class="col"></div>
				<div class="col-10" style="outline-style:solid; outline-width:1px; margin-left: 10px; margin-right: 10px;">
					<div class="row">
						<h5 class="col" style="margin-top:20px">'.$r['title'].'</h5>
						<h5 class="col-2" style="margin-top:20px; text-align:right; margin-right: 5px">'.$r['rating_num'].'/5 GP</h5>
					</div>
					<p>Posted <a>'.$r['rev_date'].'</a> by <a>u/'.$r['uname'].'</a></p>
					<p class="review-text" style="margin-bottom:20px">'.$r['review_text'].'</p>
				</div>
				<div class="col"></div>
			</div>';
		}

		if ($count == 0) {
			echo '<p align="center">No reviews yet! Be the first to review '.$row['title'].'</p>';
		}
	}
?>

<!-- Form to Write New Reviews, connects to includes/review-helper.php -->
<form id="review-form" action="includes/review-helper.php" method="post">
	<div class="container" align="center" style="max-width: 800px">
		<div class="form-group" style="margin-top:40px;">
		    <label class="title-label" for="review-title" style="font-size: 16px; font-weight: bold; margin-right:20px">Leave a Review!</label>
		    <input type="range" class="custom-range" name="rating" id="rating" min="0" max="5" step="0.5" id="formControlRange">
		    <input type="text" name="review-title" id="review-title" style="width: 100%; margin-bottom: 10px;">
		    <textarea class="form-control" id="review-text" name="review" cols="50" rows="3" placeholder="Enter a comment..."></textarea>
		    <input type="hidden" name="item_id" id="item_id" value=<?php echo "'$gid'"?> />
		</div>
		<div class="form-group"> 
		    <button class="btn btn-outline-success" id="review-submit" name="review-submit" type="submit" style="width: 100%">Submit</button>
		</div>
	</div>
</form>


<!-- Link to edit request form -->
<div class="row">
	<h2 class="mx-auto" style="padding-top: 200px; margin-bottom: 32px">Have an edit you'd like to submit?</h2>
</div>

<div class="row">
	<p class="mx-auto">Click <a href="entryedit.php?id=<?php echo $gid?>">here</a> to submit an edit request form!</p>
</div>

<div style="margin-bottom:100px;"></div>

</main>
