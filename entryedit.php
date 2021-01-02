<!-- 
entryedit.php
	- same as directadd and entryadd
	- it's a form to submit an entry edit request to the database
	- inputs are filled in automatically with the already existing game entry info (except images)
	- connects to edit-request-helper.php
-->

<?php 
	// get all the current game info
	require 'includes/header.php';
	include_once 'includes/dbhandler.php';
	$gid = $_GET['id'];
	$sql = "SELECT * FROM games WHERE game_id=$gid";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)){
                echo 'SQL Failure';
			}
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);

	$sql2 = "SELECT * FROM pictures WHERE pic_id=$gid;";
	$picQuery = mysqli_query($conn, $sql2);
	$row2 = mysqli_fetch_assoc($picQuery);

	$sql3 = "SELECT * FROM tags WHERE tag_id=$gid;";
	$tagQuery = mysqli_query($conn, $sql3);
	$row3 = mysqli_fetch_assoc($tagQuery);

?>

<!-- Input forms filled with the already existing info -->
<main class = "container">
	<h1 align="centera" style="margin-bottom: 20px; margin-top: 50px;">Entry Edit Request:</h1>
	<form enctype="multipart/form-data" id="review-form" action="includes/edit-request-helper.php" method="post">
		<div class="container" align="center">
			<div class="form-group" style="margin-top:80px;">
				<label for="review-title">Title & Description</label>
			    <input type="text" name="game-title" id="review-title" style="width: 100%; margin-bottom: 10px;" 
			    		required <?php echo 'value="'.$row['title'].'"' ?>>
			    <textarea class="form-control" id="review-text" name="game-descript" cols="50" rows="3" required style="margin-bottom: 10px;">
			    	<?php echo $row['descript'] ?>
			    </textarea>
			   
			    <label for="image" style="margin-top: 40px;">Game Page Images</label>
				<input type="file" name="image1" id="image1" required class="form-control">
				<input type="file" name="image2" id="image2"  required class="form-control">
				<input type="file" name="image3" id="image3" required class="form-control">

				<label for="image" style="margin-top: 40px;">Game Cover Image</label>
				<input type="file" name="cover-image" id="cover-image" class="form-control">

				<label for="image" style="margin-top: 40px;">Store Links</label>
				<input type="text" name="steam-link"  id="review-link"  style="width: 100%; margin-bottom: 10px;"
						<?php echo 'value="'.$row['steam_link'].'"' ?> >
			    <input type="text" name="xbox-link" id="review-link2" style="width: 100%; margin-bottom: 10px;"
			    		<?php echo 'value="'.$row['xbox_link'].'"' ?> >
			    <input type="text" name="ps-link" id="review-link3" style="width: 100%; margin-bottom: 10px;"
			    		<?php echo 'value="'.$row['ps_link'].'"' ?> >
				<input type="text" name="nintendo-link" id="review-link4" style="width: 100%; margin-bottom: 10px;"
						<?php echo 'value="'.$row['nintendo_link'].'"' ?> >

				<label for="tag-title">Tags</label>
				<input type="text" name="tag-1" id="tag-1" required style="width: 100%; margin-bottom: 10px;" 
						<?php echo 'value="'.$row3['tag1'].'"' ?> >
				<input type="text" name="tag-2" id="tag-2" required style="width: 100%; margin-bottom: 10px;"
						<?php echo 'value="'.$row3['tag2'].'"' ?> >
				<input type="text" name="tag-3" id="tag-3" required style="width: 100%; margin-bottom: 10px;" 
						<?php echo 'value="'.$row3['tag3'].'"' ?> >
				<input type="text" name="tag-4" id="tag-4" required style="width: 100%; margin-bottom: 10px;" 
						<?php echo 'value="'.$row3['tag4'].'"' ?> >
				<input type="text" name="tag-5" id="tag-5" required style="width: 100%; margin-bottom: 10px;"
						<?php echo 'value="'.$row3['tag5'].'"' ?> >

				<input type="hidden" name="game_id"  id="game_id">


			</div>
			<div class="form-group"> 
			    <button class="btn btn-outline-success" id="add-submit" name="add-submit" type="submit" style="width: 100%; height: 100px; margin-top: 40px; font-size: 30px">Submit Entry Edit Request</button>
			</div>
		</div>
	</form>
</main>

<!-- inputs the defualt game id value -->
<script type="text/javascript">
	var id = <?php echo $gid;?>;
	document.getElementById('game_id').value = parseInt(id);
</script>