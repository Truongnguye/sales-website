<!doctype html>
<html lang="vi">
<!----mycode---->
<?php
    include 'cartRequest.php';//$userdb is user database, conn is connection
   
   if (!isset($_SESSION['username'])) {
	   
	   header('Location: signin.php');
	   
   }
   if ($_SESSION['privilege']=="admin") {
	    header('Location: admin.php');
   }
?>
<!----mycode---->
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="/css/home.css">
	<link rel="stylesheet" href="css/pop_up.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    
    <title>Đơn hàng</title>
	
		
	<!---mycode---->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<script>
	var order_info= new Array();
	var pages_info=new Array();
	var item_per_page=5;
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
							$("#order-info tr:last-child").append("<td class=\"text-center\">"+pages_info[i][k].order_price+"</td>");
							$("#order-info tr:last-child").append("<td class=\"text-center\">"+pages_info[i][k].order_state+"</td>");
							$("#order-info tr:last-child").append("<td><button style=\"width: 100%;\" onclick=\"get_order_info(this)\" type=\"button\" class=\"btn btn-secondary get_info\" id=\"order_"+pages_info[i][k].order_id+"\">Info</button></td>"); // create button to get an order's info
							}
						$("#order-info").append("<button class=\"btn btn-outline-secondary\" onclick=\"switchpage(this)\" type=\"button\" id=\"but_"+i+"\">"+i+"</button>")
						}
						
						$(".page").css('display','none');
						$(".page_0").css('display','table-row');
						
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
		
	function get_order_info(obj) { // open order info when click button
		
		current_id= obj.id.slice(6);
		var order_list_to_show;
		for (let i=0; i < order_info.length; i++) {
			if (order_info[i].order_id==current_id)
			{
				 order_list_to_show = order_info[i].order_list;
				 
				 address = order_info[i].address;
				 
				 switch (order_info[i].order_state) {
					 case "pending":
					 $("#cancel-submit").show();
					 $("#done-submit").hide();
					 $("#already-done").hide();
					 break;
					 case "verified":
					 $("#cancel-submit").hide();
					 $("#done-submit").show();
					 $("#already-done").hide();
					 break;
					 case "done":
					 $("#cancel-submit").hide();
					 $("#done-submit").hide();
					 $("#already-done").show();
					 break;
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
					url:"product/productdatabase.php?req=&id="+order_list_to_show[i].id,
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
	
	function switchpage(obj) {
		current_page=$(obj).attr('id').slice(4);
		$(".page").css('display','none');
		$(".page_"+current_page).css('display','table-row');
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
				window.location="donhang.php";
			}
		});
	}
	
	function done() {
		$.ajax({
			type:"POST",
			url:"order/orderRequest.php",
			data: {doneReq:"yes",
				  order_id: parseInt($("#cancel-submit").val())
				  },
			success: function (result){
				alert(result);
				window.location="donhang.php";
			}
		});
	}

	</script>
	<!---mycode---->
</head>

<body>  
    
<div class="container">
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="home.php" class="d-flex align-items-center col-md-4 mb-2 mb-md-0 text-dark text-decoration-none">
          <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
          <span class="fs-4">LAPINE STORE</span>
        </a>
  
        <ul class="nav col-12 col-md-4 mb-2 justify-content-center mb-md-0">
          <li><a href="/home.php" class="nav-link px-2 link-secondary">Trang chủ</a></li>
          <li><a href="/gioithieu.php" class="nav-link px-2 link-dark">Giới thiệu</a></li>
          <li><a href="/lienhe.php" class="nav-link px-2 link-dark">Liên hệ</a></li>
        </ul>
		<!----cho dang nhap/ dang ki, hien thi thong tin khi dang nhap thanh cong---->
        <div class="col-md-4 text-end">
          <!----cho dang nhap/ dang ki, hien thi thong tin khi dang nhap thanh cong---->
          <?php
            if(isset($_SESSION["username"])) {
          ?>
              <button type="button" class="btn btn-outline-dark" onclick="location.href='info.php'">
                <?php 
                  echo $user_info["uname"];
                  echo ": ";
                  echo "$user_info[ubalance] VNĐ";
                  ?>
              </button>
              <button type="button" class="btn btn-dark" onclick="location.href='/login/logout.php'">Đăng xuất</button>
          <?php } 
            else { 
          ?>
              <button type="button" class="btn btn-dark" onclick="location.href='/signin.php'">Đăng nhập</button>
              <button type="button" class="btn btn-outline-dark" onclick="location.href='/signup.php'">Đăng ký</button>
          <?php 
            }// chua dang nhap
          ?>
        </div>
    </header>
</div> 

<div class="bg-dark">
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2">
        <div class="dropdown d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
              Danh mục sản phẩm
            </button>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
              <div class="offcanvas-header">
                <h5 id="offcanvasTopLabel">Danh mục sản phẩm</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <div class="list-group">
                  <button type="button" class="list-group-item list-group-item-action list-group-item-dark" aria-current="true">
                    <strong>
                      Tất cả sản phẩm
                    </strong>
                  </button>
					<button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=ak'">
                    Áo khoác
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=ap'">
                    Áo phông
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=asm'">
                    Áo sơ mi
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=blz'">
                    Blazer
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=cl'">
                    Com lê
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=d'">
                    Đầm
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=gi'">
                    Giày
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=q'">
                    Quần
                  </button>
                </div>
              </div>
            </div>
        </div>
  
        <div class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        </div>
  
        <div class="col-md-3 text-end">
            <button type="button" class="btn btn-light me-2"  onclick="location.href='/giohang.php'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z"/>
                </svg>
            </button>
            <button type="button" class="btn btn-outline-light"  onclick="location.href='/donhang.php'">Đơn hàng</button>
        </div>
    </header>
</div> 
</div>





<main>
  <div class="container py-3 mb-4">
    <h1 class="container border-bottom">
        Đơn hàng
    </h1>
	<!----mycode---->
	<div class="container  border-bottom py-3" style="margin-left: auto; margin-right:auto;">
	<div class="row">
		<div class="col-sm center">
			<button class="btn btn-outline-secondary" type="button" id="get_all" onclick="get_order_table('all')" value="none">
			Tất cả
			</button>
		</div>
		
		<div class="col-sm center">
			<button class="btn btn-outline-secondary" type="button" id="get_pend" onclick="get_order_table('pending')" value="none">
			Đang xử lý
			</button>
		</div>	

		<div class="col-sm center">
			<button class="btn btn-outline-secondary" type="button" id="get_ver" onclick="get_order_table('verified')" value="none">
			Đã xác nhận
			</button>
		</div>
		
		<div class="col-sm center">
			<button class="btn btn-outline-secondary" type="button" id="get_done" onclick="get_order_table('done')" value="none">
			Hoàn tất
			</button>
		</div>
	</div>
	</div>
	
	<table id="order-info"  class="table table-bordered">
	<tr id="firstRow" class="text-center">
		<th>Mã đơn hàng</th>
		<th>Thành tiền</th>
		<th>Trạng thái</th>
		<th>Xem trạng thái</th>
	</tr>
	</table>
	
	<!----mycode---->
	
	
	

  </div>
  
  
</main>




<footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="/home.php" class="nav-link px-2 text-muted">Trang chủ</a></li>
      <li class="nav-item"><a href="/gioithieu.php" class="nav-link px-2 text-muted">Giới thiệu</a></li>
      <li class="nav-item"><a href="/lienhe.php" class="nav-link px-2 text-muted">Liên hệ</a></li>
    </ul>
    <p class="text-center text-muted">© 2021 Company, Inc</p>
</footer>

<!-----pop up----->
<div id="back-pop" class="ontop">
<div id="order-box" style="padding: 2%">
	<button class="btn btn-danger" type="button" id="back" onclick="back()" value="back">X</button>
	<br>
	<br>
		<table id="order-cart" class="table table-bordered">
		<tr id="firstRow-order" class="text-center">
			<th>Hình ảnh</th>
			<th>Tên sản phẩm</th>
			<th>Giá</th>
			<th>Số lượng</th>
		</tr>
		</table>

	<p id="thanhtien" style="color: red;"></p>
	<p id="address"></p>
	<div class="d-grid gap-2">
	<button type="button" class="btn btn-danger" id="cancel-submit" onclick="cancel()" value="none">Huỷ đơn</button>
	</div>
	<button type="button" id="done-submit" onclick="done()" value="none">Xác nhận đã nhận hàng</button>
	<button type="button" id="already-done" value="none" class="btn btn-secondary">Đơn hàng đã được xử lý</button>
</div>
</div>
<!-----pop up----->

  
    
</body>
</html>
