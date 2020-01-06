<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>首頁</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
	<style>
		.notlogin{
			display:<?php
			 if(isset($_SESSION["u_ID"])):
			 	echo "none";
			 else :
			 	echo "inline";
			 endif;?>;
		}
		.yeslogin{
			display:<?php
			 if(!isset($_SESSION["u_ID"])):
			 	echo "none";
			 else :
			 	echo "inline";
			 endif;?>;
		}
		.pl{
			padding-right: 5px;
		}
		.myset{
			height:250px;	
		}

		.bg_cover{
			background-position: center center;
			-webkit-background-size: cover;
			background-size: cover;
		}
		.bd-example{
			padding-top: 10px;
			padding-right: 5px;
			padding-left: 5px;
			border-radius: 2%;

		}

	</style>

</head>
<body>
	<div class="bd-example">
	  <nav class="navbar navbar-expand-lg navbar-light bg-light" >
		<a class="navbar-brand" href="home_page.php">JHProject</a>
		<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		  <ul class="navbar-nav ml-auto">
		    <li class="nav-item pl">
	          <a class="nav-link" href="/message_board.php">留言版</a>
	        </li>
	        <li class="nav-item pl">
			  <a class="nav-link" href="/api/logout-api.php"><img class="shopbag" src="/images/icon/wbag-50.png" alt="" width="20" height="20"></a>
			</li>
	        <li class="nav-item notlogin pl">
	          <a class="nav-link btn btn-outline-primary" href="/login.php">登入</a>
	        </li>
	        <li class="nav-item notlogin pl">
	          <a class="nav-link btn btn-outline-primary" href="/register.php">註冊</a>
	        </li>
	      </ul>
	      <ul class="navbar-nav nav-pills yeslogin">
			<li class="nav-item active dropdown yeslogin">
		      <a class="nav-link dropdown-toggle yeslogin" data-toggle="dropdown"><?php if(isset($_SESSION["u_name"])){echo $_SESSION["u_name"];}?> 您好</a>
		      <div class="dropdown-menu">
		        <a class="dropdown-item yeslogin <?php if($_SESSION["u_level"]==1){ echo "d-none";} ?>" href="yourdata.php">顯示個人資料</a>
		        <a class="dropdown-item yeslogin <?php if($_SESSION["u_level"]==1){ echo "d-none";} ?>" href="userdata_up.php">修改個人資料</a>
		        <a class="dropdown-item yeslogin <?php if($_SESSION["u_level"]==1){ echo "d-none";} ?>" href="user_up_password.php">變更密碼</a>
		        <a class="dropdown-item managerlogin <?php if((!$_SESSION["u_level"]==8)  || (!$_SESSION["u_level"]==9)){ echo "d-none";} ?>" href="backup.php">控制台分析圖表</a>
		        <a class="dropdown-item managerlogin <?php if((!$_SESSION["u_level"]==8)  || (!$_SESSION["u_level"]==9)){ echo "d-none";} ?>" href="userdata_list_table.php">會員列表</a>
		      </div>
		    </li>
		  </ul>
		  <ul class="navbar-nav">
			<li class="nav-item yeslogin">
			  <a class="nav-link btn btn-outline-primary" href="/api/logout-api.php">登出</a>
			</li>
		  </ul>
		</div>
	  </nav>	
	</div>
	<div class="bd-example">
		<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
		    <ol class="carousel-indicators">
			    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
			    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
			    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
		    </ol>

		    <div class="carousel-inner">
			    <div class="carousel-item active myset bg_cover" style="background-image: url(images/03.jpg);">      
			        <div class="carousel-caption d-none d-md-block">
			        </div>
			    </div>

			    <div class="carousel-item myset bg_cover" style="background-image: url(images/02.jpg);">
			        <div class="carousel-caption d-none d-md-block">
			        </div>
			    </div>

				<div class="carousel-item myset bg_cover" style="background-image: url(images/01.jpg);">
			        <div class="carousel-caption d-none d-md-block">
			        </div>
			    </div>	
		    </div>

		    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
		    </a>
		    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
		    </a>
		</div>
	</div>

	<div class="bd-example">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <a class="navbar-brand" href="#">商品清單</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <!-- <li class="nav-item active">
		        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Link</a>
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Dropdown
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="#">Action</a>
		          <a class="dropdown-item" href="#">Another action</a>
		          <div class="dropdown-divider"></div>
		          <a class="dropdown-item" href="#">Something else here</a>
		        </div>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
		      </li> -->
		    </ul>
		    <form class="form-inline my-2 my-lg-0">
		      <input class="form-control mr-sm-2" type="search" placeholder="尋找你要的商品" aria-label="Search">
		      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">搜尋</button>
		    </form>
		  </div>
		</nav>
	</div>
	<div>
		<div class="container">
			<div class="row">
				<div class="col-1"></div>
				<div class="col-10 text-center"><h1>準備製作小型商城</h1></div>
			</div>
			<div class="row mt-3" id="hotel_data">
				<div class="col-sm-4 mb-3">
					<div class="card border-dark" >
					<div id="hotel_img">
						<img src="/images/01.jpg" alt="" class="card-img-top img" width="100%" height="250">
					</div>
					<div class="card-body border-dark">
					<div class="card-title">商品名稱</div>
					<div class="card-title price">價錢</div>
					<div class="card-subtitle c_phone"><a href="" class="btn btn-info btn-block c_btn ">詳細介紹</a></div>
					</div>
					</div>
				</div>
			</div>
	</div>	
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>