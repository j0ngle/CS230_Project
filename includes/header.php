<?php

/*************************************
 * header.php is required in
 * all pages and acts as the
 * navigation bar on each page.
 * Users of the site will see different
 * things based on their status.
 *************************************/

session_start();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--Linking bootstrap in  -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/0809ee8fa6.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="d-md-flex d-block flex-row mx-md-auto mx-0">
            <a class="navbar-brand" href="index.php">GAMRFAX</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php
                    
                    //checks if someone is logged in to the site or not
                    if (isset($_SESSION['uid'])) {

                        //Checks if that user is the admin
                        if ($_SESSION['uid'] == 0) {

                            //if the admin is logged in, then they have the Admin tab show up
                            echo '
                            <li class="nav-item">
                                <a class="nav-link" href="includes/logout.php">Logout</a>
                             </li>
                            <li class="nav-item">
                             <a class="nav-link" href="gallery.php">Games</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="admin.php">Admin</a>
                            </li>
                            ';
                        } else {

                            //all other users see a profile tab pop up as well as logout
                            echo '
                            <li class="nav-item">
                                <a class="nav-link" href="includes/logout.php">Logout</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="gallery.php">Games</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php">Profile</a>
                            </li>
                            ';
                        }
                    } else {

                        //users who are not logged in see the following tabs
                        echo '
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gallery.php">Games</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php">Sign Up</a>
                        </li>
                        ';
                    }
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="about.php">About<span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>