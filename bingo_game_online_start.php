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

		<div class="pt container-fluid" id="allbingonumber">
		</div>
		<div class="pt container-fluid">
			<div class="row">
			  	<div class="col-12 text-center">
			  		<a href="#" onclick="startgame()" class="btn btn-primary" id="start_btn">開始遊戲</a>
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
		var content= [];
		var yourchoose ;
		var chooseid ;
		var chkwinner = [];
		var alreadyconnect ;
		var gameover = 0;
		var uid = [];
		var winid = [] ;

		bingoplatehtml();
		bingonumberhtml();
		readallbingoplate();
		readnumber();
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

		//寫入賓果號碼
		function getbingonumber(){
			
			for(var n=1;n<=60;n++){
				
				bingonumber.push(n);
			}
			//重新洗牌
			bingonumber=shuffle(bingonumber);
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
						uid[i]=data[i].u_ID;
						for(var j=1;j<=36;j++){
							var n ;
							n=datacontent[j-1];
							$("#plate"+data[i].bp_number+"number"+j).attr("class","chkbingo"+n);
							$("#plate"+data[i].bp_number+"number"+j).html(datacontent[j-1]);
						}
						if(data[i].u_ID==<?php if(isset($_SESSION["u_ID"])){echo $_SESSION["u_ID"];
                            				   }else{echo "-1";}?>){

							$("#plate"+data[i].bp_number).css({"border":"2px solid #212529",
																	"border-radius": "5%",
																	"background-color":"#FFA733"
								 								  });
							$("#plate"+data[i].bp_number+" h3").html("我的賓果盤");
						}
						chkbingoline[i]=datacontent;
					}		
				}	
		}
		// console.log(chkbingoline);

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


		
		//開始開球
		function startgame(){
			getbingonumber();
			//開始開球
			var startnumbershift = setInterval(( () => numbershift() ), 100);
			// changestartbtn("over");
			function numbershift(){
				var opennumber = 0; //開出的號碼歸零
				// console.log(bingonumber);	
				//判斷bingonumber是否小於1 或是 是否啟動結束遊戲
				if(bingonumber.length<1  || gameover==1){
					//結束開號
					clearInterval(startnumbershift);
				}else{
					//shift()把陣列第一個號取出
					opennumber=bingonumber.shift();
					console.log(opennumber);
					readnumber();
					alnumbershift(opennumber);
					updatebnumber(opennumber);

					//用迴圈啟動connectline的方法 判斷是哪一個賓果盤賓果
					for(var i=0;i<chkbingoline.length;i++){
						var n=0;
						connectline(chkbingoline[i]);

						if(alreadyconnect>4){
							n=chkwinner.push(i+1);
							winid=uid[n];
						}
					}				
					if(chkwinner.length>=0 && chkwinner.length<=3){
					console.log(chkwinner.length); 
						switch(chkwinner.length){
							case 1:
								chkwinner[0];
								bingowin(chkwinner[0]);
								break;
							case 2:
								chkwinner[0];
								chkwinner[1];
								bingowin(chkwinner[0],chkwinner[1]);
								break;
							case 3:
								chkwinner[0];
								chkwinner[1];
								chkwinner[2];
								bingowin(chkwinner[0],chkwinner[1],chkwinner[2]);
								break;
						}
					}else if(chkwinner.length>3){
						alert("不可思議的事情發生了");
						gameover=1;
					}
				}				
			}
		}
		//更新開出號碼的狀態 	
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

		//將開出的賓果號碼改變狀態
		function alnumbershift(number){
			// console.log(chkbingoline);	
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
			
			//先讀取賓果盤的號碼
			// $.ajax({
			//     type:"POST",
			//     url:"../api/read_bingoplatenum_api.php",
			//     dataType:"json",
			//     success:showplatearray,
			//     error:function(){
			//     	alert("read_bingoplatenum_api.php");
			//    }
			// });
			// function showplatearray(){
			// 	datacontent=JSON.parse(data[i].bp_content);
			// }
		}

		//更新陣列參數來判斷是否連線
		function upchkarray(n,array){
			$.ajax({
			    type:"POST",
			    url:"../api/upchkarray_bingoplate_api.php",
			    data:{bp_number:n,bp_chklinearray:JSON.stringify(array)},
			    dataType:"json",
			    success:show,
			    error:function(){
			    	alert("upchkarray_bingoplate_api.php");
			   	}
			});
			function show(data){
				// console.log(data);
			}				
		}
		

		//win跳出alert
		function bingowin(winner,winnertwo,winnerthree){
			gameover=1;

			yourid=<?php if(isset($_SESSION["u_ID"])){
                            echo $_SESSION["u_ID"];
                     	 }else{
                        	echo "-1";
                     	 } ?> ;
			console.log(yourid);
			if(yourid== winid[0] || yourid == winid[1] || yourid == winid[3]){
				alert("恭喜你賓果成功");
				$("#winner h1").html("YOU WIN");
			}

			if(winnerthree){
				bingonum=winner+'.'+winnertwo+'.'+winnerthree;
				alert(bingonum+"號賓果盤同時Bingo");
				$("#winner h1").html("很可惜是"+bingonum+"號賓果盤BINGO");
			}else if (winnertwo){
				bingonum=''+winner+'號和'+winnertwo+'';
				alert(bingonum+"號賓果盤同時Bingo");
				$("#winner h1").html("很可惜是"+bingonum+"號賓果盤BINGO");
			}else{
				alert(winner+"號賓果盤Bingo");
				$("#winner h1").html("很可惜是"+winner+"號賓果盤BINGO");
			}

		}


		function insterewinner(uid,bgn){
			console.log(uid);
			console.log(bgn);
			$.ajax({
                type:"POST",
                url:"../api/insert_bingop_winner_api.php",
                data:{u_ID:uid,bp_number:bgn},
                success:showresult,
                error:function(){
		            alert("insert_bingop_winner_api.php");
                }
            });
            function showresult(data){
            	console.log(data);
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