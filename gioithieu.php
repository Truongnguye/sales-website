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
  
    <title>Gi???i thi???u</title>

</head>

<body>  
    
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="home.php" class="d-flex align-items-center col-md-4 mb-2 mb-md-0 text-dark text-decoration-none">
          <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
          <span class="fs-4">LAPINE STORE</span>
        </a>
  
        <ul class="nav col-12 col-md-4 mb-2 justify-content-center mb-md-0">
          <li><a href="/home.php" class="nav-link px-2 link-secondary">Trang ch???</a></li>
          <li><a href="/gioithieu.php" class="nav-link px-2 link-dark">Gi???i thi???u</a></li>
          <li><a href="/lienhe.php" class="nav-link px-2 link-dark">Li??n h???</a></li>
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
                  echo "$user_info[ubalance] VN??";
                  ?>
              </button>
              <button type="button" class="btn btn-dark" onclick="location.href='/login/logout.php'">????ng xu???t</button>
          <?php } 
            else { 
          ?>
              <button type="button" class="btn btn-dark" onclick="location.href='/signin.php'">????ng nh???p</button>
              <button type="button" class="btn btn-outline-dark" onclick="location.href='/signup.php'">????ng k??</button>
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
              Danh m???c s???n ph???m
            </button>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
              <div class="offcanvas-header">
                <h5 id="offcanvasTopLabel">Danh m???c s???n ph???m</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <div class="list-group">
                  <button type="button" class="list-group-item list-group-item-action list-group-item-dark" aria-current="true">
                    <strong>
                      T???t c??? s???n ph???m
                    </strong>
                  </button>
                  
                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=ak'">
                    ??o kho??c
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=ap'">
                    ??o ph??ng
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=asm'">
                    ??o s?? mi
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=blz'">
                    Blazer
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=cl'">
                    Com l??
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=d'">
                    ?????m
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=gi'">
                    Gi??y
                  </button>

                  <button type="button" class="list-group-item list-group-item-action"  
                  onclick="location.href='/product/catalog.php?cata=q'">
                    Qu???n
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
        <button type="button" class="btn btn-outline-light"  onclick="location.href='/donhang.php'">????n h??ng</button>
        </div>
    </header>
</div> 
</div>






<div class="container border-bottom">
    <div class="row py-lg-5 py-3 mb-4">
        <div class="col-lg-6 col-md-8 mx-auto">
            <img src="images/home/logo.jpg" class="img-fluid logo_size" alt="logo">
            <p class="lead text-muted text-center">
                ????????ng ch???y theo xu h?????ng. ?????ng khi???n b???n th??n l??? thu???c v??o th???i trang. H??y ????? ch??nh m??nh l?? ng?????i quy???t ?????nh b???n th??n s??? m???c g?? c??ng nh?? s??? s???ng ra sao.???            <p>
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

          <h2>Ch???t l?????ng t???t</h2>
        </div><!-- /.col-lg-4 -->

        <div class="col-lg-4">
          <img src="images/gioithieu/store.png" class="img-fluid avatar" alt="store">

            <h2>10+ c???a h??ng tr??n to??n qu???c</h2>
        </div><!-- /.col-lg-4 -->

        <div class="col-lg-4">
            <img src="images/gioithieu/years.jpg" class="img-fluid avatar" alt="years">
    
            <h2>10 n??m ti??n phong</h2>
        </div><!-- /.col-lg-4 -->
      </div>
  
      <hr class="featurette-divider">
  
      <div class="row featurette">
        <div class="col-md-7" style="margin-top: auto; margin-bottom: auto;">
          <h2 class="featurette-heading">B???n bi???t g?? v??? ch??ng t??i?</h2>
          <p class="lead text-justify">
            V???i kh??i ngu???n t??? l??ng ??am m?? th???i trang, kh??t khao mang ?????n c??i ?????p cho t???t c??? ph??? n??? v?? h??n th??? n???a l?? mong mu???n ???????c g??p ph???n t???o d???ng h??nh ???nh m???i l??? cho ng??nh c??ng nghi???p th???i trang Vi???t Nam, LAPINE ???? t???p trung ?????u t?? v??o ch???t l?????ng v?? ki???u d??ng s???n ph???m ????? th????ng hi???u LAPINE tr??? th??nh m???t c??i t??n g???n g??i h??n v???i kh??ch h??ng.
        </p>
        </div>
        <div class="col-md-5">
            <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Gi???i thi???u chung</title>
                <rect width="100%" height="100%" fill="#eee">
                </rect>
                
                <text x="50%" y="50%" fill="black" dy=".3em" style="font: italic 40px serif;">
                    Gi???i thi???u
                </text>

            </svg>
  
        </div>
      </div>
  
      <hr class="featurette-divider">
  
      <div class="row featurette">
        <div class="col-md-7 order-md-2" style="margin-top: auto; margin-bottom: auto;">
            <h2 class="featurette-heading">Th??? m???nh c???a ch??ng t??i?</h2>
            <p class="lead text-justify">
                Ch??ng t??i c?? nh?? m??y s???n xu???t ???????c ?????t t???i Huy???n B??nh Ch??nh, Th??nh ph??? H??? Ch?? Minh, Vi???t Nam. 
                Nh???ng s???n ph???m gi??y d??p c???a ch??ng t??i ???????c ch??nh b??n tay, kh???i ??c c???a ng?????i c??ng nh??n Vi???t c?? tay ngh??? cao, t??m huy???t, t??? m??? trong t???ng c??ng ??o???n s???n xu???t t??? thi???t k??? m???u, ch???n l???a nguy??n v???t li???u, k??? thu???t t???o form d??ng v?? s???n xu???t theo ????ng tr??nh t??? ti??u chu???n v?? c??ng ch???t ch???, chuy??n nghi???p ????? t???o ra nh???ng s???n ph???m gi??y d??p ???Made in Viet Nam??? ch???t l?????ng, mang ?????n v??? ?????p m???m m???i, uy???n chuy???n, ch???a ?????ng linh h???n c???a ng?????i l??m ra n?? m?? ??t s???n ph???m n??o c?? ???????c.
            </p>
        </div>
        <div class="col-md-5 order-md-1"> 
            <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Th??? m???nh</title>
                <rect width="100%" height="100%" fill="#eee">
                </rect>
                
                <text x="10%" y="50%" fill="black" dy=".3em" style="font: italic 40px serif;">
                    Th??? m???nh
                </text>

            </svg>
        </div>
      </div>
  
      <hr class="featurette-divider">
  
      <div class="row featurette">
        <div class="col-md-7" style="margin-top: auto; margin-bottom: auto;">
            <h2 class="featurette-heading">Cam k???t c???a ch??ng t??i?</h2>
            <p class="lead text-justify">
                LAPINE s??? kh??ng ng???ng ?????i m???i v?? ph??t tri???n, tr??? th??nh ng?????i b???n ?????ng h??nh th??n thi???t g??p ph???n v??o s??? th??nh ?????t, h???nh ph??c v?? th???nh v?????ng c???a m???i ph??? n??? Vi???t Nam.            </p>
        </div>

        <div class="col-md-5">
            <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Cam k???t</title>
                <rect width="100%" height="100%" fill="#eee">
                </rect>
                
                <text x="50%" y="50%" fill="black" dy=".3em" style="font: italic 40px serif;">
                    Cam k???t
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
        <li class="nav-item"><a href="/home.php" class="nav-link px-2 text-muted">Trang ch???</a></li>
        <li class="nav-item"><a href="/gioithieu.php" class="nav-link px-2 text-muted">Gi???i thi???u</a></li>
        <li class="nav-item"><a href="/lienhe.php" class="nav-link px-2 text-muted">Li??n h???</a></li>
    </ul>
    <p class="text-center text-muted">?? 2021 Company, Inc</p>
</footer>


    
</body>
</html>
