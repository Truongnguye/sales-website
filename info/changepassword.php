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
	   echo "Please login first";
   }
?>

<!-- ajax -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
	$("document").ready(function (){
		$("#pword,#repword").change( function (){
			data = {
				pword : $("#pword").val(),
				repword : $("#repword").val(),
			};
			$.ajax({
				type:"POST",
				url:"info/ajaxchangepassword.php",
				data: data,
				success: function (result){
							eval(result);
						}	
			});
		});
	}); // use ajax to control warning text.

	$("document").ready(function (){
		$("#submit-change").click( function (){
			data = {
				opword : $("#opword").val(),
				pword : $("#pword").val(),
				repword : $("#repword").val(),
				submit_change : "mkay",
				
			}; 
			$.ajax({
				type:"POST",
				url:"info/ajaxchangepassword.php",
				data: data,
				success: function (result){
							eval(result);
						}	
			});
		});
	}); //execute when then user submit the register information

	</script>
<!-- ajax -->


<form id="change-password">
	<div class="form-floating" style="margin-bottom: 10px;">
        <input type="password" class="form-control" id="opword" placeholder="opword" name="opword">
        <label for="opword">Mật khẩu cũ <span id="wrongpwordWarn" class="error">*</span></label>
    </div>

	<div class="form-floating" style="margin-bottom: 10px;">
        <input type="password" class="form-control" id="pword" placeholder="pword" name="pword">
        <label for="pword">Mật khẩu mới <span id="pwordWarn" class="error">*</span></label>
    </div>

	<div class="form-floating" style="margin-bottom: 10px;">
        <input type="password" class="form-control" id="repword" placeholder="repword" name="repword">
        <label for="repword">Nhập lại mật khẩu</label>
    </div>

	<button type="button" id="submit-change" class="w-100 btn btn-lg btn-dark">Đổi mật khẩu</button>

	<br>
	<br>
	<p id="pwordSucess" class="text-center error"></p>

</form>
