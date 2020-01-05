<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>會員登入系統</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
</head>
<body>
	<div class="text-center">
		<div>
			<h1>會員登入系統</h1>
		</div>
		<br><br><br><br>
		<form action="../api/user_re_1_na_pa_chk_login_api.php" method="POST">
			<label for="u_username"><b>信箱：</b></label>
	        <input type="text" placeholder="請輸入 帳號" name="u_username" id="u_username" required="TRUE">
	        <div id="err_username"></div>
	        <label for="u_password"><b>密碼：</b></label>
	        <input type="password" placeholder="請輸入 密碼" name="u_password" id="u_password" required="TRUE">
	        <div id="err_password"></div><br>
	        <!-- <button type="button" class="btn sign-btn" id="ok_btn">登入</button> -->
	        <input class="btn btn-primary " type="submit" value="登入"/>
	        <a class="btn btn-primary"  href="/register.php">註冊</a>
    	</form>
	</div>

</body>
</html>