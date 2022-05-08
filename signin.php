<!doctype html>
<!----my code--->
<?php
   ob_start();
   session_start();
   include 'login/userdb.php'; //$userdb is user database, conn is connection
?>
<!----my code--->


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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!----ajax---->
    <title>Đăng nhập</title>
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
      <form method="POST">
        <h1 class="h3 mb-3 fw-normal">Đăng nhập</h1>
		   
        <div class="form-floating">
          <input type="text" class="form-control" name="username" id="username" placeholder="name@example.com" value = "<?php if (isset($_POST['username'])) {echo "$_POST[username]";} ?>"> <!--- keep the name if the user enter wrong password---->
          <label for="username">Tài khoản</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
          <label for="password">Mật khẩu</label>
        </div>
        <span id="failed" class="error">Tài khoản hoặc mật khẩu không đúng.</span>
    
        <div class="checkbox mb-3">
        </div>

        <?php	if (isset($_POST['regSuccess'])) {
          echo "<span class=\"error\">Đăng ký thành công! <br> Vui lòng đăng nhập.</span><br><br>";
        }
        ?> <!--- span thong bao dang nhap thanh cong, di chuyen o dau tuy og--->

        <button class="w-100 btn btn-lg btn-dark" type="submit" name="login">Đăng nhập</button>
        
      </form>
    </div>

    <div class="col-sm-4">
    </div>
</div>
</main>

<!-------------------code cua t ----------------->
<script>
function signupredirect() {
window.location = "signup.php";
}
</script>
<?php
if (isset($_POST['login']))     //process the information the user gave.
{
	$uname=$_POST['username'];
	$pword=$_POST['password'];
	$foundusername= mysqli_query($conn,"SELECT * FROM userdb WHERE `uname` = \"$uname\"");
		
	if( mysqli_num_rows($foundusername) != 0) {
		
        $row=mysqli_fetch_assoc($foundusername); // username exist
		echo "<script>$(\"#failed\").hide();</script>";
		
		if ($row['pword']==$pword)	{
			echo "<script>$(\"#failed\").hide();</script>";
			 //TODO: redirect
			 $_SESSION["id"] = $row['id'];
			 $_SESSION["username"] = $row['uname'];
			 $_SESSION["privilege"] = $row['privilege'];
	    } else {
			echo "<script>$(\"#failed\").show();</script>"; // show warning if password is incorrect
	    }
		
    } else {
		echo "<script>$(\"#failed\").show();</script>";  // show username if password is incorrect
    }
}
else {
	echo "<script>$(\"#failed\").hide();</script>";
}

if (isset($_SESSION["username"])	) {
	if ($_SESSION["privilege"]== "admin")
	{
		echo "<script>window.location = \"admin.php\"</script>"; //redirect if login sucessful
	} else {
		if ($_SESSION["privilege"]!= "banned") {
		echo "<script>window.location = \"home.php\"</script>"; 
		} else {
			echo "<script>alert(\"Tài khoản của bạn đã bị khoá.\")</script>";
			echo "<script>window.location = \"login/logout.php\"</script>"; //redirect if login sucessful
		}
	}
}

$userdb = mysqli_query($conn,$query);

?>
<?php
mysqli_free_result($userdb);
mysqli_close($conn);
?>
<!-------------------code cua t ----------------->


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
