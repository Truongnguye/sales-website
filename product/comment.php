<?php


	function setComment($conn) {
		if (isset($_SESSION['username'])&&isset($_POST['CSubmit'])) {
					
			$uname = $_SESSION['username'];
			$sao = $_POST['sao']; 
			$uid= $_SESSION['id'];
			$product_id = $_POST['product_id'];
			$date = $_POST['date'];
			$content = strip_tags($_POST['content']);
			
			if (!is_int($sao) && $sao<=0 && $sao >5 ) { die ("Invalid input");}
			
			$pcodeExist=mysqli_query($conn, "SELECT * FROM products WHERE `product_code`= '$product_id'");
			$unameExist=mysqli_query($conn, "SELECT * FROM userdb WHERE `id`= '$uid'");
			
			
			if ($pcodeExist && $unameExist && mysqli_num_rows($pcodeExist)!=0 && mysqli_num_rows($unameExist)!=0) {	
							
				$commentExist=mysqli_query($conn, "SELECT * FROM comment WHERE `product_id`= '$product_id' AND `uid`= '$uid'");
				if ($commentExist && mysqli_num_rows($commentExist)) {
					mysqli_query($conn, "UPDATE `comment` SET `content` = '$content' WHERE `product_id`= '$product_id' AND `uid`= '$uid'");
					mysqli_query($conn, "UPDATE `comment` SET `date` = '$date' WHERE `product_id`= '$product_id' AND `uid`= '$uid'");
					mysqli_query($conn, "UPDATE `comment` SET `sao` = '$sao' WHERE `product_id`= '$product_id' AND `uid`= '$uid'");
					
				} else {
					mysqli_query($conn, "INSERT INTO comment (product_id,uid,content,date,uname,sao) VALUES ('$product_id','$uid','$content','$date','$uname','$sao')");		
				}
				
				calculateRating($conn,$product_id);
				echo "<script>window.location=\"product.php?id=$product_id\"</script>";
			
			} else {
				echo "Khong the them comment";
			}
			
			
		}
	}
