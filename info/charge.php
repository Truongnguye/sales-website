<?php
   ob_start();
   session_start();
   include '../login/userdb.php'; //$userdb is user database, conn is connection
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
	   echo "Please login!";
   }
?>
<?php
   if(isset($_SESSION["username"])) {
	   
		$user_info = mysqli_query($conn,"SELECT * FROM userdb WHERE `uname` = \"$_SESSION[username]\"");
		
	    if( mysqli_num_rows($user_info) != 0) {
			
			$user_info=mysqli_fetch_assoc($user_info); // user info row in database	
			
			if (isset($_POST['amount'])) {
				if (!($_POST['amount'] == (string)((int)$_POST['amount']))) {die("Nhập số nguyên!");}
				$amount=$_POST['amount']+$user_info['ubalance'];
				mysqli_query($conn,"UPDATE `userdb` SET `ubalance` = '$amount' WHERE `userdb`.`id` = \"$_SESSION[id]\""); // them  tien vao tai khoan
				
				$user_info = mysqli_query($conn,"SELECT * FROM userdb WHERE `uname` = \"$_SESSION[username]\""); 
				$user_info=mysqli_fetch_assoc($user_info); // update lai giao dien voi so tien moi duoc them
			}
			
		} else {
			die("Cannot find user, something gone wrong!");
		}
   } // request nap tien
?> 

<?php
if( isset($_SESSION["username"])) {?>

	<script>
	$("document").ready(function (){
		$("#submit_charge").click( function (){
			submit_charge();
		});
	}); //make the user-block display info interface when click
	
	function submit_charge() {
		$.ajax({
			type:"POST",
			url:"info/charge.php",
			data: {amount:$("#charge_amount").val()},
			success: function (result){
				$('#user-block').html(result);
			}	
		});
	}
	</script>



	<div class="form-floating" style="margin-bottom: 10px;">
        <input type="text" class="form-control" id="charge_amount" placeholder="charge_amount" name="charge_amount">
        <label for="charge_amount">Nhập số tiền muốn nạp</label>
    </div>

	<button type="button" id="submit_charge" class="w-100 btn btn-lg btn-dark" >Nạp</button >
	<br>
	<br>
	<br>
	<p class="text-center">Số dư hiện tại: <?php echo "$user_info[ubalance]"?> VND</p>
<?php } // khi trong login session
?> <!-----sua giao dien info cho nay----->