<?php
   ob_start();
   session_start();
   include '../login/userdb.php'; //$userdb is user database, conn is connection
   if(isset($_SESSION["username"])) {
	   
		$user_info = mysqli_query($conn,"SELECT * FROM userdb WHERE `uname` = \"$_SESSION[username]\"");
		
	    if( mysqli_num_rows($user_info) != 0) {
			
			$user_info=mysqli_fetch_assoc($user_info); // user info row in database		
		} else {
			die("Could not find user, something went wrong!");
		}
   } // get user info if user has logged in
   else {
	   //user not logged in
	   echo "Please login!";
   }
?>


<?php
if( isset($_SESSION["username"])) {
	echo "<p class='text-center'>";
	echo "userid: $user_info[id]<br>";
	echo "username: $user_info[uname]<br>";
	echo "user's balance: $user_info[ubalance]<br>";
	echo "</p>";
}
?> <!-----sua giao dien info cho nay----->