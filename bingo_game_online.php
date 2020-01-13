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
		.h{
			height: 150vh;
		}
		.margin{
			margin: auto;
		}
		#loadtime h1{
			font-size: 300px;
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
		<div class="container-fluid text-center" id="loadtime">
		<h1></h1>
		<h2></h2>	
		</div>		
		<div class="container-fluid" id="titlehtml">			
		</div>

		<div class="pt container-fluid" id="allbingoplate">
		</div>
	</div>
	<script src="../js/bootstrap.min.js"></script>
	<script>

		var yourchoose ;
		var chooseid ;
		var chkyourchooseplate=0;
		var n=0;

		var wait = setInterval(( () => waiting() ), 1000);
		breaktime();

		function waiting (){
			str="";
			switch(n){
				case 0 :
					str="";
					break;
				case 1 :
					str=".";
					break;
				case 2 :
					str=". .";
					break;
				case 3 :
					str=". . .";
					break;
			}			
			$("#loadtime h2").html("遊戲進行中 請梢等"+str);
			n++;
			if(n==4){
				n=0;
			}
		}

		//讀取休息時間 ready
		function breaktime(){
			var readbreaktime = setInterval(( () => checkbreaktime() ), 100);
			function checkbreaktime(){
				$.ajax({
				    type:"POST",
				    url:"../api/read_alltime_api.php",
				    dataType:"json",
				    success:function(data){
				    	if(data[0].game_Time==1){

				    	}else if(data[0].break_Time<=0){
				    		clearInterval(readbreaktime);

					    	$("#loadtime").css("display","none");
					    	$("#selecttime h2").html("");
					    	bingotitlehtml()
					    	bingoplatehtml();
					    	readbingoplate();
							selectplatetime();
							readreplate();

					    }else{
					    	clearInterval(wait);
					    	$("#loadtime h2").html("");
					    	$("#loadtime h2").html("準備開始: "+data[0].break_Time+" 秒");
					    }
					},
					error:function(){
					   alert("read_alltime_api.php");
					}
				});
			}	
		}

		//讀取賓果盤
		function readbingoplate(){
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
				for(i=0;i<data.length;i++){
					var content= [];
					content=JSON.parse(data[i].bp_content);
					$("#select"+data[i].bp_number).attr("onclick","choosemyplate("+data[i].bp_ID+","+data[i].bp_number+")");

					for(var j=1;j<=36;j++){
						$("#plate"+data[i].bp_number+"number"+j).html(content[j-1]);
					}
				}
			}
		}

		//讀取選取時間 ready
		function selectplatetime(){
			var readselectplatetime = setInterval(( () => checkselectplatetime() ), 100);
			function checkselectplatetime(){
				$.ajax({
				    type:"POST",
				    url:"../api/read_alltime_api.php",
				    dataType:"json",
				    success:function(data){

				    	$("#selecttime h2").html("剩餘時間: "+data[0].selectplate_Time+" 秒");
				    	$("#selecttime").css("color","#ED5A4E");

					    if(data[0].selectplate_Time==0){
					    	clearInterval(readselectplatetime);
					    	location.href = "bingo_game_online_start.php"
					    }
					    
					},
					error:function(){
					    alert("read_alltime_api.php");
					}
				});
			}	
		}

		//讀取已經被選取的賓果盤
		function readreplate(){
			var readselectplate = setInterval(( () => checkselectplate() ), 100);
			function checkselectplate(){
				$.ajax({
				    type:"POST",
				    url:"../api/read_bingoplatenum_api.php",
				    dataType:"json",
				    success:function(data){
				    	for(i=0;i<data.length;i++){
				    		if(data[i].choose==1){
								$("#plate"+data[i].bp_number).css({ "border":"",
												    "border-radius": "5%",
												    "background-color":"rgba(202,12,22,0.5)"
												 });
								$("#plate"+data[i].bp_number).attr( "id","none" );						
								$("#select"+data[i].bp_number).html("被選了");
								$("#select"+data[i].bp_number).attr({ "id":"alreadycho",
																	  "class": "btn btn-light",
																    });				
							}
				    	}
				    },
				    error:function(){
				        alert("read_bingoplatenum_api.php");
				    }
				});				
			}
		}

		//改變選擇賓果盤的CSS ready
		function choosemyplate(id,n){
				chkyourchooseplate=1;
				clearmyplatecss();
				yourchoose=n;
				chooseid=id;
				$("#plate"+n).css({"border":"2px solid #212529",
									"border-radius": "5%",
									"background-color":"#FFA733"
								 });		
		}

		//UPDATE你選取賓果盤的參數 ready
		function chkchoosemyplate(){
			if(chkyourchooseplate){
				if(confirm("確認選取"+yourchoose+"號賓果盤??")){
					$.ajax({
				        type:"POST",
				        url:"../api/update_choose_bingoplate_api.php",
				        data:{bp_ID:chooseid,u_ID:<?php 
	                            if(isset($_SESSION["u_ID"])){
	                                echo $_SESSION["u_ID"];
	                            }else{
	                                echo "0";
	                            }
	                        ?>},
				        dataType:"json",
				        success:function(data){
									if(data==1){
										location.href = "bingo_game_online_start.php";
									}else{
										alert("你選的賓果盤已被選取,請重新選擇!");
										window.location.reload();
									}
									
								},
				        error:function(){
				            alert("update_choose_bingoplate_api.php");
				        }
					});
				}
			}else{
				alert("請先選取你的賓果盤!!");	
			}		
		}


		//清除原先賓果盤的狀態 ready
		function clearmyplatecss(){
			for(var i=1;i<=10;i++){
			$("#plate"+i).css({"border":"",
								"border-radius": "",
								"background-color":""
							 });
			}	
		}

		//標題html ready
		function bingotitlehtml(){
			Bingotitlehtml='';
			Bingotitlehtml+='<div class="row">';
			Bingotitlehtml+='<div class="col-4 text-right margin" id="selecttime"><h2></h2></div>';
			Bingotitlehtml+='<div class="col-4 text-center"><h1>BingoGame</h1></div>';
			Bingotitlehtml+='<div class="col-4 text-center margin">';
			Bingotitlehtml+='<a href="#" class="btn btn-primary bigbtn" onclick="chkchoosemyplate()">確認選取</a>';
			Bingotitlehtml+='</div>';
			Bingotitlehtml+='</div>';

			$("#titlehtml").html(Bingotitlehtml);
		}

		//賓果盤的html ready
		function bingoplatehtml(){
			// $("#titlehtml").css("display","inline");
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
					Bingoplatehtml+='<div class="pt"><a href="#" class="btn btn-info" id="select'+n+'" onclick="">選擇</a></div>';
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
						Bingoplate+='<td id="plate'+x+'number'+n+'" class=""></td>';
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

