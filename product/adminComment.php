<?php
session_start();
include '../login/userdb.php';
if (isset($_POST['repReq']) && isset($_SESSION['privilege']) && $_SESSION['privilege']=="admin")
{
	mysqli_query($conn, "UPDATE `comment` SET `admin_reply` = '$_POST[reply_content]' WHERE `comment_id`= '$_POST[request_id]'"); 
}

if (isset($_POST['revReq']) && isset($_SESSION['privilege']) && $_SESSION['privilege']=="admin")
{
	mysqli_query($conn, "DELETE FROM `comment` WHERE `comment`.`comment_id` = $_POST[request_id]");
}
?>