
<!-- 
index.php
	- this page is the main page of the site.
    - it shows 4 different animated cards for each gaming console to view related games when clicked
      , and it is hyperlinked to filtered game pages based on console.
    - it shows 3 recently added games to the site and hyperlinked to its game review. 
    - it shows 3 most reviewed games in the site and hyperlinked to its game review.
    - accessible by all.
-->
<link rel="stylesheet" href="css/main.css">
<main>
<?php
    require "includes/header.php"
    ?>
    <div class="container">
        <div class="mid-container">
            <div class="card" style="width:400px">
                <div class="imgBx">
                    <a href="gallery.php?id=ps_link"> <img src="images/PS.jpg"> </a> <!--link to PS games-->
                </div>
                <div class="content">
                    <h2>PS Games</h2>
                    <p> Select this console to view related games.</p>
                </div>
            </div>

            <div class="card" style="width:400px">
                <div class="imgBx">
                    <a href="gallery.php?id=xbox_link"><img src="images/xbox.jpg"> </a> <!--link to xbox games-->
                </div>
                <div class="content">
                    <h2>Xbox Games</h2>
                    <p> Select this console to view related games to this console.</p>
                </div>
            </div>
        </div>
        <div class="mid-container">
            <div class="card" style="width:400px">
                <div class="imgBx">
                    <a href="gallery.php?id=nintendo_link"> <img src="images/ninswitch.png"> </a> <!--link to nintendo games-->
                </div>
                <div class="content">
                    <h2>Nintendo Games</h2>
                    <p> Select this console to view related games.</p>
                </div>
            </div>
            
            <div class="card" style="width:400px">
                <div class="imgBx">
                    <a href="gallery.php?id=steam_link"><img src="images/PC.jpg"> </a> <!--link to PC games-->
                </div>
                <div class="content">
                    <h2>PC Games</h2>
                    <p> Select this console to view related games to this console.</p>
                </div>
            </div>
        </div>
        

        <div class="headers">
            <h3 class="headers-title">Recently Added</h3> <!--list of 3 recent games added to site-->
        </div>

        <div class="mid-container"> 
            <?php
            include_once 'includes/dbhandler.php';
            $sql = "SELECT * FROM games ORDER BY game_id DESC LIMIT 3";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)){
                echo 'SQL Failure';
            }
            else {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)){
                echo '<div class="box">
                        <div class="imgBx2">
                                <img src="images/'.$row['game_pic'].'">
                        </div>
                        <a href="entry.php?id='.$row['game_id'].'">
                            <div class="content2" style="color:black">
                                <h3>'.$row['title'].'</h3>
                                <p> '.$row['descript'].'</p>
                            </div>
                        </a>
                     </div>';
                }
            }
            ?>
        </div>

        <div class="headers2">
            <h3 class="headers-title">Most Reviewed</h3> <!--list of 3 most reviewed games in the site-->
        </div>

        <div class="mid-container">
            <?php
            include_once 'includes/dbhandler.php';
            $sql = "SELECT game_id FROM reviews";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo 'SQL Failure';
            }
            else {
                // this segment of code makes an associative array where: game_id => # of reviews
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $freq_tracker = [];
                while ($row = mysqli_fetch_assoc($result)){
                    $gid = implode($row);
                    if (array_key_exists($gid, $freq_tracker)) {
                        $freq_tracker[$gid] = $freq_tracker[$gid] + 1;
                    } else {
                        $freq_tracker[$gid] = 1;
                    }
                }

                arsort($freq_tracker, 1); // sort in descending order by # of reviews
                $keys = array_keys($freq_tracker); // get the array as keys instead of values (because the keys are the game ids)

                for ($i = 0; $i < 3; $i++) {
                    $gid = implode(array_slice($keys, $i, 1)); // display the first 3 games in the array
                    $sql = "SELECT * FROM games WHERE game_id=$gid;";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)){
                        echo 'SQL Failure';
                    }
                    else {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
                        echo '<div class="box">
                                <div class="imgBx2">
                                        <img src="images/'.$row['game_pic'].'">
                                </div>
                                <a href="entry.php?id='.$row['game_id'].'">
                                    <div class="content2" style="color:black">
                                        <h3>'.$row['title'].'</h3>
                                        <p> '.$row['descript'].'</p>
                                    </div>
                                </a>
                             </div>';
                    }
                }

            }
            ?>
        </div>

    </div>
</main>
