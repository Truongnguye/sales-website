<?php
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
$servername = "localhost";
$username = "root";

// Create connection
global $conn;
$conn = mysqli_connect($servername, $username);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$db_selected=mysqli_select_db($conn,"examples");
if (!$db_selected) {
	echo mysqli_errno($conn) . " : " . mysqli_error($conn)."<br>";
}

$query="SELECT * FROM `userdb`";
$userdb = mysqli_query($conn,$query);
if (!$userdb) {
		die ("Invalid query: ".mysqli_error($conn)."<br> Whole query: ". $query);
}
			//---------------connect to the login database-------------//
?> 
