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
				<div class="col-12 text-center"><h1>BingoGameServer</h1></div>
			</div>			
		</div>

		<div class="pt container-fluid" id="allbingonumber">
		</div>
		<div class="pt container-fluid">
			<div class="row">
			  	<div class="col-12 text-center">
			  		<!-- <a href="#" onclick="startgame()" class="btn btn-primary" id="start_btn">開始遊戲</a> -->
			  	</div>
			</div>
		</div>
		<div class="pt container-fluid" id="allbingoplate">
		</div>
	</div>	
	<script src="../js/bootstrap.min.js"></script>
	<script>

		var bingonumber = [];
		var bingoplatedom = new Array();
		var chkbingoline = new Array();
		var alreadyconnect ;
		var gameover = 0;
		var bingoround = 1;

		//reset資料庫 重新開始run
		allreset();
		
		//開始遊戲 server
		function startgame(){

			bingonumber = [];
			bingoplatedom = new Array();
			alreadyconnect =0 ;
			bingoround = 1;

			bingoplatehtml();
			bingonumberhtml();

			readallbingoplate();
			getshufflenumber();
			readbingoround();
			// console.log(bingoround);
			//開始開球
			startnumbershift = setInterval(( () => numbershift() ), 1000);
		}

		//開始開號 server
		function numbershift(){
			var opennumber = 0; //開出的號碼歸零
			// console.log("遊戲狀態"+gameover);
				//判斷bingonumber是否小於1 或是 是否啟動結束遊戲
			if(gameover==1){
				//結束開號
				clearInterval(startnumbershift);
				allreset();
			}else{
				//shift()把陣列第一個號取出
				opennumber=bingonumber.shift();
				console.log("開出號碼 :"+opennumber);
				readnumber();
				alnumbershift(opennumber);
				updatebnumber(opennumber);

				//用迴圈啟動connectline的方法 判斷是哪一個賓果盤賓果
				for(var i=0;i<chkbingoline.length;i++){
					var n=0;
					alreadyconnect=0;
					connectline(chkbingoline[i]);
						
					if(alreadyconnect>=5){
						var n;
						gameover=1; //結束開號 遊戲結束
						n=i+1; //將獲勝的賓果盤號碼放入 n變數
						console.log("勝利者"+n); 
						insertwinner(n,bingoround);//更新勝利的資料
					}
				}
			}			
		}

		//讀取開球號碼
		function readnumber(){
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
				// console.log(data);
				for(var i =0 ;i<data.length ;i++){
					$("#bn"+data[i].b_number).html(data[i].b_number);
					if(data[i].opennumber==1){
						$("#bn"+data[i].b_number).css("color","white");
						$(".chkbingo"+data[i].b_number).css("background-color","red")					
					}
				}
			}	
		}
		//讀取遊戲場次
		function readbingoround(){
			$.ajax({
				type:"POST",
				url:"../api/read_bingoround_api.php",
				dataType:"json",
				async :false,
				success:shownumber,
				error:function(){
				    alert("read_bingoround_api.php");
				}
			});

			function shownumber(data){
				bingoround=data[1];
			}	
		}

		//製作賓果號碼html
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

		//讀取全部賓果盤
		function readallbingoplate(){
			$.ajax({
			        type:"POST",
			        url:"../api/read_bingoplatenum_api.php",
			        dataType:"json",
			        success:showplate,
			        async :false,
			        error:function(){
			            alert("read_bingoplatenum_api.php");
			        }
			});

			function showplate(data){
				for(i=0;i<data.length;i++){
					datacontent= [];
					datacontent=JSON.parse(data[i].bp_content);
					// uid[i]=data[i].u_ID;
					for(var j=1;j<=36;j++){
						var n ;
						n=datacontent[j-1];
						$("#plate"+data[i].bp_number+"number"+j).attr("class","chkbingo"+n);
						$("#plate"+data[i].bp_number+"number"+j).html(datacontent[j-1]);
					}
					chkbingoline[i]=datacontent;
				}		
			}
		}

		// 賓果盤的html
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

		//重新洗牌 server
		function getshufflenumber(){
			
			for(var n=1;n<=60;n++){
				
				bingonumber.push(n);
			}
			//重新洗牌
			bingonumber=shuffle(bingonumber);
		}

		//更新開出號碼的狀態 	server
		function updatebnumber(number){
			$.ajax({
				type:"POST",
				url:"../api/update_open_bingonumber_api.php",
				dataType:"json",
				success:shownumber,
				data:{b_number:number},
				error:function(){
				    alert("update_open_bingonumber_api.php");
				}
			});

			function shownumber(data){
				if(data==0){
					alert("系統錯誤");
				}
			}
		}

		//將開出的賓果號碼改變狀態 server
		function alnumbershift(number){
			
			for(var i=0;i<chkbingoline.length;i++){
				var n = 0 ;
				//設定一個可以接收每個賓果盤的陣列
				var arraybingo=[];

				arraybingo=chkbingoline[i];
				//indexOf(number)可以知道number在陣列的位置
				if(arraybingo.indexOf(number)>=0){
					//arraycheck接收 陣列位置的變數
					arraycheck=arraybingo.indexOf(number);
					//把開出的號碼變成0 去判斷是否連線
					arraybingo[arraycheck]=0;
					//在傳回原本的陣列中
					chkbingoline[i]=arraybingo;
					n=i+1;
					upchkarray(n,chkbingoline[i]);
				}
			}				
		}

		//更新陣列參數來判斷是否連線 server
		function upchkarray(n,array){
			$.ajax({
			    type:"POST",
			    url:"../api/upchkarray_bingoplate_api.php",
			    data:{bp_number:n,bp_chklinearray:JSON.stringify(array)},
			    dataType:"json",
			    async :false,
			    success:show,
			    error:function(){
			    	alert("upchkarray_bingoplate_api.php");
			    	gameover = 1;
			   	}
			});
			function show(data){
				// console.log(data);
			}				
		}
		
		//新增勝利者資料 server
		function insertwinner(n,bingoround){
			$.ajax({
			    type:"POST",
			    url:"../api/insert_bingowinner_api.php",
			    data:{bp_number:n,br_ID:bingoround},
			    dataType:"json",
			    success:winner,
			    error:function(){
			    	alert("insert_bingowinner_api.php");
			   	}
			});
			function winner(data){
				if(data==0){
					alert("勝利者系統錯誤")
				}
			}
		}
	
		//檢查賓果盤是否連線 server
		function connectline(chkbingo){
			var line=0;
			//橫線
			if(chkbingo[0]==0 && chkbingo[1]==0 && chkbingo[2]==0 && chkbingo[3]==0 && chkbingo[4]==0 && chkbingo[5]==0){
				line+=1;
			}
			if(chkbingo[6]==0 && chkbingo[7]==0 && chkbingo[8]==0 && chkbingo[9]==0 && chkbingo[10]==0 && chkbingo[11]==0){
				line+=1;
			}
			if(chkbingo[12]==0 && chkbingo[13]==0 && chkbingo[14]==0 && chkbingo[15]==0 && chkbingo[16]==0 && chkbingo[17]==0){
				line+=1;
			}
			if(chkbingo[18] ==0 &&chkbingo[19] ==0 && chkbingo[20]==0 && chkbingo[21]==0 && chkbingo[22]==0 && chkbingo[23]==0){
				line+=1;
			}
			if(chkbingo[24]==0 && chkbingo[25]==0 && chkbingo[26]==0 && chkbingo[27]==0 && chkbingo[28]==0 && chkbingo[29]==0){ 
				line+=1;
			}
			if(chkbingo[30]==0 && chkbingo[31]==0 && chkbingo[32]==0 && chkbingo[33]==0 && chkbingo[34]==0 && chkbingo[35]==0){
				line+=1;
			}
			//斜線
			if(chkbingo[0]==0 && chkbingo[7]==0 && chkbingo[14]==0 && chkbingo[21]==0&& chkbingo[28]==0 &&  chkbingo[35]==0){
				line+=1;
			}
			if(chkbingo[5]==0 && chkbingo[10]==0 && chkbingo[15]==0 && chkbingo[20]==0&& chkbingo[25]==0 && chkbingo[30]==0){
				line+=1;
			}
			//直線
			if(chkbingo[0]==0 && chkbingo[6]==0 && chkbingo[12]==0 && chkbingo[18]==0 && chkbingo[24]==0 &&  chkbingo[30]==0){
				line+=1;
			}
			if(chkbingo[1]==0 && chkbingo[7]==0 && chkbingo[13]==0 && chkbingo[19]==0 && chkbingo[25]==0 &&  chkbingo[31]==0){
				line+=1;
			}
			if(chkbingo[2]==0 && chkbingo[8]==0 && chkbingo[14]==0 && chkbingo[20]==0 && chkbingo[26]==0 &&  chkbingo[32]==0){
				line+=1;
			}
			if(chkbingo[3]==0 && chkbingo[9]==0 && chkbingo[15]==0 && chkbingo[21]==0 && chkbingo[27]==0 &&  chkbingo[33]==0){
				line+=1;
			}
			if(chkbingo[4]==0 && chkbingo[10]==0 && chkbingo[16]==0 && chkbingo[22]==0 && chkbingo[28]==0 && chkbingo[34]==0){
				line+=1;
			}
			if(chkbingo[5]==0 && chkbingo[11]==0 && chkbingo[17]==0 && chkbingo[23]==0 && chkbingo[29]==0 && chkbingo[35]==0){
				line+=1;
			}
			alreadyconnect=line;
		}

		//重置 server
		function allreset () {
			gameover = 0;	
			var bingonumber=[];
			var allbingoplate=new Array();
			var bingocontent=new Array();

			resetalltime();
			clearoldplate();
			getbingonumber();
			insertbingoplate();	
			resetbingonumber();
			insertbingoround();
			breaktime();

			//reset alltime
			function resetalltime(){
				$.ajax({
				    type:"POST",
				    url:"../api/reset_alltime_api.php",
				    success:function(data){
				    	console.log("已重置所有時間秒數");
				    },
				    error:function(){
				        alert("reset_alltime_api.php");
				    }
				});
			}

			//刪除舊的賓果盤
			function clearoldplate(){
				$.ajax({
				    type:"POST",
				    url:"../api/reset_bingoplate_api.php",
				    success:function(data){
				    	console.log("已刪除上回合的賓果盤");
				    },
				    error:function(){
				        alert("reset_bingoplate_api.php");
				    }
				});
			}

			//將開過的號碼狀態歸0
			function resetbingonumber(){
				$.ajax({
				    type:"POST",
				    url:"../api/reset_update_open_bingonumber_api.php",
				    success:function(data){
				    	// console.log(data);
				    },
				    error:function(){
				        alert("reset_update_open_bingonumber_api.php");
				    }
				});
			}  

			//取的賓果盤號碼
			function getbingonumber(){
				for(var n=1;n<=60;n++){			
					bingonumber.push(n);
				}

				for(i=1;i<=10;i++){
					var chklinearr =[];
					//洗牌
					bingonumber=shuffle(bingonumber);
					//將洗牌過的bingonumber 傳給bingodom
					allbingoplate[i-1]=bingonumber;
					bingoshufflenum=allbingoplate[i-1];
									
					for(var j=0;j<36;j++){	
						// console.log(n);
						chklinearr[j]=bingoshufflenum[j];
						n=j+1;
					}
					bingocontent[i-1]=chklinearr;
					// console.log(chkbingotable);
				}
					bingonumber=shuffle(bingonumber);
				// console.log(bingonumber);
			}

			//更新賓果盤資料
			function insertbingoplate(){	
				for(i=1;i<=10;i++){
					$.ajax({
				        type:"POST",
				        url:"../api/insert_bingoplate_api.php",
				        data:{bp_number:i,bp_content:JSON.stringify(bingocontent[i-1]),bp_chklinearray:JSON.stringify(bingocontent[i-1])},
				        success:function(data){
				        	// console.log(data);
				        },
				        error:function(){
				            alert("insert_bingoplate_api.php");
				        }
				    });				
				}
			}

			//增新遊戲場次
			function insertbingoround(){
				$.ajax({
					type:"POST",
					url:"../api/insert_bingoround_api.php",
					dataType:"json",
					success:function(){
					},
					error:function(){
					    alert("insert_bingoround_api.php");
					}
				});
			}

			//讀取休息時間 break_Time
			function breaktime(){
				var readbreaktime = setInterval(( () => checkbreaktime() ), 1000);
				function checkbreaktime(){
					$.ajax({
					    type:"POST",
					    url:"../api/read_breaktime_api.php",
					    success:function(data){
					    	if(data==0){
					    		clearInterval(readbreaktime);
					    		selectplatetime();
					    	}
					    	console.log("休息時間 : "+data);
					    },
					    error:function(){
					        alert("read_breaktime_api.php");
					    }
					});
				}	
			}

			//讀取選取時間
			function selectplatetime(){
				var readselectplatetime = setInterval(( () => checkselectplatetime() ), 1000);
				function checkselectplatetime(){
					$.ajax({
					    type:"POST",
					    url:"../api/read_selectplatetime_api.php",
					    success:function(data){
					    	if(data==0){
					    		clearInterval(readselectplatetime);
					    		loadtime();
					    	}
					    	console.log("選擇時間 : "+data);
					    },
					    error:function(){
					        alert("read_selectplatetime_api.php");
					    }
					});
				}	
			}

			//讀取loadtime的秒數,秒數為0啟動readygame();;
			function loadtime(){
				var readloadtime = setInterval(( () => checkloadtime() ), 1000); //讀取load時間
				function checkloadtime(){
					$.ajax({
					    type:"POST",
					    url:"../api/read_loadtime_api.php",
					    success:function(data){
					    	if(data==0){
					    		clearInterval(readloadtime);
					    		readygame();
					    	}
					    	console.log("LOAD時間 : "+data);
					    },
					    error:function(){
					        alert("read_loadtime_api.php");
					    }
					});
				}			
			}

			function readygame(){
				var ready = setTimeout(( () => startgame() ), 2000); //讀取load時間
			}

		}

		//參考https://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
		//把陣列元素打亂
		function shuffle(array) {
		  var currentIndex = array.length, temporaryValue, randomIndex;
		  // While there remain elements to shuffle...
		  while (0 !== currentIndex) {

		    // Pick a remaining element...
		    randomIndex = Math.floor(Math.random() * currentIndex);
		    currentIndex -= 1;

		    // And swap it with the current element.
		    temporaryValue = array[currentIndex];
		    array[currentIndex] = array[randomIndex];
		    array[randomIndex] = temporaryValue;
		  }

		  return array;
		}
	</script>
</body>
</html>