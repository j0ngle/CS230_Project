<!-- 
editaccept.php
    - a page that displays all the edit requests made to the website
    - only accessible by admins who can choose to accept or reject edits
    - pages can be previewed (previewedits.php)
    - pages can also be viewed as they currently are
-->

<?php 
require 'includes/header.php';
?>

<main>
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="css/gallery.css">
<script src="js/upload-display.js"></script>
<?php
if (isset($_SESSION['uid']) && $_SESSION['uid'] == 0) { // make sure it's the admin account accessing the page
?>    

<main class = "container">
	<h1 style="margin-bottom: 20px; margin-top:20px; text-align:center;">Edit Approval Page</h1>

	<div class="gallery-container">
	<?php
            // pull the general game info from the edit request table
			include_once 'includes/dbhandler.php';

			$sql = "SELECT * FROM edit_requests";

    		$stmt = mysqli_stmt_init($conn);

    		if (!mysqli_stmt_prepare($stmt, $sql)) { // make sure everything is "kosher"
    			header("Location: oops.php");
    		}
    		else { // execute the command
    			mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				
                $count = 0;
    			while ($row = mysqli_fetch_assoc($result)) { // display all the edit requests like the gallery with edit and accept buttons
                    $count = $count + 1;
                    // when the accept or reject buttons are pressed, control is redirected to add-game-helper.php
    				echo '<div class="card">
    					<a href="previewedits.php?id='.$row['request_id'].'">
    						<img src="images/'.$row["game_pic"].'">
    						<h3>'.$row["title"].'</h3>
    						<p>'.$row["descript"].'</p>
    					</a>
                        <a href = "entry.php?id='.$row['game_id'].'">
                            <button class="btn btn-lg btn-warning btn-block" style="margin-bottom: 16px;">View Original</button>
                        </a>
    					<form id="review-form" action="includes/add-game-helper.php" method="post">
    						<input type="hidden" name="accept-edits" id="accept-edits" value="'.$row['request_id'].'">
	    					<button class="btn btn-lg btn-success btn-block" id="accept-edit-req" name="accept-edit-req">Accept</button>
	    				</form>
	    				<form id="accept-form" action="includes/add-game-helper.php" method="post">
	    					<input type="hidden" name="reject-edits" id="reject-edits" value="'.$row['request_id'].'">
	    					<button class="btn btn-lg btn-danger btn-block" id="reject-edit-req" name="reject-edit-req">Reject</button>
	    				</form>
    				</div>';
    			}

                if ($count == 0) { // if there are no edit requests, show a default message
                    echo '<p align="center" style="margin-bottom: 150px; margin-top: 15px;">No edit requests to review at this time, check back later.</p>';
                }
    		}
    	?>
    </div>

    <p align="center">Click <a href='admin.php'>here</a> to return to the admin panel</p>

</main>

<?php 
}else{
    header("Location: ../index.php");
    exit();
}
?>
