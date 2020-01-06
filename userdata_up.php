<?php
  session_start();
  if(!isset($_SESSION["u_ID"])){
    header("Location: home_page.php");
  }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/1/user_up_userdata_pc.css">
    <title>JH</title>
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
	
	<div class="container-fluid all">
		<div class="row">
			<div class="col-lg-6 offset-lg-3 myuser box1" id="">
				<div class="title">
					更改會員資料
				</div>		
				<p>您必須填寫原密碼才能修改下面的資料</p>

				<div class="row">
					<div class="col-lg-8 offset-lg-2">
						<label for="u_username" class="box"><b>會員帳號 :</b></label>
				        <input type="text" class="b1" disabled="" name="u_username" id="u_username" required><br>

						<label for="u_password" class="box"><b>密碼 :</b></label>
				        <input type="password" placeholder="請輸入 密碼" name="u_password" id="u_password" required>
				        <div id="err_password"></div>
						<label for="u_name" class="box"><b>會員暱稱 :</b></label>
				        <input type="text" name="u_name" id="u_name" required>
				      	<div id="err_name"></div>

				        <label for="u_phone" class="box"><b>會員電話 :</b></label>
				        <input type="text" name="u_phone" id="u_phone" required>
				      	<div id="err_phone"></div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6 offset-lg-3 mb-3 box1">
				<div class="row">
					<div class="col-lg-6 offset-lg-3">
						<button class="btn btn-primary" id="chk_btn" onclick="update_userdata()">確認</button>
						<button class="btn btn-secondary" id="cancel" onclick="cancel()">離開</button>
					</div>
				</div>
			</div>
		</div>
	</div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
		var flag_ok = new Array(0,1,1);//密碼/匿稱/電話
  		var flag_text =new Array("密碼", "匿稱", "電話", "Email");
		$("#u_password").bind("input propertychange",function(){
				if ($("#u_password").val().length<0) {
					$("#err_password").html("密碼不可空白");
				    $("#err_password").css("color","red");
				    flag_ok[0]=0;
		    	}else{
		     		$("#err_phone").html("");
		     		flag_ok[0]=1;
		    	}
		   	});

		$("#u_phone").bind("input propertychange",function(){
				if ($("#u_phone").val().length<8 || $("#u_phone").val().length>12) {
					$("#err_phone").html("電話必須介於 8~12 字以內");
				    $("#err_phone").css("color","red");
				    flag_ok[1]=0;
		    	}else{
		     		$("#err_phone").html("");
		     		flag_ok[1]=1;
		    	}
		   	});

		$("#u_name").bind("input propertychange",function(){
				if ($("#u_name").val().length<1) {
					$("#err_name").html("匿稱不可空白");
					$("#err_name").css("color","red");
					flag_ok[2]=0;
			    }else{
				    $("#err_name").html("");
				    flag_ok[2]=1;
			    }
			});

		$(function(){
			// postID = getUrlParameter('u_ID');
			var postID = <?php echo $_SESSION["u_ID"];?>;
			console.log(postID);
			$.ajax({
				type: "POST",
				url: "../api/user_re_1_all_api.php",
				data: {u_ID: postID},
				dataType: "json",
				success: show,
				error: function(){
					alert("user_re_1_all_api.php error");
				}
			});
		});

		function show(data){
			// console.log(data);
			$("#u_username").val(data[0].u_username);
			$("#u_name").val(data[0].u_name);
			$("#u_phone").val(data[0].u_phone);
			$("#chk_btn").attr("data-id", data[0].u_ID);
		}

		function update_userdata(){
			if (flag_ok[0] && flag_ok[1] && flag_ok[2]){
				//confirm跳出對話框 確認.取消
				if(confirm("確認修改會員資料??")){
				var postID = <?php echo $_SESSION["u_ID"];?>;
					$.ajax({
					type: "POST",
					url: "../api/user_up_1_all_api.php",
					data: {u_ID: postID, u_password: $("#u_password").val(), u_name: $("#u_name").val(), u_phone: $("#u_phone").val()},
					success: showupdate,
					error: function(){
						alert("user_up_1_all_api.php error");
					}
					});
				}
			} else {
					var strHTML="";
	          		for (var i = 0 ;i < flag_ok.length; i++) {
	            		if (!flag_ok[i]) {
	            			strHTML += flag_text[i] +" ,";
		          		}
		        	}
		        	alert(strHTML+"欄位不正確，請檢查!!");
				}
		}

		function showupdate(data){
			if (data == 1) {
				location.href = "home_page.php";
			}else{
				alert(data);
			}
		}

		function cancel(){
	      $("#u_password").val("");
	      $("#err_password").html("");
	      location.href = "home_page.php";
		}
	</script>
</body>
</html>