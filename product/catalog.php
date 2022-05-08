<!doctype html>
<?php
	if (session_status() === PHP_SESSION_NONE) {
    session_start();
	}
	include '../login/userdb.php';
	if (!isset($_GET['cata'])){
		header('Location: ../home.php');
	} else {
		$loai="";
		switch ($_GET['cata']){
			case "ak":
			$loai="Áo khoác";
			break;
			case "asm":
			$loai="Áo sơ mi";
			break;
			case "ap":
			$loai="Áo phông";
			break;
			case "d":
			$loai="Đầm";
			break;
			case "blz":
			$loai="Blazer";
			break;
			case "cl":
			$loai="Com lê";
			break;
			case "gi":
			$loai="Giày";
			break;
			case "q":
			$loai="Quần";
			break;
			
		}
	}
	if ($loai != "Com lê" && $loai != "Áo khoác" &&$loai != "Áo phông" &&$loai != "Áo sơ mi" &&$loai != "Blazer" &&$loai != "Giày" &&$loai != "Quần" &&$loai != "Đầm"){
		header('Location: ../home.php');
	}
	
   if(isset($_SESSION["username"])) {
	   
		$user_info = mysqli_query($conn,"SELECT * FROM userdb WHERE `uname` = \"$_SESSION[username]\"");
		
	    if( mysqli_num_rows($user_info) != 0) {
			
			$user_info=mysqli_fetch_assoc($user_info); // user info row in database
			
		} else {
			die("Could not find user, something went wrong!");
		}
   } // get user info if user has logged in
   else {
	   //user not logged in
   }
?>
<html lang="vi">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="/css/home.css">
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
    
    <title><?php echo "$loai"; ?></title>
	<!-- code t them -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
	$("document").ready(function (){ // add to cart
		$(".cart_add").click( function (){
<?php
		if(isset($_SESSION['username'])) {
		echo <<<STRR
		$.ajax({
				type:"GET",
				url:"../cartRequest.php?addReq="+$(this).attr('id'),
				success: function (result){
							alert(result);
						}	
			});	
STRR;
		} else {
		echo" window.location='../signin.php'";
		}
?>
	}); 
}); 

	$("document").ready(function (){  // gửi request make order
	$("#order-submit").click( function (){
<?php
		if(isset($_SESSION['username'])) {
		echo <<<STRR
			current_product_id = $("#idquickref").html();
			var item_sending=new Array();
					item = {
						amount: $("#amount_"+current_product_id).children('span').html(),
						id: current_product_id,
					}
					item_sending.push(item);

			
			data = {
				addReq: "yes",
				order_list: JSON.stringify(item_sending),
				address:$("#address").val(),
			}
			
			$.ajax({
				type:"POST",
				data: data,
				url:"../order/orderRequest.php",
				success: function (result){
							alert(result);
							window.location="";
						}	
			});// gửi request xóa
			
STRR;
		} else {
		echo" window.location='../signin.php'";
		}
?>
		});
	});
	
	function buynow(obj) {
<?php	if(isset($_SESSION['username'])) {
			 echo <<<STR
		current_product_id = $(obj).attr('id').slice(0,-4);
		$("#order-cart tr").not("#firstRow-order").remove();
			$.ajax({
				type:"GET",
				url:"../product/productdatabase.php?req=&id="+current_product_id,
				success: function (result){
							product_info=JSON.parse(result);
							product_info.img=JSON.parse(product_info.img);
							$("#order-cart").append("<tr></tr>");
							$("#order-cart tr:last-child").append("<td><img class=\"img-thumbnail rounded mx-auto d-block\" alt=\"product\" src="+product_info.img[0]+" width=100 height=100></td>");
							$("#order-cart tr:last-child").append("<td class=\"text-center\">"+product_info.pname+"</td>");
							$("#order-cart tr:last-child").append("<td class=\"text-center\">"+product_info.price+"</td>");
							
							$("#order-cart tr:last-child").append("<td class=\"text-center\" id=\"amount_"+product_info.id+"\"></td>"); //amount select column
							
							$("#amount_"+product_info.id).append("<button onclick=\"addAmount(this)\" type=\"button\" class=\"btn btn-secondary addamount\">+</button>");
							$("#amount_"+product_info.id).append("<br><span class=\"amount\">1</span><br>"); // có sửa thì vẫn giữ nguyên cái này span
							$("#amount_"+product_info.id).append("<button onclick=\"subAmount(this)\" type=\"button\" class=\"btn btn-secondary subamount\">-</button>");

							$("#amount_"+product_info.id).append("<p id=\"idquickref\" style= \"display:none\">"+product_info.id+"</p>");
							$("#amount_"+product_info.id).append("<p id=\"pricequickref\" style= \"display:none\">"+product_info.price_numberic+"</p>");
							
							thanhtien =  parseInt(product_info.price_numberic)*parseInt($("#amount_"+product_info.id).children('span').html());
							$("#thanhtien").html("Thành tiền: "+thanhtien);
						}	
			});
		$("#back-pop").css("display","block");
		$("#non-admin").css("display","block");
		$('html,body').scrollTop(0);
		$('body').css('overflow', 'hidden');	
		$('#back-pop').css('overflow', 'scroll');
			
STR;
		} 
		else {
		  echo" window.location='../signin.php'";
		}
?>
	}
	
	function addAmount(obj){ // increase the amount
		$(obj).parent().children("span").html( parseInt($(obj).parent().children("span").html()) + 1 );
		
		var noOfitem = $(obj).parent().children("span").html();
		var priceOfitem=  $("#pricequickref").html();
		thanhtien = parseInt(noOfitem) * parseInt(priceOfitem);
		$("#thanhtien").html("Thành tiền: "+thanhtien );
	}
	
	function subAmount(obj){
		if ( parseInt($(obj).parent().children("span").html()) <= 1 ) { // decrease the amount if the amount is larger than 1
			return;
		} else {
			
			$(obj).parent().children("span").html( parseInt($(obj).parent().children("span").html()) - 1 );
			
			var noOfitem = $(obj).parent().children("span").html();
			var priceOfitem=  $("#pricequickref").html();
			
			thanhtien = parseInt(noOfitem) * parseInt(priceOfitem);
 			$("#thanhtien").html("thanh tien "+thanhtien);
		}
	}
	
	$("document").ready(function (){// tat bang order pop up
		$("#back").click( function (){ 
			
			$("#order-cart tr").not("#firstRow-order").remove();
			$("#thanhtien").html("0");
			$("#back-pop").css("display","none");
			$('body').css('overflow', 'scroll');
			$("#admin-comment").css("display","none");			
			
		});
	});

	</script>
