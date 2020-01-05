<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>會員註冊系統</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
    	var flag_ok = new Array(0,0,0,0,0);
  		var flag_text =new Array("帳號","密碼","確認密碼", "電話","匿稱");
  		var u_session = "";
  		var u_google = 0;
    	$(function(){
    		$("#chk_btn").bind("click",chkdata);
    		$("#u_username").bind("input propertychange",function(){			
				if ($("#u_username").val().indexOf("@",0) <1){
					$("#err_username").html("格式沒有@信箱格式不正確");
					$("#err_username").css("color","red");
					flag_ok[0]=0;
			    }else{
				   //即時監聽check uni username
		            $.ajax({
		            type: "POST",
		            url: "api/sign-check-uni-api.php",
		            data: {u_username: $("#u_username").val()},
		            success: check_uni,
		            error: function(){
		              alert("error check_uni");
		            }
		            });
			    }
			});
    		//即時監聽check u_password
		    $("#u_password").bind("input propertychange",function(){
		      	if ($("#u_password").val().length<6 || $("#u_password").val().length>10) {
		            $("#err_password").html("密碼必須介於 6~10 字以內");
		            $("#err_password").css("color","red");
		            flag_ok[1]=0;
		        }else{
		            $("#err_password").html("");
		            flag_ok[1]=1;
		            if(flag_ok[2] && ($(this).val() != $("#chkpass").val())) {
		            	$("#err_chkpass").html("與密碼不一致");
		                $("#err_chkpass").css("color","red");
		                flag_ok[2]=0;
		            }
		            else{
		            	$("#err_chkpass").html("");	
		            	flag_ok[2]=1;	            
		            }
		        }
		    });

		    $("#chkpass").bind("input propertychange",function(){
		        if ($(this).val() != $("#u_password").val()) {
			        $("#err_chkpass").html("與密碼不一致");
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
    		$("#u_phone").bind("input propertychange",function(){
				if ($("#u_phone").val().length<8 || $("#u_phone").val().length>12) {
					$("#err_phone").html("電話必須介於 8~12 字以內");
				    $("#err_phone").css("color","red");
				    // flag_phone=false;
				    flag_ok[3]=0;
		    	}else{
		     		$("#err_phone").html("");
		     		// flag_phone=true;
		     		flag_ok[3]=1;
		    	}
		   	});

		   	$("#u_name").bind("input propertychange",function(){
				if ($("#u_name").val().length<1) {
					$("#err_name").html("匿稱不可空白");
					$("#err_name").css("color","red");
					// flag_name=false;
					flag_ok[4]=0;
			    }else{
				    $("#err_name").html("");
				    // flag_name=true;
				    flag_ok[4]=1;
			    }
			});
    	});//end fun.
    	function check_uni(uni_data){
	    	if(uni_data){
		    	//帳號重複
		    	$("#err_username").html("此帳號已有人使用!!");
		    	$("#err_username").css("color","red");
		    	$("#err_email").css("color","red");
		    	flag_ok[0]=0;
	    	}else{
		    	//帳號無重複
		    	$("#err_username").html("");
		   		$("#err_email").html("");
		    	flag_ok[0]=1;
	    	}
	    }
	    //檢查資料是否正確
	    function chkdata(){
	      	if(flag_ok[0] && flag_ok[1] && flag_ok[2] && flag_ok[3] && flag_ok[4]){
		        if(confirm("確認註冊?")){
		        	send_to_api();
		        }  	
    		}else{
	        	strHTML="";
	        	for (var i = 0 ;i < flag_ok.length; i++) {
	            	if (!flag_ok[i]) {strHTML += flag_text[i] +" ,";}
	        	}
	        alert(strHTML+"欄位不正確，請檢查!!");
	        }
    	}
    	function send_to_api(){
    		$.ajax({
		        type: "POST",
		        url: "../api/user_cr_1_api.php",
		        data: {u_username: $("#u_username").val(), u_password: $("#u_password").val(), u_phone: $("#u_phone").val(), u_email: $("#u_username").val(), u_name: $("#u_name").val(), u_session: "", u_google: 0},
		        data: {u_username: $("#u_username").val(), u_password: $("#u_password").val(), u_phone: $("#u_phone").val(), u_email: $("#u_username").val(), u_name: $("#u_name").val(), u_session: "", u_level: 0},
		        success: show,
		        error: function(){
		          alert("系統錯誤!!");
		        }
    		});
    	}
    	function show(data){
	    // console.log(data);
		    if (data==1) {
		        alert("註冊成功");
		        location.href = "homepage.php";
		        location.href = "home_page.php";
		    }else if (data==2) {
		        alert("此帳號已有人使用!!");
		    }else{
		        alert(data);
		    }
	    }
    </script>
    <style>
    	sup{
    		color: red;
    	}
    	label{
    		width: 100px;
    	}
    </style>
</head>
<body>
	<div class="text-center">
		<div>
			<h1>會員註冊系統</h1>
		</div>
		<br><br><br><br>
		<div>
			<label for="u_username"><b>信箱：</b></label>
	        <input type="text" placeholder="請輸入 帳號" name="u_username" id="u_username" required="TRUE">
	        <sup>*</sup><span></span>
	        <div id="err_username"></div>
	        <label for="u_password"><b>密碼：</b></label>
	        <input type="password" placeholder="請輸入 密碼" name="u_password" id="u_password" required="TRUE">
	        <sup>*</sup>
	        <div id="err_password"></div>
	        <label for="chkpass"><b>確認密碼:</b></label>
            <input type="password" placeholder="請再次輸入密碼" name="chkpass" id="chkpass" required="TRUE">
            <sup>*</sup>
            <div id="err_chkpass"></div>
	        <label for="u_name"><b>暱稱：</b></label>
	        <input type="text" placeholder="請輸入 暱稱" name="u_name" id="u_name" required="TRUE">
	        <sup>*</sup></br>
	        <div id="err_name"></div>
	        <label for="u_phone"><b>電話：</b></label>
	        <input type="text" placeholder="請輸入 電話" name="u_phone" id="u_phone" required="TRUE">
	        <sup>*</sup></br>
	        <div id="err_phone"></div><br>
	        <button type="button" class="btn btn-primary" id="chk_btn">註冊</button>
	        <!-- <input class="btn btn-primary" id="chk_btn" type="submit" value="註冊"/> -->
    	</div>
	</div>

</body>
</html>