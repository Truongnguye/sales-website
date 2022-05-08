<?php
	ob_start();
	session_start();
	$servername = "localhost";
	$username = "root";

	// Create connection
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

   if(isset($_SESSION["username"])) {
	   
		$user_info = mysqli_query($conn,"SELECT * FROM userdb WHERE `uname` = \"$_SESSION[username]\"");
		
	    if( mysqli_num_rows($user_info) != 0) {
			
			$user_info=mysqli_fetch_assoc($user_info); // user info row in database	
			
		} else {
			die("Cannot find user, something gone wrong!");
		}
   } // get user info if user has logged in
   else {
	   //user not logged in
	   echo "Please login first";
   }

?>




<?php
	if (isset($_SESSION['username'])) {// if user logged in
		$availableToChange = false;
		$oldPasswordCorrect = false;
		$pwordMatchFlag = true;
		$pwordlengthFlag = true;
		
		
		if (isset($_POST['pword']) && isset($_POST['repword']) ) {
			$pword=$_POST['pword'];
			$repword=$_POST['repword'];
			
			if (strlen($pword)>=4)
			{
				$pwordlengthFlag = false; 
			} else {
				$pwordlengthFlag = true; 
			}	
			
			$pwordMatchFlag = !($pword==$repword);
			
			if ($pwordlengthFlag || $pwordMatchFlag){
				echo "$(\"#pwordWarn\").show();";
				if ($pwordMatchFlag) {
					echo "$(\"#pwordWarn\").html(\"Mật khẩu nhập lại không khớp.\");";
				}
				if ($pwordlengthFlag) {
					echo "$(\"#pwordWarn\").html(\"Mật khẩu phải có hơn 4 ký tự.\");";
				}
			} else {
				echo "$(\"#pwordWarn\").hide();";
			}
		} // check if new password is matched
		
		
		if (isset($_POST['opword'])) {
			$oldPasswordCorrect = $_POST['opword'] == $user_info['pword'];
			
			if (!$oldPasswordCorrect) {
				echo "$(\"#wrongpwordWarn\").show();";
				echo "$(\"#wrongpwordWarn\").html(\"Mật khẩu cũ sai.\");";
			} else {
				echo "$(\"#wrongpwordWarn\").hide();";
				echo "$(\"#wrongpwordWarn\").html(\"\");";
			}
		}// check if old password is correct, esle print warning
		
		$availableToChange = $oldPasswordCorrect && !$pwordMatchFlag && !$pwordlengthFlag; // combine all the flag together
		
		if (isset($_POST['submit_change']) && $availableToChange) { 
			$result=mysqli_query($conn,"UPDATE `userdb` SET `pword` = '$pword' WHERE `userdb`.`id` = \"$_SESSION[id]\"");
			if ($result) {
				echo "$(\"#pwordSucess\").show();";
				echo "$(\"#pwordSucess\").html(\"Thay đổi mật khẩu thành công.\");";
			} else {
				echo "$(\"#pwordSucess\").hide();";
				echo "$(\"#pwordSucess\").html(\"\");";
			}
		} else {
			echo "$(\"#pwordSucess\").hide();";
			echo "$(\"#pwordSucess\").html(\"\");";
		}
		
		
		
	} else {
		echo "Please log in first!";
	}
?>