?>
<?php
 function showComment($conn,$product_id,$uid) {
	 $item_in_page=5;
	 $pcodeExist=mysqli_query($conn, "SELECT * FROM products WHERE `product_code`= '$product_id'");
	 if ($pcodeExist) {
		 if (isset($_SESSION['id']) && $uid != "none" && $_SESSION['privilege']!="admin") {
			 $yourComment = mysqli_query($conn, "SELECT * FROM `comment` WHERE `product_id`= '$product_id' AND `uid`= '$uid'");
			 
			 if ($yourComment && mysqli_num_rows($yourComment)!=0) {
				$yourComment=mysqli_fetch_assoc($yourComment);
				echo "<div class=\"border-bottom\">";
				echo "<p>Đánh giá của bạn: $yourComment[sao]/5 <span class=\"fa fa-star checked\" style=\"color: #ffcd3c;\"></span></p>";
				echo "<p>Lời đánh giá: $yourComment[content]</p>";
				if ($yourComment['admin_reply']!="") {
					echo "<p><strong>Admin đã phản hồi:</strong> ";
					echo "$yourComment[admin_reply]</p>";
				}
				 echo "</div>";
			 } else {
				echo "<div class=\"border-bottom\">";
				echo "<p>Hãy để lại đánh giá của bạn!</p>";
				echo "</div>";
			}
		}
		
		
		$commentSection = mysqli_query($conn, "SELECT * FROM `comment` WHERE `product_id`= '$product_id' ORDER BY `comment_id` DESC");
		
		if ($commentSection &&mysqli_num_rows($commentSection)!=0) {
			$comment_array= Array();
			while ($row=mysqli_fetch_assoc($commentSection)) {
				array_push($comment_array,$row['comment_id']);
			}
			
			$array_of_pages= Array();
			$array_of_pages= segment($comment_array,$item_in_page);

			for ($i=0;$i<count($array_of_pages);$i++) {
				for($k=0;$k<count($array_of_pages[$i]);$k++) {
					$current_id=$array_of_pages[$i][$k];
					$temp = mysqli_query($conn, "SELECT * FROM `comment` WHERE `comment_id`= '$current_id'");
					$temp = mysqli_fetch_assoc($temp);
					echo "<div class=\"page page_$i border-bottom\">";
						echo "<p><strong>$temp[uname]</strong> đã đánh giá vào lúc $temp[date] UTC</p>";
						echo "<p>$temp[sao]/5 <span class=\"fa fa-star checked\" style=\"color: #ffcd3c;\"></span>";
						echo " - $temp[content]</p>";
						
						if ($temp['admin_reply']!="") {
							echo "<p><strong>Admin đã phản hồi:</strong> ";
							echo "$temp[admin_reply]</p>";
						}
						
						if(isset($_SESSION['privilege']) && $_SESSION['privilege']=="admin") {
							echo "<button class=\"btn btn-outline-secondary\" type=\"button\" onclick=\"reply_comment(this)\" id=\"rep_$temp[comment_id]\">Phản hồi</button>";
							echo "<button class=\"btn btn-outline-secondary\" type=\"button\" onclick=\"delete_comment(this)\" id=\"del_$temp[comment_id]\">Xóa</button>";
							echo "<br><br>";
						} 
						
					echo "</div>";
				}
			}
			
			for ($i=0;$i<count($array_of_pages);$i++) {
				echo"<button class=\"btn btn-outline-secondary\" onclick=\"switchpage(this)\" type=\"button\" id=\"but_$i\">$i</button>";
			}// switch page button
			echo "<script>$('.page').css('display','none');";
			echo  "$('.page_0').css('display','block')</script>";
		} else {
			echo "<div class=\"border-bottom\">";
			echo "<p>0 bình luận.</p>";
			echo "</div>";
		}

	 } else {
		echo "Sản phẩm không tồn tại.";
	 }
	 
	 
 }
?>
<?php
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
<?php
function calculateRating($conn,$product_id){
	$totalComment= mysqli_query($conn, "SELECT * FROM comment WHERE `product_id`= '$product_id'");	
	$totalCommentCount=mysqli_num_rows($totalComment);
				
	$new_sum=0;
	while ($row=mysqli_fetch_assoc($totalComment)) {
	$new_sum+=$row['sao'];
	}
				
	if ($totalCommentCount!=0) {$new_rating = $new_sum/$totalCommentCount;} else {$new_rating=0;};
				
	mysqli_query($conn, "UPDATE `products` SET `total_rate` = '$totalCommentCount' WHERE `product_code`= '$product_id'");
	mysqli_query($conn, "UPDATE `products` SET `avg_rating` = '$new_rating' WHERE `product_code`= '$product_id'");
	
}

?>
<?php
if(isset($_SESSION['privilege']) && $_SESSION['privilege']=="admin") {
	echo <<<SCRIPT
	<script>
	function reply_comment(obj) {	
	$("#back-pop").css("display","block");
	$("#non-admin").css("display","none");
	$("#admin-comment").css("display","block");
	$('html,body').scrollTop(0);
	$('body').css('overflow', 'hidden');	
	$('#back-pop').css('overflow', 'scroll');
					
	$("#idholder").html($(obj).attr('id').slice(4));
	}
	function reply_request(){
		$.ajax({
			type:"POST",
			data: {
			repReq:"yes",
			request_id:$("#idholder").html(),
			reply_content:$("#admin_reply").val(),
			},
			url:"adminComment.php",
			success: function(result) {
			window.location="";
			}
										
		});
								
	}						
	function delete_comment(obj) {
		$("#idholder").html($(obj).attr('id').slice(4));
		$.ajax({
			type:"POST",
			data: {
			revReq:"yes",
			request_id:$("#idholder").html(),
			},
			url:"adminComment.php",
			success: function(result) {
			window.location="";
			}
										
		});
	}
	</script>
SCRIPT;
}
?>