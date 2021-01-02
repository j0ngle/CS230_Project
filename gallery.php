<!-- 
gallery.php
    - this page displays all the games that are on gamerfax presented as cards
-->

<?php
require 'includes/header.php';
require 'includes/dbhandler.php';
?>

<main>
<link rel="stylesheet" href="css/gallery.css">
    <h1>Games</h1>

<!-- Dropdown -->
<div class="row">
	<div class="mx-auto">
		<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Filter Tags
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

				<?php

					$sql = "SELECT DISTINCT tag1, tag2, tag3, tag4, tag5
							FROM tags";
					$stmt = mysqli_stmt_init($conn);
					$query = mysqli_query($conn, $sql);
					$tagArr = array();
					while($row = mysqli_fetch_assoc($query)) {
						if (!in_array($row['tag1'], $tagArr)) {
							array_push($tagArr, $row['tag1']);
						}
						if (!in_array($row['tag2'], $tagArr)) {
							array_push($tagArr, $row['tag2']);
						}
						if (!in_array($row['tag3'], $tagArr)) {
							array_push($tagArr, $row['tag3']);
						}
						if (!in_array($row['tag4'], $tagArr)) {
							array_push($tagArr, $row['tag4']);
						}
						if (!in_array($row['tag5'], $tagArr)) {
							array_push($tagArr, $row['tag5']);
						}
					}

					asort($tagArr);
					foreach ($tagArr as &$t) {
						echo '<a class="dropdown-item" href="gallery.php?id='.$t.'">'.$t.'</a>';
					}
				?>
			</div>
		</div>
	</div>
	
	<!-- 
This div below filters by console
-->
	
	<div class="mx-auto">
		<div class="dropdown">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Filter Console
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="gallery.php?id=xbox_link">Xbox</a>
					<a class="dropdown-item" href="gallery.php?id=ps_link">Playstation</a>
					<a class="dropdown-item" href="gallery.php?id=steam_link">PC</a>
					<a class="dropdown-item" href="gallery.php?id=nintendo_link">Nintendo Switch</a>
				</div>
			</div>
		</div>
</div>

<!-- Gallery 
- If a filter is selected, the filter executes a query to database to present the correct results based on query
-->
    	<div class="gallery-container">
    		<?php

			if (isset($_GET['id'])) {
				$tag = $_GET['id'];
				if (($tag == "ps_link") || ($tag == "xbox_link") || ($tag == "nintendo_link") || ($tag == "steam_link")) {
					$sql = "SELECT * FROM games WHERE $tag <> ''";
				}
				else {
					$sql = "SELECT * FROM games
						WHERE game_id IN (
						SELECT tag_id FROM tags WHERE
							tag1 LIKE '$tag' OR
							tag2 LIKE '$tag' OR
							tag3 LIKE '$tag' OR
							tag4 LIKE '$tag' OR
							tag5 LIKE '$tag'
					)";
				}
		} else {
			$sql = "SELECT * FROM games";
		}

		$stmt = mysqli_stmt_init($conn);

		if (!mysqli_stmt_prepare($stmt, $sql)) {
			echo 'SQL FAILURE';
		} else {
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			while ($row = mysqli_fetch_assoc($result)) {
				echo '<div class="card">
    					<a href="entry.php?id=' . $row['game_id'] . '">
    						<img src="images/' . $row["game_pic"] . '">
    						<h3>' . $row["title"] . '</h3>
    						<p>' . $row["descript"] . '</p>
    					</a>
    				</div>';
			}
		}
		?>
	</div>

	<div class="row">
		<h2 class="mx-auto" style="padding-top: 200px; margin-bottom: 32px">Have an addition you'd like to request?</h2>
	</div>

	<div class="row">
		<p class="mx-auto">Click <a href="entryadd.php">here</a> to submit an addition request form!</p>
	</div>

</main>
