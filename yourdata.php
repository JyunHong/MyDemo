<?php
  session_start();
  if(!isset($_SESSION["u_ID"])){
    header("Location: home.php");
  }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <title>會員中心</title>
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
		.managerlogin{
			display:<?php
			 if(!isset($_SESSION["u_ID"])):
			 	echo "none";
			 elseif(($_SESSION["u_google"]==8) || ($_SESSION["u_google"]==9)):
			 	echo "inline";
			 else :
			 	echo "none";
			 endif;?>;
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
	          <a class="nav-link" href="bingo_game.php">BingoGame</a>
	        </li>
		    <li class="nav-item pl">
	          <a class="nav-link" href="message_board.php">留言板</a>
	        </li>
	        <li class="nav-item pl">
			  <a class="nav-link" href="api/logout-api.php"><img class="shopbag" src="images/icon/wbag-50.png" alt="" width="20" height="20"></a>
			</li>
	        <li class="nav-item notlogin pl">
	          <a class="nav-link btn btn-outline-primary" href="login.php">登入</a>
	        </li>
	        <li class="nav-item notlogin pl">
	          <a class="nav-link btn btn-outline-primary" href="register.php">註冊</a>
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
			  <a class="nav-link btn btn-outline-primary" href="api/logout-api.php">登出</a>
			</li>
		  </ul>
		</div>
	  </nav>	
	</div>
	<div class="container-fluid all">
		<div class="row">
			<div class="col-sm-6 myuser box1">
				<div class="title text-center">
					<h1>會員資料</h1>
				</div></br>
				<div class="col-sm-6 offset-lg-3 " id="userall">
				</div>
				<div class="col-sm-6 offset-lg-3 " id="botton">
				</div>
			</div>
			
			<!-- <div class="col-lg-6 offset-lg-3 box1" id="botton">		
			</div> -->
		</div>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.3.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
		var getUrlParameter = function getUrlParameter(sParam) {
			    var sPageURL = window.location.search.substring(1),
			        sURLVariables = sPageURL.split('&'),
			        sParameterName,
			        i;

			    for (i = 0; i < sURLVariables.length; i++) {
			        sParameterName = sURLVariables[i].split('=');

			        if (sParameterName[0] === sParam) {
			            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			        }
			    }
			};

		$(function(){
			// postID = getUrlParameter('u_ID');
			var postID = <?php echo $_SESSION["u_ID"]?>;
			$.ajax({
				type: "POST",
				url: "../api/user_re_1_all_api.php",
				data: {u_ID: postID},
				dataType: "json",
				success: show,
				error: function(){
					alert("error read one");
				}
			});
		});

		function show(data){
			// console.log(data);
			strHTML = '';
			strHTML='<div class="row">';
			strHTML+='<div class="col-sm-6"><p>會員帳號:</p></div>';
			strHTML+='<div class="col-sm-6"><p>'+data[0].u_username+'</p></div>';
			strHTML+='<div class="col-sm-6"><p>會員暱稱:</p></div>';
			strHTML+='<div class="col-sm-6"><p>'+data[0].u_name+'</p></div>';
			strHTML+='<div class="col-sm-6"><p>信箱:</p></div>';
			strHTML+='<div class="col-sm-6"><p>'+data[0].u_email+'</p></div>';
			strHTML+='<div class="col-sm-6"><p>電話:</p></div>';
			strHTML+='<div class="col-sm-6"><p>'+data[0].u_phone+'</p></div>';
			
			$("#userall").append(strHTML); //不會覆蓋寫入資料
			buttonHTML='';
			buttonHTML='<button class="btn btn-primary" id="user_btn" data-id="'+data[0].u_ID+'" onclick=update_user("'+data[0].u_ID+'")>修改會員資料</button>&nbsp;<button class="btn btn-secondary" id="password_btn" data-id="'+data[0].u_ID+'" onclick=update_password("'+data[0].u_ID+'")>修改會員密碼</button>';
			$("#botton").append(buttonHTML);
		}

		function update_user(id){
			// console.log(id);
			// location.href = "user_up_userdata.php?u_ID="+id;
			location.href = "userdata_up.php";
		}

		function update_password(id){
			// location.href = "user_up_password.php?u_ID="+id;
			location.href = "user_up_password.php";
			// console.log(id);
		}
	</script>
</body>
</html>