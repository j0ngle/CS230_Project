<?php
/***********************************************************
* dbhandler.php                                            *
* 	- gets included every time a db connection is needed   *
***********************************************************/

$servename = "localhost";
$DBuname = "root";
$DBPass = "root1234"; //root1234
$DBname = "gamereviewsite";

$conn = mysqli_connect($servename, $DBuname, $DBPass, $DBname);

if (!$conn) {
    die("Connection failed...".mysqli_connect_error());
}

