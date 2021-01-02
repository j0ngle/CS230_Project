<?php

/**************************************
* The goto php file for adding games  *
*  Connects with:                     *
*       - directadd.php               *
*       - editaccept.php              *
*       - addaccept.php               *
*  Core function:                     *
*       - get game entries in the db  *    
**************************************/

session_start(); // not sure why this is neccessary

require 'dbhandler.php';

// add-submit is the button associated with directadd.php
// this part of the if adds games directly from the game addition form
if (isset($_POST['add-submit'])) {

    // these are all just the variables to store in the database taken from the direct add form
    $title = $_POST['game-title'];
    $descript = $_POST['game-descript'];

    // tag data to store in tags table
    $tag1 = $_POST['tag-1'];
    $tag2 = $_POST['tag-2'];
    $tag3 = $_POST['tag-3'];
    $tag4 = $_POST['tag-4'];
    $tag5 = $_POST['tag-5'];

    // link data to store with main game info
    $steam = $_POST['steam-link'];
    $xbox = $_POST['xbox-link'];
    $ps = $_POST['ps-link'];
    $nintendo = $_POST['nintendo-link'];

    // image data to store in pictures table
    $page1 = $_FILES['image1'];
    $page2 = $_FILES['image2'];
    $page3 = $_FILES['image3'];
    $cover = $_FILES['cover-image']; // stored with main game info (cover image)

    // this stuff pretty much handles the uploading of all images into the images directory
    #page image 1
    $page1name = $page1['name'];
    $destination1 = "../images/game_entry_images/$page1name";

    #page image 2
    $page2name = $page2['name'];
    $destination2 = "../images/game_entry_images/$page2name";

    #page image 3
    $page3name = $page3['name'];
    $destination3 = "../images/game_entry_images/$page3name";
    #cover image
    $cover_name = $cover['name'];
    $cover_destination = "../images/$cover_name";

    // sql statements to insert all the data into the main games table
    // game info is in 3 tables: game, pictures, and tags
    // the auto incremented id in each of the 3 tables must align for everything to work properly
    $sql = "INSERT INTO games (title, descript, game_pic, steam_link, xbox_link, ps_link, nintendo_link) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $sql2 = "INSERT INTO pictures (pic1, pic2, pic3) VALUES (?, ?, ?);";
    $sql3 = "INSERT INTO tags (tag1, tag2, tag3, tag4, tag5) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    $stmt2 = mysqli_stmt_init($conn);
    $stmt3 = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        #header("Location: ../login.php?error=SQLInjection");
        exit();
    } else {
        // this is all just junk to execute the queries
        $stmt->bind_param("sssssss", $title, $descript, $cover_name, $steam, $xbox, $ps, $nintendo);
        $stmt->execute();
        $stmt->store_result();

        mysqli_stmt_prepare($stmt2, $sql2);
        $stmt2->bind_param("sss", $page1name, $page2name, $page3name);
        $stmt2->execute();
        $stmt2->store_result();
        echo "Error: ".mysqli_error($conn);
        mysqli_stmt_prepare($stmt3, $sql3);
        $stmt3->bind_param("sssss", $tag1, $tag2, $tag3, $tag4, $tag5);
        $stmt3->execute();
        $stmt3->store_result();  
        echo "Error: ".mysqli_error($conn);

        move_uploaded_file($page1['tmp_name'], $destination1);
        move_uploaded_file($page2['tmp_name'], $destination2);
        move_uploaded_file($page3['tmp_name'], $destination3);
        move_uploaded_file($cover['tmp_name'], $cover_destination);

        header("Location: ../../gallery.php?gameAddition=Success");
        exit();
    }
} 

