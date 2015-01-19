<?php

// start the session before any output.
session_start();



/***************
	Database Connection 
		You will need to change the user (user) 
		and password (password) to what your database information uses. 
		Same with the database name if you used something else.
****************/

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "heidi";
try {
    $connect = new PDO("mysql:host=$host;dbname=$dbname", $user,$pass);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOException $e) {
    echo $e->getMessage();
} 



/***************
	password salts are used to ensure a secure password
	hash and make your passwords much harder to be broken into
	Change these to be whatever you want, just try and limit them to
	10-20 characters each to avoid collisions. 
****************/
define('SALT1', '24859f@#$#@$');
define('SALT2', '^&@#_-=+Afda$#%');

// require the function file
require_once('functions.php');

// default the error variable to empty.
$_SESSION['error'] = "";

// declare $sOutput so we do not have to do this on each page.
$sOutput="";
?>
