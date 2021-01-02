<?php 

/***********************************************
 * login.php is the frontend user interface page
 * that users use to login to their account.
 * It submits a form to the login-helper file
 * in order to log the user in to their account.
 **********************************************/

require "includes/header.php";
?>

<main>
    <link rel="stylesheet" href="css/login.css">
    <div class = "bg-cover text-centered">
        <div class="container-fluid w-25 justify-content-end" style="padding-top: 2vh">
            
        </div>

        <div class="h-40 center-me">
            <div class="my-auto">
                <!--form that submits to login-helper.php using the HTTP POST method -->
                <form class="form-signin" action="includes/login-helper.php" method="post" style= "background: #FFFFFFBB; padding: 5vh 5vw 5vh 5vw">
                    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                    <label for="inputEmail" class="sr-only">Username or Email Address</label>
                    <input type="text" id="inputEmail" name="uname" class="form-control" placeholder="Username/Email" required autofocus>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword"  name="pwd" class="form-control" placeholder="Password" required>
                    <div class="checkbox mb-3">
                       <label>
                            <input type="checkbox" value="remember-me" style="margin:10px"> Remember me
                       </label>
                    </div>
                    <button class="btn btn-lg btn-dark btn-block" name="login-submit" type="submit">Sign in</button>
                    <p class="mt-5 mb-3 text-muted">&copy; GAMRFAX 2020-2021</p>
                </form>
            </div>
        </div>
    </div>     
</main>