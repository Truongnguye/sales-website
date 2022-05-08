<!doctype html>
<?php
   ob_start();
   session_start();
   include 'login/userdb.php'; //$userdb is user database, conn is connection
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
  
    <title>Giới thiệu</title>

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






<div class="container border-bottom">
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

<main class="text-center py-lg-5 mb-lg-5">

<div class="container"> 
      <!-- START THE FEATURETTES -->
      <div class="row">
        <div class="col-lg-4">
          <img src="images/gioithieu/chatluong.png" class="img-fluid avatar" alt="chatluong">

          <h2>Chất lượng tốt</h2>
        </div><!-- /.col-lg-4 -->

        <div class="col-lg-4">
          <img src="images/gioithieu/store.png" class="img-fluid avatar" alt="store">

            <h2>10+ cửa hàng trên toàn quốc</h2>
        </div><!-- /.col-lg-4 -->

        <div class="col-lg-4">
            <img src="images/gioithieu/years.jpg" class="img-fluid avatar" alt="years">
    
            <h2>10 năm tiên phong</h2>
        </div><!-- /.col-lg-4 -->
      </div>
  
      <hr class="featurette-divider">
  
      <div class="row featurette">
        <div class="col-md-7" style="margin-top: auto; margin-bottom: auto;">
          <h2 class="featurette-heading">Bạn biết gì về chúng tôi?</h2>
          <p class="lead text-justify">
            Với khơi nguồn từ lòng đam mê thời trang, khát khao mang đến cái đẹp cho tất cả phụ nữ và hơn thế nữa là mong muốn được góp phần tạo dựng hình ảnh mới lạ cho ngành công nghiệp thời trang Việt Nam, LAPINE đã tập trung đầu tư vào chất lượng và kiểu dáng sản phẩm để thương hiệu LAPINE trở thành một cái tên gần gũi hơn với khách hàng.
        </p>
        </div>
        <div class="col-md-5">
            <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Giới thiệu chung</title>
                <rect width="100%" height="100%" fill="#eee">
                </rect>
                
                <text x="50%" y="50%" fill="black" dy=".3em" style="font: italic 40px serif;">
                    Giới thiệu
                </text>

            </svg>
  
        </div>
      </div>
  
      <hr class="featurette-divider">
  
      <div class="row featurette">
        <div class="col-md-7 order-md-2" style="margin-top: auto; margin-bottom: auto;">
            <h2 class="featurette-heading">Thế mạnh của chúng tôi?</h2>
            <p class="lead text-justify">
                Chúng tôi có nhà máy sản xuất được đặt tại Huyện Bình Chánh, Thành phố Hồ Chí Minh, Việt Nam. 
                Những sản phẩm giày dép của chúng tôi được chính bàn tay, khối óc của người công nhân Việt có tay nghề cao, tâm huyết, tỉ mỉ trong từng công đoạn sản xuất từ thiết kế mẫu, chọn lựa nguyên vật liệu, kỹ thuật tạo form dáng và sản xuất theo đúng trình tự tiêu chuẩn vô cùng chặt chẽ, chuyên nghiệp để tạo ra những sản phẩm giày dép “Made in Viet Nam” chất lượng, mang đến vẻ đẹp mềm mại, uyển chuyển, chứa đựng linh hồn của người làm ra nó mà ít sản phẩm nào có được.
            </p>
        </div>
        <div class="col-md-5 order-md-1"> 
            <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Thế mạnh</title>
                <rect width="100%" height="100%" fill="#eee">
                </rect>
                
                <text x="10%" y="50%" fill="black" dy=".3em" style="font: italic 40px serif;">
                    Thế mạnh
                </text>

            </svg>
        </div>
      </div>
  
      <hr class="featurette-divider">
  
      <div class="row featurette">
        <div class="col-md-7" style="margin-top: auto; margin-bottom: auto;">
            <h2 class="featurette-heading">Cam kết của chúng tôi?</h2>
            <p class="lead text-justify">
                LAPINE sẽ không ngừng đổi mới và phát triển, trở thành người bạn đồng hành thân thiết góp phần vào sự thành đạt, hạnh phúc và thịnh vượng của mọi phụ nữ Việt Nam.            </p>
        </div>

        <div class="col-md-5">
            <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Cam kết</title>
                <rect width="100%" height="100%" fill="#eee">
                </rect>
                
                <text x="50%" y="50%" fill="black" dy=".3em" style="font: italic 40px serif;">
                    Cam kết
                </text>

            </svg>  
        </div>
      </div>
  
      <hr class="featurette-divider">
  
      <!-- /END THE FEATURETTES -->
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
