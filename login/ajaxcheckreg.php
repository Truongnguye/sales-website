<?php
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



?>


<?php
$availableToAdd=false;

if (isset($_POST['uname']) && isset($_POST['pword']) && isset($_POST['repword']) )
{
	$uname=$_POST['uname'];
	$pword=$_POST['pword'];
	$repword=$_POST['repword'];
	$pwordMatchFlag = true;
	$pwordlengthFlag = true;
	$nameLessThan = true;
	$nameExist = true;
	$specialChar = false;
	
	if (strlen($uname)> 3) {
		$nameLessThan=false;
	} else {
		$nameLessThan=true;
	} 
	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/',$uname))
	{
		$specialChar=true;
	}
	
	$userdb = mysqli_query($conn,$query);
	$result=mysqli_query($conn,"SELECT * FROM userdb WHERE uname='$uname'");
	if(!$result || mysqli_num_rows($result) == 0) {
		$nameExist=false;
	mysqli_free_result($result);
	}
	else
	{
		$nameExist=true;
	}
	if ($nameExist || $nameLessThan || $specialChar) {
		echo "$(\"#nameWarn\").show();";
		if ($nameLessThan) {
			echo "$(\"#nameWarn\").html(\"Tên tài khoản phải có hơn 4 ký tự.\");";
		}
		if ($specialChar) {
			echo "$(\"#nameWarn\").html(\"Tên tài khoản có kí tự đặc biệt.\");";
		}
		if ($nameExist) {
			echo "$(\"#nameWarn\").html(\"Tài khoản đã tồn tại.\");";
		}
		
		
	} else {
		echo "$(\"#nameWarn\").hide();";
	} // uname check
	
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
			echo "$(\"#pwordWarn\").html(\"Mật khẩu xác nhận không khớp.\");";
		}
		if ($pwordlengthFlag) {
			echo "$(\"#pwordWarn\").html(\"Mật khẩu phải có hơn 4 ký tự.\");";
		}
	} else {
		echo "$(\"#pwordWarn\").hide();";
	}
	$availableToAdd= !$pwordMatchFlag && !$pwordlengthFlag && !$nameLessThan && !$nameExist && !$specialChar; 
}
if (isset($_POST['submit']) && $availableToAdd){
	mysqli_query($conn,"INSERT INTO `userdb` (`id`, `uname`, `pword`, `privilege`) VALUES ('-99', '$uname', '$pword', 'user')");
	$id=0;
	do {
		$result = mysqli_query($conn,"UPDATE `userdb` SET `id` = $id WHERE `userdb`.`id` = -99");
		$id++;	
	} while (!$result);
	// registered successful
	echo "$(\"#regForm\").attr(\"action\",\"signin.php\");";
	echo "$(\"#regForm\").attr(\"method\",\"POST\");";	
	echo "$(\"#regForm\").append(\"<input type=\'text\' name=\'regSuccess\' value=\'99\'> \");";	
	echo "document.getElementById(\"regForm\").submit();";
}
?>

<?php
mysqli_free_result($userdb);
mysqli_close($conn);
?>