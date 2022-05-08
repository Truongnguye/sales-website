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
?>


<?php
if(isset($_SESSION["username"]) &&isset($_SESSION["privilege"]) && $_SESSION["privilege"]=="admin") {
	
	$array_of_user = array(); 
	if (isset($_POST['uid'])) {
		$user_list =  mysqli_query($conn,"SELECT * FROM userdb WHERE `id` = $_POST[uid]");
		if (!$user_list || mysqli_num_rows($user_list)==0) {$user_list =  mysqli_query($conn,"SELECT * FROM userdb WHERE `uname` = \"$_POST[uid]\"");}
	} else {
		$user_list = $userdb;
	}
	
	while($row = mysqli_fetch_assoc($user_list)){

	array_push($array_of_user,$row);

	} // to get $array_of_user is the whole user database
	
	$array_of_pages=array();
	$array_of_pages = segment($array_of_user,5);
	

	
}




function segment($array,$max_item_in_page)// turn array in to segment 
{
	$pagecount = (int)(count($array) / $max_item_in_page) + ((count($array) % $max_item_in_page)? 1:0);
	$array_of_pages = array();
	for ( $i=0; $i< $pagecount; $i++) {
		if ($pagecount - 1 == $i){
			array_push($array_of_pages,$array);
		} else {
			$item = array_slice($array,0,$max_item_in_page);
			$array = array_slice($array,$max_item_in_page);
			array_push($array_of_pages,$item);
		}
	}
	return $array_of_pages;
}
?> 

<div class="form-floating">
	<input type="text" class="form-control" name="uid" id="uid" placeholder="uid">
	<label for="uid">Tìm tài khoản khách hàng bằng ID</label>
</div>
<button type="button" onclick="user_list()" class="btn btn-outline-secondary" style="width: 100%;">Get</button>
<br>
<br>

<table id="user-page"  class="table-bordered table">
<tr class="text-center">
	<th>ID</th>
	<th>username</th>
	<th>Đặc quyền</th>
	<th>Số tiền đang có</th>
	<th>BAN</th>
</tr>
<?php

	for ($i=0;$i<count($array_of_pages);$i++) {
		for($k=0;$k<count($array_of_pages[$i]);$k++) {
			$temp =$array_of_pages[$i][$k];
			echo "<tr class=\"page page_$i\">";
				echo "<td class=\"text-center\">$temp[id]</td>";
				echo "<td class=\"text-center\">$temp[uname]</td>";
				echo "<td class=\"text-center\" id = \"privilege_$temp[id]\">$temp[privilege]</td>";
				echo "<td class=\"text-center\">$temp[ubalance]</td>";
				if ($temp['privilege']!="banned") {
					echo "<td><button class=\"btn btn-secondary\" style=\"width: 100%;\"
					onclick=\"ban(this)\" type=\"button\" id=\"ban_$temp[id]\">Ban</button></td>";
				} else {
					echo "<td><button class=\"btn btn-secondary\" style=\"width: 100%;\"
					onclick=\"ban(this)\" type=\"button\" id=\"ban_$temp[id]\">Unban</button></td>";
				}
			echo "</tr>";
		}
	}
	
?>
</table>
<?php
	for ($i=0;$i<count($array_of_pages);$i++) {
		echo"<button class=\" btn btn-outline-secondary\" onclick=\"switchpage(this)\" type=\"button\" id=\"but_$i\">$i</button>";
	}
?>
<script>
	$("document").ready(function (){
		$(".page").css('display','none');
		$(".page_0").css('display','table-row');
	}); //show first page when init
	
	function switchpage(obj) {
		current_page=$(obj).attr('id').slice(4);
		$(".page").css('display','none');
		$(".page_"+current_page).css('display','table-row');
	}
	
	function ban(obj) {
		current_user_id=$(obj).attr('id').slice(4);
		$.ajax({
			type:"POST",
			data: {id_to_ban: current_user_id},
			url:"admin/banRequest.php",
			success: function (result){
				if ($.trim(result)!="Z") {
					if ($(obj).html()=="Ban") {
						$(obj).html("Unban");
						$("#privilege_"+current_user_id).html("banned");
					} 
					else {
						$(obj).html("Ban");
						$("#privilege_"+current_user_id).html("user");
					}
				} else {
					alert("Không thể ban admin!");
				}
			}	
		});
	}
</script>