// accept-request connects to the accept button associated with each entry in addaccept.php
// this block takes whatever is in the game id for the entry to be added and moves it to the main game entries db
// to move: add all the data to the main db, then delete it all from the addition request db
else if (isset($_POST['accept-request'])) {

    // these queries pull the addition request info from the database
    $id = $_POST['accept'];
    $sql = "SELECT * FROM addition_requests WHERE request_id=?";
    $sql1 = "SELECT * FROM picture_add_requests WHERE pic_id=?";
    $sql2 = "SELECT * FROM tag_add_requests WHERE tag_id=?";
    $stmt  = mysqli_stmt_init($conn);
    $stmt1 = mysqli_stmt_init($conn);
    $stmt2 = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo $id;
        header("Location: ../login.php?error=SQLInjection");
        exit();
    } else {
        // this junk executes the above queries
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);

        mysqli_stmt_prepare($stmt1, $sql1);
        mysqli_stmt_bind_param($stmt1, "s", $id);

        mysqli_stmt_prepare($stmt2, $sql2);
        mysqli_stmt_bind_param($stmt2, "s", $id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); // be sure to store all the results bc they're useful
        $game = mysqli_fetch_assoc($result);

        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $pics = mysqli_fetch_assoc($result1);

        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $tags = mysqli_fetch_assoc($result2);

        // this is all pretty much copied code from direct add
        // effectively this adds the game using the addition request info as if it were a new entry
        $sql = "INSERT INTO games (title, descript, game_pic, steam_link, xbox_link, ps_link, nintendo_link) VALUES (?, ?, ?, ?, ?, ?, ?);";
        $sql2 = "INSERT INTO pictures (pic1, pic2, pic3) VALUES (?, ?, ?);";
        $sql3 = "INSERT INTO tags (tag1, tag2, tag3, tag4, tag5) VALUES (?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        $stmt2 = mysqli_stmt_init($conn);
        $stmt3 = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo $stmt;
            header("Location: ../login.php?error=SQLInjection");
            exit();
        } else {
            // bind the parameters (data taken in from the add request table) & execute the queries to add the entry
            $stmt->bind_param("sssssss", $game['title'], $game['descript'], $game['game_pic'], $game['steam_link'], $game['xbox_link'], $game['ps_link'], $game['nintendo_link']);
            $stmt->execute();
            $stmt->store_result();

            mysqli_stmt_prepare($stmt2, $sql2);
            mysqli_stmt_bind_param($stmt2, "sss", $pics['pic1'], $pics['pic2'], $pics['pic3']);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_store_result($stmt2);

            mysqli_stmt_prepare($stmt3, $sql3);
            mysqli_stmt_bind_param($stmt3, "sssss", $tags['tag1'], $tags['tag2'], $tags['tag3'], $tags['tag4'], $tags['tag5']);
            mysqli_stmt_execute($stmt3);
            mysqli_stmt_store_result($stmt3);

            // these queries delete the add request because we're done using it
            $sql  = "DELETE FROM addition_requests WHERE request_id=?";
            $sql2 = "DELETE FROM picture_add_requests WHERE pic_id=?";
            $sql3 = "DELETE FROM tag_add_requests WHERE tag_id=?";
            $stmt = mysqli_stmt_init($conn);
            $stmt2 = mysqli_stmt_init($conn);
            $stmt3 = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../login.php?error=SQLInjection");
            }
            else {
                // more junk to execute the queries
                mysqli_stmt_bind_param($stmt, "s", $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                mysqli_stmt_prepare($stmt2, $sql2);
                mysqli_stmt_bind_param($stmt2, "s", $id);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_store_result($stmt2);

                mysqli_stmt_prepare($stmt3, $sql3);
                mysqli_stmt_bind_param($stmt3, "s", $id);
                mysqli_stmt_execute($stmt3);
                mysqli_stmt_store_result($stmt3);

                header("Location: ../addaccept.php?gameAddition=Success");
                exit();
            }  
        }
    }
} 


// reject-request is connected to the reject button in addaccept.php
// this block effectively just removes the request from the db because it was rejected
else if (isset($_POST['reject-request'])) {
    $id = $_POST['reject'];

    // pretty easy stuff here, just deleting the request at the given id
    $sql  = "DELETE FROM addition_requests WHERE request_id=?";
    $sql2 = "DELETE FROM picture_add_requests WHERE pic_id=?";
    $sql3 = "DELETE FROM tag_add_requests WHERE tag_id=?";
    $stmt = mysqli_stmt_init($conn);
    $stmt2 = mysqli_stmt_init($conn);
    $stmt3 = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../login.php?error=SQLInjection");
    }
    else { // more junk to execute the queries
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        mysqli_stmt_prepare($stmt2, $sql2);
        mysqli_stmt_bind_param($stmt2, "s", $id);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_store_result($stmt2);

        mysqli_stmt_prepare($stmt3, $sql3);
        mysqli_stmt_bind_param($stmt3, "s", $id);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_store_result($stmt3);

        header("Location: ../addaccept.php?gameRemoval=Success"); // take us back to the addaccept admin page
        exit();
    }  
} 


// reject-edit-req connects to the reject button in editaccept.php
// this just removes an edit request from the db
else if (isset($_POST['reject-edit-req'])) {
    $id = $_POST['reject-edits'];

    // same code as above except it deletes an edit request instead of an add request
    $sql  = "DELETE FROM edit_requests WHERE request_id=?";
    $sql2 = "DELETE FROM picture_edit_requests WHERE pic_id=?";
    $sql3 = "DELETE FROM tag_edit_requests WHERE tag_id=?";
    $stmt = mysqli_stmt_init($conn);
    $stmt2 = mysqli_stmt_init($conn);
    $stmt3 = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../login.php?error=SQLInjection");
    }
    else { // execute everything
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        mysqli_stmt_prepare($stmt2, $sql2);
        mysqli_stmt_bind_param($stmt2, "s", $id);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_store_result($stmt2);

        mysqli_stmt_prepare($stmt3, $sql3);
        mysqli_stmt_bind_param($stmt3, "s", $id);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_store_result($stmt3);

        header("Location: ../editaccept.php?gameRemoval=Success"); // go back to the edit page
        exit();
    } 
} 


