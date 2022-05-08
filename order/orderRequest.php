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
	
	$orderdb = mysqli_query($conn,"SELECT * FROM `orders`");
	
	if (!isset($_SESSION['id']) && !isset($_SESSION['privilege']) && $_SESSION['privilege'] == "banned" ) {
		
		die("Cannot response to the request");
		
	} else {
		
		$user_info = mysqli_query($conn,"SELECT * FROM userdb WHERE `uname` = \"$_SESSION[username]\"");
		
	    if( mysqli_num_rows($user_info) != 0) {
			
			$user_info=mysqli_fetch_assoc($user_info); // user info row in database
			
		} else {
			
			die("Cannot find user, something gone wrong!");
			
		}
	
		
	} // user has logged in
    
?>
<?php
	if (isset($_POST['addReq']) && isset($_POST['order_list'])) { //add order request	
		$php_order_list=json_decode($_POST['order_list']);
		$total_price = 0;
		
		for ($i=0; $i< count($php_order_list); $i++)
		{
			$id=$php_order_list[$i]->id;
			$product_info = mysqli_query($conn,"SELECT * FROM products WHERE `product_code` = \"$id\"");
			if (!$product_info || !mysqli_num_rows($product_info)) {die("Invalid request");}
			$product_info = mysqli_fetch_assoc($product_info);
			$total_price+= $product_info['price_numberic']*$php_order_list[$i]->amount;
		}

		if ($total_price > $user_info['ubalance']) {
			die ("Số dư tài khoản không đủ để đặt hàng!");
		} else {
			$ubalance_left = $user_info['ubalance'] - $total_price;
		}
		
		
		mysqli_query($conn,"INSERT INTO `orders` (`order_id`, `user_id`, `order_list`, `order_state`, `order_price`, `address`) VALUES ('-99', '$_SESSION[id]', '$_POST[order_list]', 'pending', '$total_price', '$_POST[address]')");
		$id=0;
		do {
			$result = mysqli_query($conn,"UPDATE `orders` SET `order_id` = '$id' WHERE `orders`.`order_id` = -99");
			$id++;	
		} while (!$result);	
		$id--;
		echo "Đã gửi đơn hàng với id : $id";
		mysqli_query($conn,"UPDATE `userdb` SET `ubalance` = '$ubalance_left' WHERE `userdb`.`id` = '$_SESSION[id]'");
	}
	
?> 
<?php
	if (isset($_POST['getInfo'])) { //get order info request
		if ($_SESSION['privilege'] == "admin") {
			$order_list = mysqli_query($conn,"SELECT * FROM orders ORDER BY FIELD(order_state,
        'pending',
        'verified',
		'done') ");
		} else {
			$order_list = mysqli_query($conn,"SELECT * FROM orders WHERE `user_id` = \"$_SESSION[id]\" ORDER BY FIELD(order_state,
        'pending',
        'verified',
		'done')");
		}
		
		if (isset($_POST['state']) && $_POST['state']!="all") {
			if ($_SESSION['privilege'] == "admin") {
			$order_list = mysqli_query($conn,"SELECT * FROM orders WHERE `order_state`=\"$_POST[state]\" ORDER BY FIELD(order_state,
        'pending',
        'verified',
		'done') ");
			} else {
				$order_list = mysqli_query($conn,"SELECT * FROM orders WHERE `user_id` = \"$_SESSION[id]\" AND `order_state`=\"$_POST[state]\" ");
			}
		} // lay nhung order co state trong POST[state]
		$php_order_list= array();
		$row = mysqli_fetch_assoc($order_list);
		$php_item=array();
		while ($row)
		{
			$php_item = array("order_id"=>$row['order_id'],"user_id"=>$row['user_id'], "order_list" => $row['order_list'],"order_price"=>$row['order_price'],"order_state"=>$row['order_state'],"address"=>$row['address']);
			array_push($php_order_list, json_encode($php_item) );
			$row = mysqli_fetch_assoc($order_list);
		}
		echo (json_encode($php_order_list));
	}
?>
<?php
	if (isset($_POST['calReq']) && isset($_POST['order_id'])) { // cancel order request
		
		$valid=mysqli_query($conn,"SELECT * FROM orders WHERE `order_id` = \"$_POST[order_id]\"");
			
		if ($valid && mysqli_num_rows($valid) != 0) {
			$valid = mysqli_fetch_assoc($valid);
			if (($valid['user_id']== $_SESSION['id']) || ($_SESSION['privilege']=="admin")) {
				$user_info= mysqli_query($conn,"SELECT * FROM userdb WHERE `id` = \"$valid[user_id]\"");
				$user_info= mysqli_fetch_assoc($user_info);
				if ($valid['order_state'] != "pending") { die("Không thể hủy dơn hàng khi đơn hàng đã được xác nhận!");}
				
				mysqli_query($conn,"DELETE FROM `orders` WHERE `orders`.`order_id` = '$valid[order_id]'");
				$refund = $valid['order_price']+$user_info['ubalance'];
				mysqli_query($conn,"UPDATE `userdb` SET `ubalance` = '$refund' WHERE `userdb`.`id` = '$valid[user_id]'");
				
				echo "Đã hủy đơn hàng id :$_POST[order_id] , hoàn tiền $valid[order_price] cho người dùng ID $valid[user_id]";
				
			} else {
				echo "Invalid order";
			}
			
		} else {
			echo "Cannot find order with given ID";
		}
			
			
	}
?>
<?php
	if (isset($_POST['doneReq']) && isset($_POST['order_id'])) { // cancel order request
			
		$valid=mysqli_query($conn,"SELECT * FROM orders WHERE `order_id` = \"$_POST[order_id]\"");	
		if ($valid && mysqli_num_rows($valid) != 0) {
			$valid = mysqli_fetch_assoc($valid);
			if (($valid['user_id']== $_SESSION['id'])) {
				if ($valid['order_state'] != "verified") { die("Đơn hàng chưa được xác nhận!");}
				mysqli_query($conn,"UPDATE `orders` SET `order_state` = 'done'  WHERE `orders`.`order_id` = '$valid[order_id]'");

				echo "Xác nhận đã nhận hàng:$_POST[order_id]";
				
			} else {
				echo "Invalid order";
			}
			
		} else {
			echo "Cannot find order with given ID";
		}
			
			
	}
?>
<?php
	if (isset($_POST['verReq']) && isset($_POST['order_id'])) { // cancel order request
			
		$valid=mysqli_query($conn,"SELECT * FROM orders WHERE `order_id` = \"$_POST[order_id]\"");
			
		if ($valid && mysqli_num_rows($valid) != 0) {
			$valid = mysqli_fetch_assoc($valid);
			if ($_SESSION['privilege']=="admin") {
				
				mysqli_query($conn,"UPDATE `orders` SET `order_state` = 'verified'  WHERE `orders`.`order_id` = '$valid[order_id]'");

				echo "Xác nhậnn đơn hàng id:$_POST[order_id]";
				
			} else {
				echo "Invalid order";
			}
			
		} else {
			echo "Cannot find order with given ID";
		}
			
			
	}
?>