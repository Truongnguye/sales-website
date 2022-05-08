<!doctype html>
<html lang="vi">

<?php
  include '../login/userdb.php'; //$userdb is user database, conn is connection
  if (!isset($_GET['id'])) {
	 header("Location: ..\home.php");
  }
?>

<?php
   
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
   }
?>
<!------code t them----->

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="/css/home.css">
		<link rel="stylesheet" href="../css/pop_up.css">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	 <?php 
	  include 'comment.php';
	  calculateRating($conn,$_GET['id']);// calculate rating before getting product info
	  include 'productdatabase.php';
	
	
	  $img        = json_decode($row['img'], true);
	  
	  if (json_last_error() !== JSON_ERROR_NONE) { echo "<script>window.location='/home.php'</script>";}
	  
	  $other     = json_decode($row['other_code'], true);
	  
	  date_default_timezone_set('UTC');
  
	 ?>
    <title>
      <?php echo "$row[loai]"; ?> - <?php echo "$row[product_code]"; ?>
    </title>
	
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
							$("#order-cart tr:last-child").append("<td  class=\"text-center\">"+product_info.pname+"</td>");
							$("#order-cart tr:last-child").append("<td  class=\"text-center\">"+product_info.price+"</td>");
							
							$("#order-cart tr:last-child").append("<td  class=\"text-center\" id=\"amount_"+product_info.id+"\"></td>"); //amount select column
							
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
		$("#admin-comment").css("display","none");
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
		$("#thanhtien").html("Thành tiền: "+thanhtien);
	}
	
	function subAmount(obj){
		if ( parseInt($(obj).parent().children("span").html()) <= 1 ) { // decrease the amount if the amount is larger than 1
			return;
		} else {
			
			$(obj).parent().children("span").html( parseInt($(obj).parent().children("span").html()) - 1 );
			
			var noOfitem = $(obj).parent().children("span").html();
			var priceOfitem=  $("#pricequickref").html();
			
			thanhtien = parseInt(noOfitem) * parseInt(priceOfitem);
 			$("#thanhtien").html("Thành tiền: "+thanhtien);
		}
	}
	
	function subSao(){
		if (parseInt($("#sao").val())>=2) {
			$("#sao").val(parseInt($("#sao").val())-1);
		}
	}
	function addSao(){
		if (parseInt($("#sao").val())<=4) {
			$("#sao").val(parseInt($("#sao").val())+1);
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
	
	function switchpage(obj) {
		current_page=$(obj).attr('id').slice(4);
		$(".page").css('display','none');
		$(".page_"+current_page).css('display','block');
	}
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
              <button type="button" class="btn btn-outline-dark" onclick="location.href='../info.php'">
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
    <?php echo "$row[loai]"; ?> 
  </h1>

  <div class="row">
    <div class="col-sm-6">
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src=" <?php echo "$img[0]"; ?> " class="d-block w-100" alt="product">
          </div>
          <div class="carousel-item">
            <img src=" <?php echo "$img[1]"; ?> " class="d-block w-100" alt="product">
          </div>
          <div class="carousel-item">
            <img src=" <?php echo "$img[2]"; ?> " class="d-block w-100" alt="product">
          </div>
          <div class="carousel-item">
            <img src=" <?php echo "$img[3]"; ?> " class="d-block w-100" alt="product">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>

    <div class="col-sm-6 text-justify">
      <div>
        <h2 class="pb-2 text-left">
          <?php echo "$row[tensanpham_viethoa]"; ?>
        </h2>
      </div>
	  
	  <?php echo "<p> Đánh giá: $row[avg_rating] <span class=\"fa fa-star checked\" style=\"color: #ffcd3c;\"></span> - "; ?>
	  <?php echo "$row[total_rate] lượt đánh giá </p>"; ?>

      <h3 style="color: orange" class="big">
        <?php echo "$row[price]"; ?>
      </h3>

      <p>
        <strong>
          Mô tả: 
        </strong>
        <?php echo "$row[mota]"; ?>
      </p>

      <p>
        <strong>
          Cách bảo quản:
        </strong>
        <?php echo "$row[cachbaoquan]"; ?>
      </p>

      <p>
        <strong>
          Nguồn gốc: 
        </strong>
        <?php echo "$row[xuatxu]"; ?>
      </p>
      <br>

      <button type="button" class="btn btn-outline-secondary cart_add"  style="width: 100%;" id="<?php echo "$row[product_code]"; ?>">
        Thêm vào giỏ hàng
      </button>
      <button type="button" class="btn btn-secondary" onclick="buynow(this)" id="<?php echo "$row[product_code]"; ?>_now" style="width: 100%;">
        Mua ngay
      </button>
      <br>
      <br>

      <?php 
        if (isset($_SESSION['id']) && $_SESSION['privilege']!="admin") {
        echo "
        <div class=\"container border-top border-bottom border-left border-right\">
          <br>
          <form method='POST' action='#".setComment($conn)."'>
          
          <p class=\"text-center\"><strong>Chọn điểm đánh giá</strong><br></p>
          <div class=\"input-group mb-3\">
              <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"button-addon2\" onclick=\"subSao()\">-</button>

              <input type=\"text\" class=\"text-center form-control\" placeholder=\"\" 
              aria-label=\"Example text with button addon\" aria-describedby=\"button-addon1\" name=\"sao\" id=\"sao\" value=\"3\">

              <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"button-addon1\" onclick=\"addSao()\">+</button>
          </div>
          
          <textarea style=\"height: 100px\" class=\"form-control\" placeholder=\"Nhập lời đánh giá...\" name='content'></textarea>

          <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
          <input type='hidden' name='product_id' value='$row[product_code]'>

          <div class=\"d-grid gap-2\">
          <button class=\"btn btn-secondary\" type='submit' name='CSubmit'>Gửi đánh giá</button>
          </div>
          <br>
          <br>
          </form>
        </div>
          ";
        }
        ?>
    </div>
  </div>
</div>

<div class="container py-3 mb-4">
  <h1 class="container border-bottom">
    Đánh giá
  </h1>


  <?php
        if (isset($_SESSION['id'])) {
          showComment($conn,$row['product_code'],$_SESSION['id']);
        } else {
          showComment($conn,$row['product_code'],"none");
        }
  ?>
</div>


<div class="container py-3 mb-4">
  <h1 class="container border-bottom">
    Sản phẩm tương tự
  </h1>

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    <div class="col">
      <?php 
        $product = mysqli_query($conn,"SELECT * FROM products WHERE `product_code` = \"$other[0]\"");
        
        if($product) {
          $row=mysqli_fetch_assoc($product); // ok ready to fetch data
        } else {
          echo "Error: Could not access database!";
        }

        $img = json_decode($row['img'], true);
        $other_link = "$row[link]";
      ?>

      <div class="card shadow-sm">

        <div class="container_image" style="height: 700px;">
          <a href=" <?php echo $other_link; ?> ">
            <img src=" <?php echo "$img[0]"; ?> " class="img-thumbnail image" alt="product">
          </a>
          <div class="middle">
              <button type="button" class="btn btn-outline-dark" onclick="location.href=' <?php echo $other_link; ?> '">Xem chi tiết</button>
          </div>
        </div>

        <div class="card-body">
          <p class="card-text">
            <?php echo "$row[tensanpham_vietthuong]"; ?>
          </p>
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-secondary" onclick="buynow(this)" id="<?php echo "$row[product_code]"; ?>_now">Mua ngay</button>
              <button type="button" class="btn btn-sm btn-outline-secondary cart_add" id="<?php echo "$row[product_code]"; ?>">Thêm vào giỏ hàng</button>
            </div>
            <small class="text-muted"><?php echo "$row[price]"; ?></small>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <?php 
        $product = mysqli_query($conn,"SELECT * FROM products WHERE `product_code` = \"$other[1]\"");
        
        if($product) {
          $row=mysqli_fetch_assoc($product); // ok ready to fetch data
        } else {
          echo "Error: Could not access database!";
        }

        $img = json_decode($row['img'], true);
        $other_link = "$row[link]";
      ?>

      <div class="card shadow-sm">

        <div class="container_image" style="height: 700px;">
          <a href=" <?php echo $other_link; ?> ">
            <img src=" <?php echo "$img[0]"; ?> " class="img-thumbnail image" alt="product">
          </a>
          <div class="middle">
              <button type="button" class="btn btn-outline-dark" onclick="location.href=' <?php echo $other_link; ?> '">Xem chi tiết</button>
          </div>
        </div>

        <div class="card-body">
          <p class="card-text">
            <?php echo "$row[tensanpham_vietthuong]"; ?>
          </p>
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-secondary" onclick="buynow(this)" id="<?php echo "$row[product_code]"; ?>_now">Mua ngay</button>
              <button type="button" class="btn btn-sm btn-outline-secondary cart_add" id="<?php echo "$row[product_code]"; ?>">Thêm vào giỏ hàng</button>
            </div>
            <small class="text-muted"><?php echo "$row[price]"; ?></small>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <?php 
        $product = mysqli_query($conn,"SELECT * FROM products WHERE `product_code` = \"$other[2]\"");
        
        if($product) {
          $row=mysqli_fetch_assoc($product); // ok ready to fetch data
        } else {
          echo "Error: Could not access database!";
        }

        $img = json_decode($row['img'], true);
        $other_link = "$row[link]";
      ?>

      <div class="card shadow-sm">

        <div class="container_image" style="height: 700px;">
          <a href=" <?php echo $other_link; ?> ">
            <img src=" <?php echo "$img[0]"; ?> " class="img-thumbnail image" alt="product">
          </a>
          <div class="middle">
              <button type="button" class="btn btn-outline-dark" onclick="location.href=' <?php echo $other_link; ?> '">Xem chi tiết</button>
          </div>
        </div>

        <div class="card-body">
          <p class="card-text">
            <?php echo "$row[tensanpham_vietthuong]"; ?>
          </p>
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-secondary" onclick="buynow(this)" id="<?php echo "$row[product_code]"; ?>_now">Mua ngay</button>
              <button type="button" class="btn btn-sm btn-outline-secondary cart_add" id="<?php echo "$row[product_code]"; ?>">Thêm vào giỏ hàng</button>
            </div>
            <small class="text-muted"><?php echo "$row[price]"; ?></small>
          </div>
        </div>
      </div>
    </div>

  </div>
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
		<button class="btn btn-danger"  type="button" id="back" value="back">X</button>
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
        <br><br>
		</div>
		<?php
		if (isset($_SESSION['privilege']) && ($_SESSION['privilege']=="admin")) {
		echo <<<EOL
		<div id="admin-comment">
      <textarea class="form-control" id='admin_reply' placeholder="Nhập phản hồi..."></textarea>
      <div class="d-grid gap-2">
			<button class="btn btn-danger" type="button" onclick="reply_request()" class="" value="sub">Đăng phản hồi</button>
      </div>
			<p id="idholder" style="display:none"></p>

		</div>
EOL;
		}
		?>
</div>
</div>
<!-----pop up----->
    
</body>
</html>
