<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>BingoGame</title>
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
		.pa{
			padding:0px;
		}
		.pl{
			padding-right: 5px;
		}
		.pt{
			padding-top: 10px;
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

		.box{
			height:100vh;
		}
		.circle{
			border:  2px solid #111;
			height: 80px;
			width: 20px;
			border-radius: 50%;
		}
		td{
			width: 25px;
			height: 25px;
		}
		.bigbtn{
			width: 100px;
		}
		.tablebox{
			width: 240px;
			height: 240px;
		}
		.margin{
			margin: auto;
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
	<div class="bd-example">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 text-center"><h1>BingoGame</h1></div>
			</div>			
		</div>

		<div class="pt container-fluid" id="allbingonumber"></div>
		<div class="pt container-fluid text-center">
			<div class="row">
				<div class="col-7 text-right" id="nowtext"><h1></h1></div>
				<div class="col-4 text-left" id="nowopennumber"><h1></h1></div>
			</div>
		</div>
		<div class="pt container-fluid text-center">
			<div class="row">
				<div class="col-9 text-right" id="readtext"><h2></h2></div>
				<div class="col-2 text-left" id="readtime"><h2></h2></div>
			</div>
		</div>
		<div class="pt container-fluid ">
			<div class="row">
				<div class="col-12 text-center" id="readloadtime"><h2></h2></div>
			</div>
		</div>
		<div class="pt container-fluid" id="allbingoplate">
		</div>
	</div>	
	<script src="../js/bootstrap.min.js"></script>
	<script>
		var br = 0; //遊戲場次變數
		var winnernumber=""; //勝利者號碼
		var n =0;



		bingoplatehtml();//賓果盤html
		bingonumberhtml(); //號碼盤html	
		readnumber(); //讀取號碼盤
		checkround();//確認遊戲場次
		var wait = setInterval(( () => waiting() ), 1000);
	    var allbingoplate = setInterval(( () => checkallbingoplate() ), 300); //讀取賓果盤內容
		var readloadtime = setInterval(( () => checkloadtime() ), 100); //讀取load時間
		

		//讀取載入時間 start
		function checkloadtime(){
			$.ajax({
			    type:"POST",
			    url:"../api/read_alltime_api.php",
			    dataType:"json",
			    success:function(data){
			    	// console.log(data[0].selectplate_Time);
			    	if(data[0].selectplate_Time<=0){
			    		$("#readtime h2").html("");
			    		$("#readtext h2").html("");
			    		clearInterval(wait);
			    	}
			    	if(data[0].load_Time>0 && data[0].load_Time<30){
			    		$("#readloadtime h2").html("倒數 "+data[0].load_Time+" 秒遊戲開始");
			    		$("#readloadtime h2").css("color","#ED5A4E");
				   	}else{			   		
				   		$("#readloadtime h2").html("");
				   	}
				   	if(data[0].break_Time>=0){
				   		clearInterval(readloadtime);
				   		clearInterval(allbingoplate);
				   		checkwinner(br);
				   	}
				    	// console.log(data);
				},
				error:function(){
					alert("read_alltime_api.php");
				}
			});
		}			
		

		//讀取本場遊戲勝利者 start
		function checkwinner(br){
			$.ajax({
			    type:"POST",
			    url:"../api/read_winner_api.php",
			    data:{br_ID:br},
			    dataType:"json",
			    success:function(data){
			    	// console.log(data);
			    	if(data!=0){
			    		winnernumber="";
			    		for(var i=0;i<data.length ;i++){    			
				    		winnernumber+=""+data[i].bp_number+" ";
			    		}
			    		alert(winnernumber+"號賓果盤賓果");
			    		location.href = "bingo_game_online.php";
			    	}else{
			    	}
			    },
			    error:function(){
			        alert("read_winner_api.php");
			    }
			});
		}
		

		//讀取遊戲場次
		function checkround(){
			$.ajax({
				type:"POST",
				url:"../api/read_bingoround_api.php",
				dataType:"json",
				async :false,
				success:function(data){
					br=data[1];
				},
				error:function(){
				    alert("read_bingoround_api.php");
				}
			});
		}				
				
		function waiting (){
			str="";
			switch(n){
				case 0 :
					str="";
					break;
				case 1 :
					str="!";
					break;
				case 2 :
					str="! !";
					break;
				case 3 :
					str="! ! !";
					break;
			}			
			$("#readtext h2").html("等待其他玩家選取賓果盤");
			$("#readtime h2").html(str);
			$("#readtime h2").css("color","#ED5A4E");
			$("#readtext h2").css("color","#ED5A4E");
			n++;
			if(n==4){
				n=0;
			}
		}

		//讀取開號的號碼 start
		function readnumber(){
			var allnumber = setInterval(( () => checkallnumber() ), 500);
			function checkallnumber(){
				$.ajax({
					type:"POST",
					url:"../api/read_bingonum_api.php",
					dataType:"json",
					success:shownumber,
					error:function(){
					    alert("read_bingoplatenum_api.php");
					}
				});

				function shownumber(data){
					
					for(var i =0 ;i<data.length ;i++){
						$("#bn"+data[i].b_number).html(data[i].b_number);
						if(data[i].opennumber==1){
							$("#bn"+data[i].b_number).css("color","white");
							$(".chkbingo"+data[i].b_number).css("background-color","red");					
						}
						if(data[i].nowopen==1){
							$("#nowtext h1").html("當前號碼 :");
							$("#nowopennumber h1").html(" "+data[i].b_number);
							$("#nowopennumber h1").css("color","red");
						}
					}
				}				
			}
		}	

		//讀取全部賓果盤 start
		function checkallbingoplate(){
			$.ajax({
			        type:"POST",
			        url:"../api/read_bingoplatenum_api.php",
			        dataType:"json",
			        success:showplate,
			        error:function(){
			            alert("read_bingoplatenum_api.php");
			        }
			});

			function showplate(data){
				//console.log(data);
				for(var i=0;i<data.length;i++){
					platecontent= [];
					platecontent=JSON.parse(data[i].bp_content); //取出bp_content的值

					chklinearray= [];
					chklinearray=JSON.parse(data[i].bp_chklinearray); //取出bp_chklinearray的值

					for(var j=1;j<=36;j++){
						var n ;
						n=platecontent[j-1];
						$("#plate"+data[i].bp_number+"number"+j).html(platecontent[j-1]);
					}
					//如果陣列內數值為0 背景顏色改成紅色
					for(var j=1;j<=36;j++){
						var n ;
						n=chklinearray[j-1];
						if(n==0){
						$("#plate"+data[i].bp_number+"number"+j).css("background-color","red");
						}
					}

				 	if(data[i].u_ID==<?php if(isset($_SESSION["u_ID"])){echo $_SESSION["u_ID"];
	                             				   }else{echo "-1";}?>){

						$("#plate"+data[i].bp_number).css({"border":"2px solid #212529",
																	"border-radius": "5%",
																	"background-color":"#FFA733"
									 					  });
						$("#plate"+data[i].bp_number+" h3").html("我的賓果盤");
					}
				}
			}		
		}		
		

		//製作全部賓果號碼html start
		function bingonumberhtml(){
			var n=1; //變數重置 n用來計數
			htmlbingonumber='';//變數重置
			for(var i=1;i<=6;i++){
			htmlbingonumber+='<div class="row">';
			htmlbingonumber+='<div class="col-1"></div>';
				for(var j=0;j<10;j++){
					htmlbingonumber+='<div class="col-1 text-center" id="bn'+n+'" style="font-family:fantasy;font-size:25px;"></div>';
					n++;		
				}
			htmlbingonumber+='<div class="col-1"></div>';
			htmlbingonumber+='</div>';	
			}
			$("#allbingonumber").html(htmlbingonumber);
		}

		// 製作賓果盤的html start
		function bingoplatehtml(){
			var n=1;
			var x=1 ;
			Bingoplatehtml='';
			for(var i=0;i<2;i++){
				
				Bingoplatehtml+='<div class="row">';
				Bingoplatehtml+='<div class="col-1"></div>';
				for(j=1;j<=5;j++){
					Bingoplatehtml+='<div class="col-2 text-center" id="plate'+n+'">';
					Bingoplatehtml+='<div class="pt"><h3>'+n+'號賓果盤</h3></div>';
					Bingoplatehtml+='<div id="bingoplate'+n+'">';
					Bingoplatehtml+='</div>';
					Bingoplatehtml+='<div class="pt"></div>';
					Bingoplatehtml+='</div>';
					n++;
				}
				Bingoplatehtml+='</div>';
			}
			$("#allbingoplate").html(Bingoplatehtml);
			
			for(i=1;i<=10;i++){
				var n=1;
				Bingoplate='';
				Bingoplate+='<table border=1 align="center">';
				for(var j=0;j<6;j++){
					Bingoplate+='<tr>';
					for(k=0;k<6;k++){
						Bingoplate+='<td id="plate'+x+'number'+n+'"></td>';
						n++;	
					}
					Bingoplate+='</tr>';				
				}
				Bingoplate+='</table>';
				$("#bingoplate"+x).html(Bingoplate);
				x++;
			}			
		}

	</script>
</body>
</html>