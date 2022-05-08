<!doctype html>
<html lang="vi">
<?php
   ob_start();
   session_start();
   include 'login/userdb.php'; //$userdb is user database, conn is connection
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
    <title>Shop bán quần áo LAPINE - Trang chủ</title>
	  <!------------------my code---------------->
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <!------------------my code---------------->
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

<div class="container">
  <div class="row py-lg-5 py-3 mb-4">
    <div class="col-lg-6 col-md-8 mx-auto">
        <img src="images/home/logo.jpg" class="img-fluid logo_size" alt="logo">
        <p class="lead text-muted text-center">
            “Đừng chạy theo xu hướng. Đừng khiến bản thân lệ thuộc vào thời trang. Hãy để chính mình là người quyết định bản thân sẽ mặc gì cũng như sẽ sống ra sao.”            <p>
        </p>
        <p class="lead text-muted text-center">
            Gianni Versace
        </p>
    </div>
</div>
</div>


<div class="container  border-bottom">
  <h2 class="pb-2">Sản phẩm mới</h2>
</div>

<div class="container py-3 mb-4">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    <div class="col">
      <div class="card shadow-sm">    
        <div class="container_image" style="height: 700px;">
          <a href="/product/product.php?id=K03">
            <img src="/product/aokhoac/images/K03_1.JPG" class="img-thumbnail image" alt="product">
          </a>
          <div class="middle">
            <button type="button" class="btn btn-outline-dark" onclick="location.href='/product/product.php?id=K03'">Xem chi tiết</button>
          </div>
        </div>

        <div class="card-body">
          <p class="card-text">
            Áo khoác dài phối vải dáng áo Bomber
          </p>
          <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">3.499.000 VND</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card shadow-sm">
        
        <div class="container_image"  style="height: 700px;">
          <a href="/product/product.php?id=AP04">
            <img src="/product/aophong/images/AP04_1.png" class="img-thumbnail image" alt="product">
          </a>
          <div class="middle">
            <button type="button" class="btn btn-outline-dark" onclick="location.href='/product/product.php?id=AP04'">Xem chi tiết</button>
          </div>
        </div>

        <div class="card-body">
          <p class="card-text">
            Áo phông họa tiết Hello Kitty ©Sanrio 
          </p>          
          <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">729.000 VND</small>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card shadow-sm">
        
        <div class="container_image"  style="height: 700px;">
          <a href="/product/product.php?id=ASM03">
            <img src="product/aosomi/images/ASM03_1.png" class="img-thumbnail image" alt="product">
          </a>
          <div class="middle">
            <button type="button" class="btn btn-outline-dark" onclick="location.href='/product/product.php?id=ASM03'">Xem chi tiết</button>
          </div>
        </div>

        <div class="card-body">
          <p class="card-text">
            Áo sơ mi vải giả sa tanh cổ có dây buộc 
          </p>
          <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">999.000 VND</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div style="background-color: #e4e4e4;">
    <div class="row">
        <div class="col-sm-6" style="margin-top: auto; margin-bottom: auto;">
          <div class="container" style="margin-left: auto; margin-right: auto; width: 75%;">
            <h1>LAPINE</h1>
            <p style="text-align: justify;">
              Với phương châm “Young and Beautiful”, LAPINE mong muốn mang lại cho khách hàng những sản phẩm tốt nhất để các bạn không chỉ thể hiện cá tính bản thân mà còn lan toả nguồn năng lượng tích cực, mạnh mẽ đến xung quanh.            </p>
          </div>      
        </div>
        
        <div class="col-sm-6">
            <img src="https://static.wixstatic.com/media/6965f4e2b7694112ae98bf41a6dae7a2.jpeg/v1/fill/w_950,h_800,fp_0.50_0.50,q_85,usm_0.66_1.00_0.01/6965f4e2b7694112ae98bf41a6dae7a2.webp"
            class="img-fluid center" alt="end">
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


    
</body>
</html>