// accept-edit-request connects to the accept button in editaccept.php
// this block of code accepts an edit to an already existing game entry
// steps:
//   - remove the current game entry
//   - add the new game entry info at that old game entry's id
//   - remove the edit request
else if (isset($_POST['accept-edit-req'])) {
    $id = $_POST['accept-edits'];

    // gather data from the edit request tables
    $sql = "SELECT * FROM edit_requests WHERE request_id=?";
    $sql1 = "SELECT * FROM picture_edit_requests WHERE pic_id=?";
    $sql2 = "SELECT * FROM tag_edit_requests WHERE tag_id=?";
    $stmt  = mysqli_stmt_init($conn);
    $stmt1 = mysqli_stmt_init($conn);
    $stmt2 = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../login.php?error=SQLInjection");
        exit();
    } else {
        // excute above queries
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s", $id);

        mysqli_stmt_prepare($stmt1, $sql1);
        mysqli_stmt_bind_param($stmt1, "s", $id);

        mysqli_stmt_prepare($stmt2, $sql2);
        mysqli_stmt_bind_param($stmt2, "s", $id);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); // store results bc they're useful
        $game = mysqli_fetch_assoc($result);

        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $pics = mysqli_fetch_assoc($result1);

        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $tags = mysqli_fetch_assoc($result2);

        // like when adding a game entry, create statements to insert as if this were a new game
        $sql = "INSERT INTO games (game_id, title, descript, game_pic, steam_link, xbox_link, ps_link, nintendo_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        $sql2 = "INSERT INTO pictures (pic_id, pic1, pic2, pic3) VALUES (?, ?, ?, ?);";
        $sql3 = "INSERT INTO tags (tag_id, tag1, tag2, tag3, tag4, tag5) VALUES (?, ?, ?, ?, ?, ?);";

        // also remove the old game
        $sql4 = "DELETE FROM games WHERE game_id=?;";
        $sql5 = "DELETE FROM tags WHERE tag_id=?;";
        $sql6 = "DELETE FROM pictures WHERE pic_id=?;";

        $stmt  = mysqli_stmt_init($conn);
        $stmt2 = mysqli_stmt_init($conn);
        $stmt3 = mysqli_stmt_init($conn);
        $stmt4 = mysqli_stmt_init($conn);
        $stmt5 = mysqli_stmt_init($conn);
        $stmt6 = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../login.php?error=SQLInjection");
            exit();
        } else { // execute deletions first, then inserts
            // deletions
            mysqli_stmt_prepare($stmt4, $sql4);
            mysqli_stmt_bind_param($stmt4, "s", $game['game_id']);
            mysqli_stmt_execute($stmt4);
            mysqli_stmt_store_result($stmt4);

            mysqli_stmt_prepare($stmt5, $sql5);
            mysqli_stmt_bind_param($stmt5, "s", $game['game_id']);
            mysqli_stmt_execute($stmt5);
            mysqli_stmt_store_result($stmt5);

            mysqli_stmt_prepare($stmt6, $sql6);
            mysqli_stmt_bind_param($stmt6, "s", $game['game_id']);
            mysqli_stmt_execute($stmt6);
            mysqli_stmt_store_result($stmt6);

            // inserts
            $stmt->bind_param("ssssssss", $game['game_id'], $game['title'], $game['descript'], $game['game_pic'], $game['steam_link'], $game['xbox_link'], $game['ps_link'], $game['nintendo_link']);
            $stmt->execute();
            $stmt->store_result();

            mysqli_stmt_prepare($stmt2, $sql2);
            mysqli_stmt_bind_param($stmt2, "ssss", $game['game_id'], $pics['pic1'], $pics['pic2'], $pics['pic3']);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_store_result($stmt2);

            mysqli_stmt_prepare($stmt3, $sql3);
            mysqli_stmt_bind_param($stmt3, "ssssss", $game['game_id'], $tags['tag1'], $tags['tag2'], $tags['tag3'], $tags['tag4'], $tags['tag5']);
            mysqli_stmt_execute($stmt3);
            mysqli_stmt_store_result($stmt3);

            // new queries to get rid of the edit request now that it has been used
            $sql  = "DELETE FROM edit_requests WHERE request_id=?";
            $sql2 = "DELETE FROM picture_edit_requests WHERE pic_id=?";
            $sql3 = "DELETE FROM tag_edit_requests WHERE tag_id=?";
            $stmt = mysqli_stmt_init($conn);
            $stmt2 = mysqli_stmt_init($conn);
            $stmt3 = mysqli_stmt_init($conn);
            echo "delete";

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../login.php?error=SQLInjection");
            }
            else { // execute that mess
                mysqli_stmt_bind_param($stmt, "s", $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                mysqli_stmt_prepare($stmt2, $sql2);
                mysqli_stmt_bind_param($stmt2, "s", $id);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_store_result($stmt2);

                mysqli_stmt_prepare($stmt3, $sql3);
                mysqli_stmt_bind_param($stmt3, "s", $id);
                mysqli_stmt_execute($stmt3);
                mysqli_stmt_store_result($stmt3);

                echo "finish";

                header("Location: ../addaccept.php?gameAddition=Success");
                exit();
            }  
        }
    }
}  
