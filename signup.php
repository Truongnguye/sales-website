<!doctype html>

<?php
if (isset($_SESSION['id'])) {
	header("Location: info.php");
}
?>

<html lang="vi">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="css/home.css">
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
  
    <title>Đăng ký</title>
	<!-- code t them -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
	$("document").ready(function (){
		$("#valid_password,#password,#username").change( function (){
			data = {
				uname : $("#username").val(),
				pword : $("#password").val(),
				repword : $("#valid_password").val(),
				
			};
			$.ajax({
				type:"POST",
				url:"login/ajaxcheckreg.php",
				data: data,
				success: function (result){
							eval(result);
						}	
			});
		});
	}); // use ajax to control warning text.

	$("document").ready(function (){
		$("#submits").click( function (){
			data = {
				uname : $("#username").val(),
				pword : $("#password").val(),
				repword : $("#valid_password").val(),
				submit : "mkay",
				
			}; 
			$.ajax({
				type:"POST",
				url:"login/ajaxcheckreg.php",
				data: data,
				success: function (result){
							eval(result);
						}	
			});
		});
	}); //execute when then user submit the register information

	</script>
	<!-- code t them -->
</head>
</head>

<body>  
    
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="home.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
          <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
          <span class="fs-4">LAPINE STORE</span>
        </a>
  
        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
          <li><a href="/home.php" class="nav-link px-2 link-secondary">Trang chủ</a></li>
          <li><a href="/gioithieu.php" class="nav-link px-2 link-dark">Giới thiệu</a></li>
          <li><a href="/lienhe.php" class="nav-link px-2 link-dark">Liên hệ</a></li>
        </ul>
  
        <div class="col-md-3 text-end">
          <button type="button" class="btn btn-dark" onclick="location.href='/signin.php'">Đăng nhập</button>
          <button type="button" class="btn btn-outline-dark" onclick="location.href='/signup.php'">Đăng ký</button>
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





<main class="text-center container py-lg-5 mb-lg-5">
<div class="row"> 
    <div class="col-sm-4">
    </div>

    <div class="col-sm-4">
      <form id="regForm">
        <h1 class="h3 mb-3 fw-normal">Đăng ký</h1>
    
        <div class="form-floating">
          <input type="email" class="form-control" name="username" id="username"  placeholder="name@example.com">
          <label for="username">Tài khoản <span id="nameWarn" class="error">*</span></label> <!-- name warning box (hien tai la warn neu <4 chars), di chuyen di dau tuy y og-->
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
          <label for="password">Mật khẩu <span id="pwordWarn" class="error">*</span></label>  <!-- password warning box, di chuyen cai span nay o dau tuy y og-->
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="valid_password" placeholder="Password">
            <label for="valid_password">Xác nhận mật khẩu</label>
          </div>
    
        <div class="checkbox mb-3">
        </div>

        <button class="w-100 btn btn-lg btn-dark" type="button" id="submits">Đăng ký</button>
        
      </form>
    </div>

    <div class="col-sm-4">
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

<script>
	function signinredirect() {
	window.location = "signin.php";
	}
</script>
    
</body>
</html>
