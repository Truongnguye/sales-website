<?php
	if (session_status() === PHP_SESSION_NONE) {
    session_start();
	}
?>
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

	$query="SELECT * FROM `products`";
	$productdb = mysqli_query($conn,$query);
	if (!$productdb) {
			die ("Invalid query: ".mysqli_error($conn)."<br> Whole query: ". $query);
	}
	$product = mysqli_query($conn,"select * from products where `product_code` = \"$_GET[id]\"");
	if($product) {
		$row=mysqli_fetch_assoc($product); // ok ready to fetch data
	} else {
		die("Error: Could not access database!");
	}
	
	if (isset($_GET['req']))
	{
		$php_info=array("id"=>$row['product_code'],"pname" => $row['tensanpham_viethoa'],"price"=>$row['price'],"img"=>$row['img'],"price_numberic"=> $row['price_numberic']);
		$json_info=json_encode($php_info);
		echo "$json_info";
		
	}
		//-------------connect to the databasse-------------------//
?>