<!-- code t them -->
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
              <button type="button" class="btn btn-outline-dark" onclick="location.href='/info.php'">
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
      <?php echo"$loai"; ?>
    </h1>
	<?php
		$get_product=mysqli_query($conn,"SELECT * FROM products WHERE `loai`='$loai'");
		$max_per_row=3;
		$counter=0;
		$addDiv=true;
	?>
  <?php 
	while ($row=mysqli_fetch_assoc($get_product)) {
	  $addDiv=true;
	  $counter++;
      $img = json_decode($row['img'], true);
      $other_link = "$row[link]";
	  if ($counter==1) { 
	  echo "<div class=\"row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3\">";
	  }
	  echo <<<DOC
    <div class="col">


      <div class="card shadow-sm">

        <div class="container_image" style="height: 700px;">
          <a href="$other_link">
            <img src="$img[0]" class="img-thumbnail image" alt="product">
          </a>
          <div class="middle">
              <button type="button" class="btn btn-outline-dark" onclick="location.href='$other_link'">Xem chi tiết</button>
          </div>
        </div>

        <div class="card-body">
          <p class="card-text">
            $row[tensanpham_vietthuong]
          </p>
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-secondary" onclick="buynow(this)" id="$row[product_code]_now">Mua ngay</button>
              <button type="button" class="btn btn-sm btn-outline-secondary cart_add" id="$row[product_code]">Thêm vào giỏ hàng</button>
            </div>
            <small class="text-muted">$row[price]</small>
          </div>
        </div>
      </div>
    </div>


DOC;
	   if ($counter>=$max_per_row ) { $addDiv=false;$counter=0; echo "</div>";}
  }
	if ($addDiv== true) echo "</div>";

  ?>
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
	<div id="order-box"  style="padding: 2%">
		<button class="btn btn-danger" type="button" id="back" value="back">X</button>
		<br><br>

		<div id="non-admin">
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
</div>
<!-----pop up----->

    
</body>
</html>
