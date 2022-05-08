<?php
   ob_start();
   session_start();
   include '../login/userdb.php'; //$userdb is user database, conn is connection
   if(isset($_SESSION["username"]) &&isset($_SESSION["privilege"]) && $_SESSION["privilege"]=="admin") {
	   
		$user_info = mysqli_query($conn,"SELECT * FROM userdb WHERE `uname` = \"$_SESSION[username]\"");
		
	    if( mysqli_num_rows($user_info) != 0) {
			
			$user_info=mysqli_fetch_assoc($user_info); // user info row in database		
		} else {
			die("Cannot find user, something gone wrong!");
		}
   } // get user info if user has logged in
   else {
	   //user not logged in
	   die ("Please login first");
   }
if(isset($_SESSION["username"]) &&isset($_SESSION["privilege"]) && $_SESSION["privilege"]=="admin" && isset($_POST['id_to_ban'])) {
	$id_to_ban = $_POST['id_to_ban'];
	$current_state=mysqli_query($conn,"SELECT privilege from userdb WHERE id = $id_to_ban");
	$current_state=mysqli_fetch_assoc($current_state);
	if ($current_state['privilege'] != "admin") {
		if ($current_state['privilege'] != "banned") {
			mysqli_query($conn,"UPDATE `userdb` SET `privilege` = 'banned' WHERE `userdb`.`id` = $id_to_ban");
			echo "Banned user with id $id_to_ban";
		} else {
			mysqli_query($conn,"UPDATE `userdb` SET `privilege` = 'user' WHERE `userdb`.`id` = $id_to_ban");
			echo "Unbanned user with id $id_to_ban";
		}
	} else {
		echo "Z";
	}
}
?>