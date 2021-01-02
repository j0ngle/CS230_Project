<!-- 
addaccept.php
    - this page displays all the add requests and allows the admin to accept or deny them
    - only accessible by admins
    - connects to add-game-helper.php
-->

<?php 
require 'includes/header.php';
?>

<main>
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="css/gallery.css">
<script src="js/upload-display.js"></script>
<?php
if (isset($_SESSION['uid']) && $_SESSION['uid'] == 0) { // check if it's an admin
?>    

<main class = "container">
	<h1 style="margin-bottom: 20px; margin-top:20px; text-align:center;">Addition Approval Page</h1>

	<div class="gallery-container">
	<?php
            // pulls all the addition requests from the database
			include_once 'includes/dbhandler.php';

			$sql = "SELECT * FROM addition_requests";

    		$stmt = mysqli_stmt_init($conn);

    		if (!mysqli_stmt_prepare($stmt, $sql)) {
    			echo 'SQL FAILURE';
    		}
    		else {
    			mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				
                $count = 0; // displays all the addition requests gallery style with accept and reject buttons
    			while ($row = mysqli_fetch_assoc($result)) {
                    $count = $count + 1;
    				echo '<div class="card">
    					<a href="preview.php?id='.$row['request_id'].'">
    						<img src="images/'.$row["game_pic"].'">
    						<h3>'.$row["title"].'</h3>
    						<p>'.$row["descript"].'</p>
    					</a>
    					<form id="review-form" action="includes/add-game-helper.php" method="post">
    						<input type="hidden" name="accept" id="accept" value="'.$row['request_id'].'">
	    					<button class="btn btn-lg btn-success btn-block" id="accept-request" name="accept-request">Accept</button>
	    				</form>
	    				<form id="accept-form" action="includes/add-game-helper.php" method="post">
	    					<input type="hidden" name="reject" id="reject" value="'.$row['request_id'].'">
	    					<button class="btn btn-lg btn-danger btn-block" id="reject-request" name="reject-request">Reject</button>
	    				</form>
    				</div>';
    			}

                if ($count == 0) { // if there are no requests, display this message
                    echo '<p align="center" style="margin-bottom: 150px; margin-top:15px;">No addition requests to review at this time, check back later.</p>';
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