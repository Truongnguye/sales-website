<!doctype html>
<?php
   ob_start();
   session_start();
   include 'login/userdb.php'; //$userdb is user database, conn is connection
   if(isset($_SESSION["username"]) &&isset($_SESSION["privilege"]) && $_SESSION["privilege"]=="admin") {
	   
		$user_info = mysqli_query($conn,"SELECT * FROM userdb WHERE `uname` = \"$_SESSION[username]\"");
		
	    if( mysqli_num_rows($user_info) != 0) {
			
			$user_info=mysqli_fetch_assoc($user_info); // user info row in database
			
		} else {
			die("Cannot find user, something gone wrong!");
		}
   } // get user info if user has logged in
   else {
	   header('Location: signin.php'); //user is not logged in
   }
?>

<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
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
  
    <title>Quản trị viên</title>
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
		<!----cho dang nhap/ dang ki, hien thi thong tin khi dang nhap thanh cong---->
		
		
		<!-- code t them, xu ly nut nhan-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
	
	$("document").ready(function (){
		print_info()
	}); //make the user-block display info when init
	
	$("document").ready(function (){
		$("#changepassword-button").click( function (){
			change_password();
		});
	}); //make the user-block display change password interface when click
	
	$("document").ready(function (){
		$("#info-button").click( function (){
			print_info();
		});
	}); //make the user-block display info interface when click
	
	$("document").ready(function (){
		$("#charge").click( function (){
			charge();
		});
	}); //make the user-block display info interface when click
	
	$("document").ready(function (){
		$("#user-list").click( function (){
			user_list();
		});
	}); //make the user-block display info interface when click
	
	$("document").ready(function (){
		$("#order-list").click( function (){
			order_list();
		});
	}); //make the user-block display info interface when click
	
	function print_info(){
		

		$.ajax({
			type:"GET",
			url:"info/print_info.php",
			success: function (result){
				$('#user-block').html(result);
			}	
		});
	}
	
	function change_password(){
		$.ajax({
			type:"GET",
			url:"info/changepassword.php",
			success: function (result){
				$('#user-block').html(result);
			}	
		});
	}
	
	function user_list(){
		if ($("#uid").val()) {
			dat={uid:$("#uid").val()};
		} else {
			dat= {};
		}
		$.ajax({
			type:"POST",
			data:dat,
			url:"admin/user_list.php",
			success: function (result){
				$('#user-block').html(result);
			}	
		});
	}
	
	function order_list(){
		$.ajax({
			type:"GET",
			url:"admin/orderManagement.php",
			success: function (result){
				$('#user-block').html(result);
			}	
		});
	}

	</script>
<!-- code t them -->
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


<div class="container py-3">
  <div class="row">
    <div class="col-sm-1">
    </div>

    <div class="col-sm-10 border-right border-left">
      <div class="container  border-bottom py-3" style="margin-left: auto; margin-right:auto;">
        <div class="row">
          <div class="col-sm center">
            <button id="info-button" type="button" class="btn btn-secondary"  style="width: 100%;">
              Thông tin
            </button>
          </div>

          <div class="col-sm center">
            <button id="changepassword-button" type="button" class="btn btn-secondary"  style="width: 100%;">
              Đổi mật khẩu
            </button>
          </div>
        

          <div class="col-sm center">
            <button id="user-list" type="button" class="btn btn-secondary"  style="width: 100%;">
              Danh sách tài khoản
            </button>
          </div>

          <div class="col-sm center">
            <button id="order-list" type="button" class="btn btn-secondary"  style="width: 100%;">
              Danh sách đơn hàng
            </button>
          </div>
        </div>
      </div>
      <div id="user-block"></div>

    </div>

    <div class="col-sm-1">
    </div>
  </div>



</div>


<!-----info------->

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
<div id="order-box" style="padding: 2%;">
	<button type="button" id="back" onclick="back()" value="back" class="btn btn-danger">X</button>
	<p id="order-user-id"></p>
		<table id="order-cart" class="table-bordered table">
		<tr id="firstRow-order">
			<th>Hình ảnh</th>
			<th>Tên sản phẩm</th>
			<th>Giá</th>
			<th>Số lượng</th>
		</tr>
		</table>
	<p id="address"></p>
	<p id="thanhtien" style="color: red;"></p>
	<button type="button" id="cancel-submit" onclick="cancel()" value="none" class="btn btn-danger">Huỷ đơn hàng</button>
	<button type="button" id="verify-submit" onclick="verify()" value="none" class="btn btn-light">Xác nhận đơn hàng</button>
	<button type="button" id="already-done" value="none" class="btn btn-secondary">Đơn hàng đã được xử lý</button>
</div>
</div>
<!-----pop up----->
</body>


</html>
