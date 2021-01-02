<?php

/*****************************************
 * Logs users out of the site by
 * unsetting the session and destroying it
 * It sends the user back to the login page
 * once this is done.
 ******************************************/

session_start();
session_unset();
session_destroy();

header("Location: ../login.php");
exit();