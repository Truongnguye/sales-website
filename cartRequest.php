<?php
	ob_start();
   session_start();
   include 'login/userdb.php'; //$userdb is user database, conn is connection
   
   if (isset($_SESSION['username'])) {
	   
	    $user_info=mysqli_query($conn,"SELECT * FROM userdb WHERE `id` = \"$_SESSION[id]\"");
	   
		if( mysqli_num_rows($user_info) != 0) {
			
			 $user_info=mysqli_fetch_assoc($user_info); // get the cart info
			 
			 if (isset($_GET['revReq']))
			{
				if (!isJson($_GET['revReq'])) { die("Invalid request");}
				$check_valid_request=json_decode($_GET['revReq']);
				for ($i=0;$i<count($check_valid_request);$i++) { // check if the cart is valid
					$sent_product_code = $check_valid_request[$i];
					$product = mysqli_query($conn,"select * from products where `product_code` = \"$sent_product_code\"");
					if(!$product || !mysqli_num_rows($product)) {
						die("Invalid Request");
					}
				}
				
				
				mysqli_query($conn,"UPDATE `userdb` SET `cart` = '$_GET[revReq]' WHERE `userdb`.`id` = \"$_SESSION[id]\"");
				echo "Thành công";
			} // remove request
			
			if (isset($_GET['addReq']))
			{
				$itemExist = mysqli_query($conn,"SELECT * FROM products WHERE `product_code` = \"$_GET[addReq]\"");
				if ($itemExist && mysqli_num_rows($itemExist) != 0) {
					$alreadyExistInCart = false;
					$php_cart_arr=json_decode($user_info['cart']);
					for ($i=0;$i<count($php_cart_arr);$i++)
					{
						if ($php_cart_arr[$i]==$_GET['addReq']) {$alreadyExistInCart = true;}
					}
					
					if ($alreadyExistInCart==false) {
					array_push($php_cart_arr,$_GET['addReq']);
					$json_cart_arr=json_encode($php_cart_arr);
					mysqli_query($conn,"UPDATE `userdb` SET `cart` = '$json_cart_arr' WHERE `userdb`.`id` = \"$_SESSION[id]\"");
					echo "Thành công";
					} else {
						echo "Đã có sản phẩm này trong giỏ hàng";
					}
				
				} else {
					echo "Cannot find product code to add!";
				}
			}
		}
	
	   
	   
   }
   
function isJson($string) {
   json_decode($string);
   return json_last_error() === JSON_ERROR_NONE;
}
?>