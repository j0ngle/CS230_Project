<?php

/*************************************************************************
* edit-request-helper.php                                                *
*       - handles entry edit requests                                    *
*       - gets info from the entryedit form and posts it to the database *
*************************************************************************/

session_start();

require 'dbhandler.php';

if (isset($_POST['add-submit'])) {
    // gets all the game entry edit info from the post request
    $gid = $_POST['game_id'];

    $title = $_POST['game-title'];
    $descript = $_POST['game-descript'];
    $tag1 = $_POST['tag-1'];
    $tag2 = $_POST['tag-2'];
    $tag3 = $_POST['tag-3'];
    $tag4 = $_POST['tag-4'];
    $tag5 = $_POST['tag-5'];

    $steam = $_POST['steam-link'];
    $xbox = $_POST['xbox-link'];
    $ps = $_POST['ps-link'];
    $nintendo = $_POST['nintendo-link'];

    $page1 = $_FILES['image1'];
    $page2 = $_FILES['image2'];
    $page3 = $_FILES['image3'];
    $cover = $_FILES['cover-image'];

    // info to help the images get uploaded into the server
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

    // sql statements to insert all the info into the database
    $sql  = "INSERT INTO edit_requests (game_id, title, descript, game_pic, steam_link, xbox_link, ps_link, nintendo_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    $sql2 = "INSERT INTO picture_edit_requests (pic1, pic2, pic3) VALUES (?, ?, ?);";
    $sql3 = "INSERT INTO tag_edit_requests (tag1, tag2, tag3, tag4, tag5) VALUES (?,?,?,?,?);";
    $stmt  = mysqli_stmt_init($conn);
    $stmt2 = mysqli_stmt_init($conn);
    $stmt3 = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../login.php?error=SQLInjection");
        exit();
    } else { // binding paramaters and executing the statemenets
        echo $gid;
        $stmt->bind_param("ssssssss", $gid, $title, $descript, $cover_name, $steam, $xbox, $ps, $nintendo);
        $stmt->execute();
        $stmt->store_result();

        mysqli_stmt_prepare($stmt2, $sql2);
        mysqli_stmt_bind_param($stmt2, "sss", $page1name, $page2name, $page3name);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_store_result($stmt2);

        mysqli_stmt_prepare($stmt3, $sql3);
        mysqli_stmt_bind_param($stmt3, "sssss", $tag1, $tag2, $tag3, $tag4, $tag5);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_store_result($stmt3);


        move_uploaded_file($page1['tmp_name'], $destination1);
        move_uploaded_file($page2['tmp_name'], $destination2);
        move_uploaded_file($page3['tmp_name'], $destination3);
        move_uploaded_file($cover['tmp_name'], $cover_destination);

        header("Location: ../gallery.php?gameEditRequest=Success"); // redirect to the gallery
        exit();
    }
}
