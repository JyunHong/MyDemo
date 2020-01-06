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
    <link rel="stylesheet" href="../css/1/user_up_password_pc.css?ts=5559">
    <title>旅遊</title>
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

		.box{
			width: 140px;
		}

		.b1 {
  			border-style: none;
  			background: #FFFFFF;
		}
		
		.managerlogin{
			display:<?php
			 if(!isset($_SESSION["u_ID"])):
			 	echo "none";
			 elseif(($_SESSION["u_level"]==8) || ($_SESSION["u_level"]==9) || ($_SESSION["u_level"]=='8') || ($_SESSION["u_level"]=='9')):
			 elseif(($_SESSION["u_level"]==8) || ($_SESSION["u_level"]==9) || ($_SESSION["u_level"]=='8') || ($_SESSION["u_level"]=='9')):
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
					更改會員密碼
				</div>

				<p>您必須填寫原密碼才能修改下面的資料</p>

				<p>修改密碼後,需重新登入</p>

				<div class="row">
					<div class="col-lg-8 offset-lg-2" id="up_password">
						<label for="u_username" class="box"><b>會員帳號 :</b></label>
				        <input type="text" class="b1" disabled="" name="u_username" id="u_username" required><br>

						<label for="u_password" class="box"><b>原始密碼 :</b></label>
				        <input type="password" placeholder="請輸入 原始密碼" name="u_password" id="u_password" required>
				        <div id="err_password"></div>

						<label for="new_password" class="box"><b>新密碼 :</b></label>
				        <input type="password" placeholder="請輸入 新密碼" name="new_password" id="new_password" required>
				        <div id="err_new_password"></div>

				        <label for="chkpass" class="box"><b>確認新密碼 :</b></label>
				        <input type="password" placeholder="請再次輸入新密碼" name="chkpass" id="chkpass" required>
				        <div id="err_chkpass"></div>
					</div>
				</div>				
			</div>	
		</div>

		<div class="row">
			<div class="col-lg-6 offset-sm-3 box1">
				<div class="row">
					<div class="col-lg-6 offset-lg-3">
						<button class="btn btn-primary" id="chk_btn" onclick="update_password()">確認</button>
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
		var flag_ok = new Array(0,0,0);//原始密碼/新密碼/確認密碼
		var flag_text =new Array("原始密碼", "新密碼","確認密碼");
		$("#u_password").bind("input propertychange",function(){
			if ($("#u_password").val().length<0) {
				$("#err_password").html("原始密碼不可空白");
				$("#err_password").css("color","red");
				flag_ok[0]=0;
		    }else{
		     	$("#err_password").html("");
		     	flag_ok[0]=1;
		    }
		});

    	//即時監聽check new_password
    	$("#new_password").bind("input propertychange",function(){
	        if ($("#new_password").val().length<6 || $("#new_password").val().length>10) {
	            $("#err_new_password").html("密碼必須介於 6~10 字以內");
	            $("#err_new_password").css("color","red");
	            flag_ok[1]=0;
	        }else{
	            $("#err_new_password").html("");
	            flag_ok[1]=1;
	            if (flag_ok[2] && ($(this).val() != $("#chkpass").val())) {
	                $("#err_chkpass").html("與新密碼不一致");
	                $("#err_chkpass").css("color","red");
	                flag_ok[2]=0;
	            }
	        }
        });

	    $("#chkpass").bind("input propertychange",function(){
	        if ($(this).val() != $("#new_password").val()) {
		        $("#err_chkpass").html("與新密碼不一致");
		        $("#err_chkpass").css("color","red");
		        flag_ok[2]=0;
		    }else{
		        if (!flag_ok[1]) {
		        $("#err_chkpass").html("密碼不正確");
		        $("#err_chkpass").css("color","red");
		        flag_ok[2]=0;
		    }else{
		        $("#err_chkpass").html("");
		        $("#err_chkpass").css("color","green");
		        flag_ok[2]=1;           
		        }
	        }
	    });
		$(function(){
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
			console.log(data);
			$("#u_username").val(data[0].u_username);
			// $("#chk_btn").attr("data-id", data[0].u_ID);
		}

		function update_password(){
			if (flag_ok[0] && flag_ok[1] && flag_ok[2]) {
				if(confirm("確認修改密碼??")){  //confirm跳出對話框 確認.取消
					var postID = <?php echo $_SESSION["u_ID"]?>;
					$.ajax({
					type: "POST",
					url: "../api/user_up_1_pa_api.php",
					// data: {u_ID: $("#chk_btn").data("id"), u_password: $("#chkpass").val()},
					data: {u_ID: postID, u_password: $("#u_password").val(), new_password: $("#new_password").val()},
					success: showupdate,
					error: function(){
						alert("user_up_1_pa_api.ph error");
					}
					});	
				}
	        } else {
	          strHTML="";
	          for (var i = 0 ;i < flag_ok.length; i++) {
	            if (!flag_ok[i]) {strHTML += flag_text[i] +" ,";
	          }
	        }
	        alert(strHTML+"欄位不正確，請檢查!!");
	      }
		}

		function showupdate(data){
			if (data==1) {
				alert("修改成功,需重新登入");
				location.href = "../api/logout-api.php";
				location.href = "login.php";
			}else{
				alert(data);
			}
		}

		function cancel(){
	      $("#u_password").val("");
	      $("#new_password").val("");
	      $("#chkpass").val("");
	      $("#err_password").html("");
	      $("#err_new_password").html("");
	      $("#err_chkpass").html("");
	      location.href = "homepage.php";
		}
	</script>
</body>
</html>

