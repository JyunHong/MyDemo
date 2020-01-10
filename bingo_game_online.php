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
				<div class="col-7 text-right"><h1>BingoGame</h1></div>
				<div class="col-4 text-center margin">
					<a href="#" class="btn btn-primary bigbtn" onclick="chkchoosemyplate()">確認選取</a>
				</div>
			</div>			
		</div>
		<div class="pt container-fluid" id="allbingoplate">
		</div>
	</div>
	<script src="../js/bootstrap.min.js"></script>
	<script>

		var bingonumber=[];
		var bingoplatedom=new Array();
		var chkbingotable=new Array();
		var yourchoose ;
		var chooseid ;
		var chkyourchooseplate=0;

		$(function(){
			bingoplatehtml();
			// getbingonumber();
			// insertbingoplate();

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
				console.log(data);
				// var content= new Array();
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
					var content= [];
					content=JSON.parse(data[i].bp_content);
					$("#select"+data[i].bp_number).attr("onclick","choosemyplate("+data[i].bp_ID+","+data[i].bp_number+")");

					for(var j=1;j<=36;j++){
						$("#plate"+data[i].bp_number+"number"+j).html(content[j-1]);
					}

				}
			}

		});

		function choosemyplate(id,a){
				chkyourchooseplate=1;
				clearmyplatecss();
				yourchoose=a;
				chooseid=id;
				$("#plate"+a).css({"border":"2px solid #212529",
									"border-radius": "5%",
									"background-color":"#FFA733"
								 });

				// chkyourchoose=1;				
		}

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
				        success:show,
				        error:function(){
				            alert("update_choose_bingoplate_api.php");
				        }
					});
				}
			}else{
				alert("請先選取你的賓果盤!!");	
			}
			
		}
		function show(data){
			if(data==1){
				location.href = "bingo_game_online_start.php";
			}else{
				alert("你選的賓果盤已被選取,請重新選擇!");
				window.location.reload();
			}
			
		}

		//清除原先賓果盤的狀態
		function clearmyplatecss(){
			for(var i=1;i<=10;i++){
			$("#plate"+i).css({"border":"",
								"border-radius": "",
								"background-color":""
							 });
			}
			
		}

		function shownowplate(){
		}

		//賓果盤的html
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

		function insertbingoplate(){	
			for(i=1;i<=10;i++){
				$.ajax({
			        type:"POST",
			        url:"../api/insert_bingoplate_api.php",
			        data:{bp_number:i,bp_content:JSON.stringify(chkbingotable[i-1])},
			        success:function(data){
			        	console.log(data);
			        },
			        error:function(){
			            alert("insert_bingoplate_api.php");
			        }
			    });				
			}

		}
		console.log(bingonumber);
		//取的賓果盤號碼
		function getbingonumber(){
			for(var n=1;n<=50;n++){			
				bingonumber.push(n);
			}

					for(i=1;i<=10;i++){
							var chklinearr =[];
							//洗牌
							bingonumber=shuffle(bingonumber);
							//將洗牌過的bingonumber 傳給bingodom
							bingoplatedom[i-1]=bingonumber;

							bingoshufflenum=bingoplatedom[i-1];
								
							for(var j=0;j<36;j++){	
								// console.log(a);
								chklinearr[j]=bingoshufflenum[j];
								
								n=j+1;
								$("#plate"+i+"number"+n).attr("class","chkbingo"+bingoshufflenum[j]);
								$("#plate"+i+"number"+n).html(bingoshufflenum[j]);
							}
							chkbingotable[i-1]=chklinearr;
							console.log(chkbingotable);
					}
					bingonumber=shuffle(bingonumber);
			console.log(bingonumber);
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
<!-- 	<script>
		//設定賓果號碼總數 bingonumber
		var bingonumber = [];
		//檢查是否bingo chkbingo
		var chkbingo = [];
		var bingodom = new Array();
		var chkbingotable = new Array();
		var chkbingotablewin = [] ;
		var bingotable = [];
		var bingowinarr =[];
		//結束遊戲 nowstop=1;
		var nowstop=0;
		//已經連線的變數
		var alreadyconnect;
		//你選擇的賓果盤號碼
		var yourchoose;
		//檢查是否有選擇賓果盤
		var chkyourchoose=0;

		$(function(){
			//製作賓果號碼的html
			bingonumberhtml();
			//製作賓果盤的html
			bingotablehtml();
			//寫入賓果號碼
			getbingonumber();
			//頁面開啟時呼叫getnumber()來取的號碼
			getnumber();

		});

		//清除原先賓果盤的狀態
		function clearmytablecss(){
			for(var i=1;i<=5;i++){
			$("#table"+i).css({"border":"",
								"border-radius": "",
								"background-color":""
							 });
			}
			
		}
		//選擇的賓果盤狀態改變
		function choosemytable(a){
			if(chkyourchoose!=2){
				clearmytablecss();
				yourchoose=a;
				$("#table"+a).css({"border":"2px solid #212529",
									"border-radius": "5%",
									"background-color":"#FFA733"
								 });
				chkyourchoose=1;				
			}

		}
		//取的賓果盤號碼
		function getnumber(){
			for(x=1;x<=5;x++){
				var chknumber =[];
				//洗牌
				bingonumber=shuffle(bingonumber);
				//將洗牌過的bingonumber 傳給bingodom
				bingodom[x-1]=bingonumber;

				bingotable=bingodom[x-1];
					
				for(var i=0;i<36;i++){	
					// console.log(a);
					chknumber[i]=bingotable[i];
					
					a=i+1;
					$("#bingo"+x+"number"+a).attr("class","chkbingo"+bingotable[i]);
					$("#bingo"+x+"number"+a).html(bingotable[i]);
				}
				chkbingotable[x-1]=chknumber;
				// console.log(chkbingotable);
			}
			bingonumber=shuffle(bingonumber);
			// console.log(chkbingotable);

		}
		//開始遊戲
		function startgame(){
			if(chkyourchoose==1){
				//開始開號
				var startnumbershift = setInterval(( () => numbershift() ), 100);
				changestartbtn("over");
				chkyourchoose=2;
			}else{
				alert("請先選擇你的賓果盤");
			}

			function numbershift(){
				//判斷bingonumber是否小於1 或是 是否啟動結束遊戲
				if(bingonumber.length<1  || nowstop==1){
					//結束開號
					clearInterval(startnumbershift);
				}else{

					alnumbershift(bingonumber.shift());

					//用迴圈啟動connectline的方法 判斷是哪一個賓果盤賓果
					for(var i=0;i<chkbingotable.length;i++){
						connectline(chkbingotable[i]);
						// console.log(alreadyconnect);
						if(alreadyconnect>4){
							chkbingotablewin.push(i+1);
						}
					}
					if(chkbingotablewin.length>=0){
						switch(chkbingotablewin.length){
							case 1:
								bingowin(chkbingotablewin[0]);
								break;
							case 2:
								bingowin(chkbingotablewin[0],chkbingotablewin[1]);
								break;
						}
					}else{
						alert("不可思議的事情發生了");
					}
				}	
			}
			//將開出的賓果號碼改變狀態
			function alnumbershift(number){
				// console.log(number);	
				for(var i=0;i<chkbingotable.length;i++){

					//設定一個可以接收每個賓果盤的陣列
					var arraybingo=[];

					arraybingo=chkbingotable[i];
					//indexOf(number)可以知道number在陣列的位置
					if(arraybingo.indexOf(number)>=0){
						//arraycheck接收 陣列位置的變數
						arraycheck=arraybingo.indexOf(number);
						//把開出的號碼變成0 去判斷是否連線
						arraybingo[arraycheck]=0;
						//在傳回原本的陣列中
						chkbingotable[i]=arraybingo;
					}					
				}				
				$(".chkbingo"+number).css("background-color","red")
				
				$("#bn"+number).css("color","white");
			}
		}

		//win跳出alert
		function bingowin(a,b){
			nowstop=1;
			changestartbtn("reset");
			if(b){
				bingonum=''+a+'號和'+b+'';
				alert(bingonum+"號賓果盤Bingo");
				$("#winner h1").html("很可惜是"+bingonum+"號賓果盤BINGO");
			}else{
				alert(a+"號賓果盤Bingo");
				$("#winner h1").html("很可惜是"+a+"號賓果盤BINGO");
			}

			if(yourchoose==a || yourchoose==b){
				alert("恭喜你選中賓果盤");
				$("#winner h1").html("YOU WIN");
			}
		}

		//改變按鈕狀態
		function changestartbtn(a){
			switch (a) {
				case "start" :
					$("#start_btn").attr({
											"onclick" : "startgame()",
										    "class" : "btn btn-primary"
										});
					$("#start_btn").html("開始遊戲");
					break;
				case "reset":
					$("#start_btn").attr({
						    				"onclick" : "reset()",
						    				"class" : "btn btn-success"
										});
					$("#start_btn").html("重新開始");
					break;
				case "over":
					$("#start_btn").attr({
										    "onclick" : "overgame()",
										    "class" : "btn btn-danger"
										});

					$("#start_btn").html("結束遊戲");
					break;	
			}

		}
		//重置遊戲
		function reset(){
			nowstop=0;
			chkyourchoose=0;
			bingonumber=[];
			chkbingotablewin=[];
			changestartbtn("start");
			clearmytablecss();
			bingotablehtml();
			bingonumberhtml();
			getbingonumber();
			getnumber();
			$("#winner h1").html("WINNER");
		}

		//寫入賓果號碼
		function getbingonumber(){
			
			for(var n=1;n<=50;n++){
				
				bingonumber.push(n);
			}
		}
		//製作賓果號碼的html 
		function bingonumberhtml(){
			var b=1; //變數重置
			htmlbingonumber='';//變數重置
			for(var x=1;x<=5;x++){
			htmlbingonumber+='<div class="row">';
			htmlbingonumber+='<div class="col-1"></div>';
				for(var i=0;i<10;i++){
					htmlbingonumber+='<div class="col-1 text-center" id="bn'+b+'"> '+b+' </div>';
					b++;		
				}
			htmlbingonumber+='<div class="col-1"></div>';
			htmlbingonumber+='</div>';	
			}
			$("#numbertable").html(htmlbingonumber);
		}
		//製作賓果盤的html
		function bingotablehtml(){
			for(x=1;x<=5;x++){
				var b=1;
				bingotable='';
				bingotable+='<table border=1 align="center">';
				for(var i=0;i<6;i++){
					bingotable+='<tr>';
					for(a=0;a<6;a++){
						bingotable+='<td id="bingo'+x+'number'+b+'" class=""></td>';
						b++;	
					}
					bingotable+='</tr>';				
				}
				bingotable+='</table>';
				$("#bingotable"+x).html(bingotable);
			}
		}

		//檢查賓果盤是否連線
		function connectline(chkbingo){
			var line=0;
			// console.log(chkbingo);
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

		//遊戲結束
		function overgame(){
			nowstop=1;
			changestartbtn("reset");

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

	</script> -->
</body>
</html>