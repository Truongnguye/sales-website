<!doctype html>
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
	   die ("unauthorized request!");
   }
?>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<script>
	var order_info= new Array();
	var pages_info=new Array();
	var item_per_page = 10;
	$("document").ready(function (){ // parse (order list of user) to javascript object  when init
		get_order_table("all");
	});	
	
	function get_order_table(state_req){
		$.ajax({
			type:"POST",
			url:"../order/orderRequest.php",
			data: {getInfo:"yes" ,
					state:state_req},
			success: function (result){
						order_info = JSON.parse(result);
						$("#order-info tr").not("#firstRow").remove();
						$("#order-info button").not("#firstRow").remove();
						for (let i=0; i<order_info.length;i++) {
							order_info[i] = JSON.parse(order_info[i]);	
							order_info[i].order_list = JSON.parse(order_info[i].order_list);
						}
						
						pages_info = segment(order_info,item_per_page);
						
						
						for (let i=0; i<pages_info.length; i++)
						{
							for (let k=0; k < pages_info[i].length;k++ )
							{
							
							$("#order-info").append("<tr class=\"page page_"+i+"\"></tr>");
							$("#order-info tr:last-child").append("<td class=\"text-center\">"+pages_info[i][k].order_id+"</td>");
							$("#order-info tr:last-child").append("<td class=\"text-center\">"+pages_info[i][k].user_id+"</td>");
							$("#order-info tr:last-child").append("<td class=\"text-center\">"+pages_info[i][k].order_price+"</td>");
							$("#order-info tr:last-child").append("<td class=\"text-center\">"+pages_info[i][k].order_state+"</td>");
							$("#order-info tr:last-child").append("<td class=\"text-center\"><button style=\"width: 100%;\" onclick=\"get_order_info(this)\" type=\"button\" class=\"btn btn-secondary get_info\" id=\"order_"+pages_info[i][k].order_id+"\">Info</button></td>"); // create button to get an order's info
							}
						$("#order-info").append("<button class=\"btn btn-outline-secondary\" onclick=\"switchpage(this)\" type=\"button\" id=\"but_"+i+"\">"+i+"</button>")
						}
						
						$(".page").css('display','none');
						$(".page_0").css('display','table-row');
						
					}	
		 });		
	}
	
	function switchpage(obj) {
		current_page=$(obj).attr('id').slice(4);
		$(".page").css('display','none');
		$(".page_"+current_page).css('display','table-row');
	}
	
	function get_order_info(obj) { // open order info when click button
		
		current_id= obj.id.slice(6);
		var order_list_to_show;
		var current_user_id;
		for (let i=0; i < order_info.length; i++) {
			if (order_info[i].order_id==current_id)
			{
			     order_list_to_show = order_info[i].order_list;
				 address = order_info[i].address;	
				 current_user_id = order_info[i].user_id;
				if (order_info[i].order_state=="pending") {
					$("#cancel-submit").show();
					$("#verify-submit").show();
				} else {
					$("#cancel-submit").hide();
					$("#verify-submit").hide();
				}
				if (order_info[i].order_state=="done" || order_info[i].order_state=="verified" ) {
					$("#already-done").show();
				} else {
					$("#already-done").hide();
				}
					 break;
			}
		}
		
		$("#order-cart tr").not("#firstRow-order").remove();
		
		var thanhtien=0;
		for (let i=0; i < order_list_to_show.length; i++)
			{
				$.ajax({
					type:"GET",
					url:"../product/productdatabase.php?req=&id="+order_list_to_show[i].id,
					success: function (result){
								product_info=JSON.parse(result);
								product_info.img=JSON.parse(product_info.img);
								$("#order-cart").append("<tr></tr>");
								$("#order-cart tr:last-child").append("<td><img class=\"img-thumbnail rounded mx-auto d-block\" alt=\"product\" src="+product_info.img[0]+" width=100 height=100></td>");
								$("#order-cart tr:last-child").append("<td class=\"text-center\">"+product_info.pname+"</td>");
								$("#order-cart tr:last-child").append("<td class=\"text-center\">"+product_info.price+"</td>");
								$("#order-cart tr:last-child").append("<td class=\"text-center\">"+order_list_to_show[i].amount+"</td>");
								
								
								thanhtien+=  parseInt(product_info.price_numberic*order_list_to_show[i].amount);
								
								if (i == order_list_to_show.length-1)
								{
									$("#order-user-id").html("<br>ID của khách hàng: "+current_user_id);
									$("#address").html("Địa chỉ: "+address);
									$("#thanhtien").html("Thành tiền: "+thanhtien);
								}
							}								
				});
			}// tao bang popup
		$("#cancel-submit").val(current_id);
		$("#back-pop").css("display","block");
		$('html,body').scrollTop(0);
		
		$('body').css('overflow', 'hidden');
		$('#back-pop').css('overflow', 'scroll');
		
		
	}
	
	function back() {
		$("#order-cart tr").not("#firstRow-order").remove();
		$("#thanhtien").html("0");
		$("#back-pop").css("display","none");
		$('body').css('overflow', 'scroll');
		$("#cancel-submit").val("none");
	}
	
	function cancel() {
		$.ajax({
			type:"POST",
			url:"order/orderRequest.php",
			data: {calReq:"yes",
				  order_id: parseInt($("#cancel-submit").val())
				  },
			success: function (result){
				alert(result);
				window.location="admin.php";
			}
		});
	}
	
	function verify() {
		$.ajax({
			type:"POST",
			url:"order/orderRequest.php",
			data: {verReq:"yes",
				  order_id: parseInt($("#cancel-submit").val())
				  },
			success: function (result){
				alert(result);
				window.location="admin.php";
			}
		});
	}
	
		
	
	function segment(arr,max_item_in_page) {
		var pagecount = parseInt(arr.length / max_item_in_page) + ((arr.length % max_item_in_page)? 1:0);
		var array_of_pages = new Array();
		var item;
		for ( let i=0; i< pagecount; i++) {
			if (pagecount - 1 == i){
				array_of_pages.push(arr);
			} else {
				item = arr.slice(0,max_item_in_page);
				arr = arr.slice(max_item_in_page);
				array_of_pages.push(item);
			}
		}
		return array_of_pages;
	}
		
	</script>
	<!---mycode---->

<!----mycode---->
<div id ="table-container">
	<div class="container  border-bottom py-3" style="margin-left: auto; margin-right:auto;">
        <div class="row">
          <div class="col-sm center">
            <button id="get_all" type="button" class="btn btn-outline-secondary"  onclick="get_order_table('all')" value="none" style="width: 100%;">
              Tất cả
            </button>
          </div>

          <div class="col-sm center">
            <button id="get_pend" type="button" class="btn btn-outline-secondary"  onclick="get_order_table('pending')" value="none" style="width: 100%;">
              Đang xử lý
            </button>
          </div>
          
          <div class="col-sm center">
            <button id="get_ver" type="button" class="btn btn-outline-secondary" onclick="get_order_table('verified')" value="none" style="width: 100%;">
				Đã xác nhận
            </button>
          </div>

          <div class="col-sm center">
            <button id="get_done" type="button" class="btn btn-outline-secondary" onclick="get_order_table('done')" value="none" style="width: 100%;">
				Hoàn tất	
            </button>
          </div>
        </div>
      </div>

	<table id="order-info"  class="table-bordered table">
	<tr id="firstRow" class="text-center">
		<th>Mã đơn hàng</th>
		<th>ID khách hàng</th>
		<th>Thành tiền </th>
		<th>Trạng thái</th>
		<th>Xem thông tin</th>
	</tr>
	</table>
</div>
	
<!----mycode---->




