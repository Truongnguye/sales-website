<!doctype html>
<html lang="vi">
<!----mycode---->
<?php
   include 'cartRequest.php'; //$user_info is the row of the logged in user in the data base.
    if ($_SESSION['privilege']=="admin") {
	    header('Location: admin.php');
   }
?>
<!----mycode---->
<head>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="/css/home.css">
	<link rel="stylesheet" href="/css/pop_up.css">
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
    
    <title>Giỏ hàng</title>
	<?php
	if (!isset($_SESSION['username'])) {
	   
	   header('Location: signin.php');
	   
   } else {
		echo "<script>var cartList=$user_info[cart]</script>";// get cartList as an array of item in the cart
   }
  ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<script>
	var item_per_page = 3;
	var product_info;
	var page_info = new Array();
	
	$("document").ready(function (){
		init();
		$("#back-pop").css("display","none");
	});
	function init(){
		page_info = segment(cartList,item_per_page);
		$("#cart tr").not("#firstRow").remove();
		$(".pageButton").remove();
		var sync=0;
		for (let i=0 ;i<page_info.length; i++) {
			for (let k=0; k < page_info[i].length; k++)
			{
				$.ajax({
					type:"GET",
					url:"product/productdatabase.php?req=&id="+page_info[i][k],
					success: function (result){
								sync++;
								product_info=JSON.parse(result);
								product_info.img=JSON.parse(product_info.img);
								$("#cart").append("<tr class=\"page page_"+i+"\"></tr>");
								$("#cart tr:last-child").append("<td class=\"text-center\"><input type=\"checkbox\" id=\""+product_info.id+"\"></td>");
								$("#cart tr:last-child").append("<td><img class=\"img-thumbnail rounded mx-auto d-block\" alt=\"product\" src="+product_info.img[0]+" width=100 height=100></td>");
								$("#cart tr:last-child").append("<td class=\"text-center\"><a href=\"product/product.php?id="+product_info.id+"\">"+product_info.pname+"</a></td>");
								$("#cart tr:last-child").append("<td class=\"text-center\">"+product_info.price+"</td>");
								
								$("#cart tr:last-child").append("<td  class=\"text-center\" id=\"amount_"+product_info.id+"\"></td>"); //amount select column
								$("#amount_"+product_info.id).append("<button onclick=\"addAmount(this)\" type=\"button\" class=\"btn btn-secondary addamount\">+</button>");
								$("#amount_"+product_info.id).append("<br><span class=\"amount\">1</span><br>"); // có sửa thì vẫn giữ nguyên cái này span
								$("#amount_"+product_info.id).append("<button onclick=\"subAmount(this)\" type=\"button\" class=\"btn btn-secondary subamount\">-</button>");

								if (sync==(page_info.length-1)*item_per_page+page_info[page_info.length-1].length) {
									createSwitchButton(page_info.length);
								}
								
							} 	
				});

			}
		}
	}// print all item in the cart item array.
	
	
	function createSwitchButton(no_of_button){
		$(".pageButton").remove();
		for (let i=0;i<no_of_button;i++) {
			$("#cart").append("<button class=\"btn btn-outline-secondary pageButton\" onclick=\"switchpage(this)\" type=\"button\" id=\"but_"+i+"\">"+i+"</button>")
			$(".page").css('display','none');
			$(".page_0").css('display','table-row');
		}
	}
	
	$("document").ready(function (){ // gửi request delete các item được đánh dấu xóa ra khỏi cart
		$("#delete").click( function (){ 
			
			var remain_item=new Array();
			for (let i=0; i < cartList.length; i++)
			{
				if (!$("#"+cartList[i]).is(":checked"))
				{
					remain_item.push(cartList[i]);
				}
			} // lọc tất cả item được đánh dấu
			
			cartList=remain_item;
			$.ajax({
				type:"GET",
				url:"cartRequest.php?revReq="+JSON.stringify(cartList),
				success: function (){
							init();
						}	
			});// gửi request xóa
			
		});
	});	
	
	$("document").ready(function (){  // gửi request make order
		$("#order-submit").click( function (){
			
			var item_sending=new Array();
			for (let i=0; i < cartList.length; i++)
			{
				if ($("#"+cartList[i]).is(":checked"))
				{
					item = {
						amount: $("#amount_"+cartList[i]).children('span').html(),
						id: cartList[i],
					}
					item_sending.push(item);
				}
			} // lọc tất cả item được đánh dấu

			data = {
				addReq: "yes",
				order_list: JSON.stringify(item_sending),
				address:$("#address").val(),
			}
			
			$.ajax({
				type:"POST",
				data: data,
				url:"order/orderRequest.php",
				success: function (result){
							alert(result);
							window.location="giohang.php";
						}	
			});// gửi request xóa
			
		});
	});
	
	
	$("document").ready(function (){// hien bang order khi nhan nut
		$("#order").click( function (){ 
			
			var item_sending=new Array();
			for (let i=0; i < cartList.length; i++)
			{
				if ($("#"+cartList[i]).is(":checked"))
				{
					item_sending.push(cartList[i]);
				}
			} // loc item duoc danh dau de hien thi len bang popup
			
			if (item_sending.length==0) { alert("Thêm ít nhất 1 sản phẩm!"); return;}
			
			
			$("#order-cart tr").not("#firstRow-order").remove();
			
			var thanhtien = 0;
			for (let i=0; i < item_sending.length; i++)
			{
				$.ajax({
					type:"GET",
					url:"product/productdatabase.php?req=&id="+item_sending[i],
					success: function (result){
								product_info=JSON.parse(result);
								product_info.img=JSON.parse(product_info.img);
								$("#order-cart").append("<tr></tr>");
								$("#order-cart tr:last-child").append("<td><img class=\"img-thumbnail rounded mx-auto d-block\" alt=\"product\" src="+product_info.img[0]+" width=100 height=100></td>");
								$("#order-cart tr:last-child").append("<td  class=\"text-center\">"+product_info.pname+"</td>");
								$("#order-cart tr:last-child").append("<td  class=\"text-center\">"+product_info.price+"</td>");
								$("#order-cart tr:last-child").append("<td  class=\"text-center\">"+$("#amount_"+product_info.id).children('span').html()+"</td>");
								
								thanhtien+=  parseInt(product_info.price_numberic)*$("#amount_"+product_info.id).children('span').html();
								
								if (i == item_sending.length-1)
								{
									$("#thanhtien").html("Thành tiền: "+thanhtien);
								}
							}	
				});
			}// tao bang popup
			$("#back-pop").css("display","block");
			$('html,body').scrollTop(0);
			$('body').css('overflow', 'hidden');
			$('#back-pop').css('overflow', 'scroll');
			
		});
	});
	
	$("document").ready(function (){// tat bang order pop up
		$("#back").click( function (){ 
			
			$("#order-cart tr").not("#firstRow-order").remove();
			$("#thanhtien").html("0");
			$("#back-pop").css("display","none");
			$('body').css('overflow', 'scroll');
			
		});
	});
	
	function addAmount(obj){ // increase the amount
		$(obj).parent().children("span").html( parseInt($(obj).parent().children("span").html()) + 1 );
	}
	
	function subAmount(obj){
		if ( parseInt($(obj).parent().children("span").html()) <= 1 ) { // decrease the amount if the amount is larger than 1
			return;
		} else {
			$(obj).parent().children("span").html( parseInt($(obj).parent().children("span").html()) - 1 );
		}
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
	
	function switchpage(obj) {
		current_page=$(obj).attr('id').slice(4);
		$(".page").css('display','none');
		$(".page_"+current_page).css('display','table-row');
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
        Giỏ hàng
    </h1>
	<!----mycode---->
	<table id="cart" class="table table-bordered">
	<tr id="firstRow" class="text-center">
		<th>Chọn</th>
		<th>Hình ảnh</th>
		<th>Tên sản phẩm</th>
		<th>Giá</th>
		<th>Số lượng</th>
	</tr>
	
	
	<!----mycode---->
	
	</table>
	<button  class="btn btn-secondary" type="button" id="delete" value="Delete">Xoá</button>
	<button  class="btn btn-danger" type="button" id="order" value="Make order">Đặt hàng</button>
	
	
	

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
	<button class="btn btn-danger" type="button" id="back" value="back">X</button>
	<br><br>
		<table id="order-cart" class="table table-bordered">
		<tr id="firstRow-order" class="text-center">
			<th>Hình ảnh</th>
			<th>Tên sản phẩm</th>
			<th>Giá</th>
			<th>Số lượng</th>
		</tr>
		</table>
	<p id="thanhtien" style="color: red;"></p>
	<label>Địa chỉ:</label>
	<br>
	<textarea class="form-control" id="address" placeholder="Nhập địa chỉ..."></textarea>
	<br>
	<div class="d-grid gap-2">
	<button class="btn btn-danger" type="button" id="order-submit" value="Submit order">Đặt hàng</button>
	</div>
</div>
</div>
<!-----pop up----->

  
    
</body>
</html>
