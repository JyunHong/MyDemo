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
		.pl{
			padding-right: 5px;
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
		.pt{
			padding-top: 15px;
		}
		.box{
			height:100vh;
		}
		.circle{
			border:  2px solid #666;
			height: 80px;
			width: 20px;
			border-radius: 50%;
		}
		td{
			width: 40px;
			height: 40px;
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
	          <a class="nav-link" href="message_board.php">留言版</a>
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
	<div class="box">
		<div class="container">
			<div class="row">
				<div class="col-1"></div>
				<div class="col-10 text-center"><h1>BingoGame</h1></div>
			</div>
		</div>
		<div class="container pt" id="numbertable">
			<div class="row">
					<div class="col-1"></div>
					<div class="col-1 text-center" id="bn1"> 1 </div>
					<div class="col-1 text-center" id="bn2"> 2 </div>
					<div class="col-1 text-center" id="bn3"> 3 </div>
					<div class="col-1 text-center" id="bn4"> 4 </div>
					<div class="col-1 text-center" id="bn5"> 5 </div>
					<div class="col-1 text-center" id="bn6"> 6 </div>
					<div class="col-1 text-center" id="bn7"> 7 </div>
					<div class="col-1 text-center" id="bn8"> 8 </div>
					<div class="col-1 text-center" id="bn9"> 9 </div>
					<div class="col-1 text-center" id="bn10"> 10 </div>
			</div>
			<div class="row">
					<div class="col-1"></div>
					<div class="col-1 text-center" id="bn11"> 11 </div>
					<div class="col-1 text-center" id="bn12"> 12 </div>
					<div class="col-1 text-center" id="bn13"> 13 </div>
					<div class="col-1 text-center" id="bn14"> 14 </div>
					<div class="col-1 text-center" id="bn15"> 15 </div>
					<div class="col-1 text-center" id="bn16"> 16 </div>
					<div class="col-1 text-center" id="bn17"> 17 </div>
					<div class="col-1 text-center" id="bn18"> 18 </div>
					<div class="col-1 text-center" id="bn19"> 19 </div>
					<div class="col-1 text-center" id="bn20"> 20 </div>
			</div>
			<div class="row">
					<div class="col-1"></div>
					<div class="col-1 text-center" id="bn21"> 21 </div>
					<div class="col-1 text-center" id="bn22"> 22 </div>
					<div class="col-1 text-center" id="bn23"> 23 </div>
					<div class="col-1 text-center" id="bn24"> 24 </div>
					<div class="col-1 text-center" id="bn25"> 25 </div>
					<div class="col-1 text-center" id="bn26"> 26 </div>
					<div class="col-1 text-center" id="bn27"> 27 </div>
					<div class="col-1 text-center" id="bn28"> 28 </div>
					<div class="col-1 text-center" id="bn29"> 29 </div>
					<div class="col-1 text-center" id="bn30"> 30 </div>
			</div>
			<div class="row">
					<div class="col-1"></div>
					<div class="col-1 text-center" id="bn31"> 31 </div>
					<div class="col-1 text-center" id="bn32"> 32 </div>
					<div class="col-1 text-center" id="bn33"> 33 </div>
					<div class="col-1 text-center" id="bn34"> 34 </div>
					<div class="col-1 text-center" id="bn35"> 35 </div>
					<div class="col-1 text-center" id="bn36"> 36 </div>
					<div class="col-1 text-center" id="bn37"> 37 </div>
					<div class="col-1 text-center" id="bn38"> 38 </div>
					<div class="col-1 text-center" id="bn39"> 39 </div>
					<div class="col-1 text-center" id="bn40"> 40 </div>
			</div>
			<div class="row">
					<div class="col-1"></div>
					<div class="col-1 text-center" id="bn41"> 41 </div>
					<div class="col-1 text-center" id="bn42"> 42 </div>
					<div class="col-1 text-center" id="bn43"> 43 </div>
					<div class="col-1 text-center" id="bn44"> 44 </div>
					<div class="col-1 text-center" id="bn45"> 45 </div>
					<div class="col-1 text-center" id="bn46"> 46 </div>
					<div class="col-1 text-center" id="bn47"> 47 </div>
					<div class="col-1 text-center" id="bn48"> 48 </div>
					<div class="col-1 text-center" id="bn49"> 49 </div>
					<div class="col-1 text-center" id="bn50"> 50 </div>
			</div>
		</div>
		<div class="container pt">
			<div class="row">
			  	<div class="col-12 text-center">
			  		<a href="#" onclick="startgame()" class="btn btn-primary" id="start_btn">開始遊戲</a>
			  	</div>
			</div>
		</div>
		<div class="container pt">
			<div class="row">
			  	<div class="col-12 text-center">
			  	</div>
			</div>
			<div class="row pt">
			  	<div class="col-6 text-center">
			  		<div class="pt">
			  		<h3>我的賓果盤</h3>
			  		</div>
				  		<table border=1 align="center">
					  		<tr>
					  			<td id="mynumber1" chkbingo="" class=""></td>
					  			<td id="mynumber2" chkbingo="" class=""></td>
					  			<td id="mynumber3" chkbingo="" class=""></td>
					  			<td id="mynumber4" chkbingo="" class=""></td>
					  			<td id="mynumber5" chkbingo="" class=""></td>
					  			<td id="mynumber6" chkbingo="" class=""></td>
					  		</tr>
					  		<tr>
					  			<td id="mynumber7" chkbingo="" class=""></td>
					  			<td id="mynumber8" chkbingo="" class=""></td>
					  			<td id="mynumber9" chkbingo="" class=""></td>
					  			<td id="mynumber10" chkbingo="" class=""></td>
					  			<td id="mynumber11" chkbingo="" class=""></td>
					  			<td id="mynumber12" chkbingo="" class=""></td>
					  		</tr>
					  		<tr>
					  			<td id="mynumber13" chkbingo="" class=""></td>
					  			<td id="mynumber14" chkbingo="" class=""></td>
					  			<td id="mynumber15" chkbingo="" class=""></td>
					  			<td id="mynumber16" chkbingo="" class=""></td>
					  			<td id="mynumber17" chkbingo="" class=""></td>
					  			<td id="mynumber18" chkbingo="" class=""></td>
					  		</tr>
					  		<tr>
					  			<td id="mynumber19" chkbingo="" class=""></td>
					  			<td id="mynumber20" chkbingo="" class=""></td>
					  			<td id="mynumber21" chkbingo="" class=""></td>
					  			<td id="mynumber22" chkbingo="" class=""></td>
					  			<td id="mynumber23" chkbingo="" class=""></td>
					  			<td id="mynumber24" chkbingo="" class=""></td>
					  		</tr>
					  		<tr>
					  			<td id="mynumber25" chkbingo="" class=""></td>
					  			<td id="mynumber26" chkbingo="" class=""></td>
					  			<td id="mynumber27" chkbingo="" class=""></td>
					  			<td id="mynumber28" chkbingo="" class=""></td>
					  			<td id="mynumber29" chkbingo="" class=""></td>
					  			<td id="mynumber30" chkbingo="" class=""></td>
					  		</tr>
					  		<tr>
					  			<td id="mynumber31" chkbingo="" class=""></td>
					  			<td id="mynumber32" chkbingo="" class=""></td>
					  			<td id="mynumber33" chkbingo="" class=""></td>
					  			<td id="mynumber34" chkbingo="" class=""></td>
					  			<td id="mynumber35" chkbingo="" class=""></td>
					  			<td id="mynumber36" chkbingo="" class=""></td>
					  		</tr>
				  		</table>	  			
			  		<div class="pt"><a href="#" onclick="getnumber()" id="getnumber" class="btn btn-info">選號</a></div>
			  	</div>
			  	<div class="col-6 text-center margin">
			  		<div id=""><h1>當前號碼</h1></div>
			  		<div id="now"><h1>0</h1></div>
			  		<div id="yourline" class="pt">你目前的連線</div>
			  	</div>
			</div>
			<div class="row pt">
			  	<div class="col-3 text-center">
			  		
			  	</div>
			</div>
		</div>
	</div>	
	<script src="../js/bootstrap.min.js"></script>
	<script>
		// $(function(){
			var number = [];
			var mynumber = [];
			var chknumber = [];
			// var mynumber = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50];
			var startnumbershift;
			var nowstop=0;
			var arrchk;
			var alline=0;
			// str='';
			for(var n=1;n<=50;n++){
				number.push(n);
				mynumber.push(n);
			}
			number=shuffle(number);
			mynumber=shuffle(mynumber);
			// console.log(number);
			// console.log(mynumber);
			// for (var a=1; a <= 5;a++) {
			// 	str+='<div class="row">';
			// 	for(var i=1;i<=10;i++){
			// 		// console.log(i);
			// 		b=number.shift();
			// 		str+='<div class="col-1" id="bn'+b+'"> '+b+' </div>';
			// 	}
			// 	str+='</div>';			
			// }
			// $("#numbertable").html(str);
	
		// });

		function startgame(){
			var startnumbershift = setInterval(( () => numbershift() ), 100);
			$("#start_btn").attr({
								    "onclick" : "overgame()",
								    "class" : "btn btn-danger"
								});

			$("#start_btn").html("結束遊戲");
			function numbershift(){
				if(number.length<1  || nowstop==1){
					clearInterval(startnumbershift);
					// console.log(nowstop);
				}else{
					// console.log(number);
					// console.log(number.shift());
					alnumbershift(number.shift());
					connectline();
					$("#yourline").html("你目前連線"+alline+"條");
				}	
			}
			function alnumbershift(number){
				// console.log(number);		
				if(chknumber.indexOf(number)>=0){
					arrchk=chknumber.indexOf(number);
					chknumber[arrchk]=0;
					// console.log(number);
					// console.log(arrchk);
					// console.log(chknumber);
				}
				
				$(".chkbingo"+number).css("background-color","red")
				
				$("#bn"+number).css("color","white");

				$("#now h1").html(number);

				
			}

		}
		function getnumber(){
			mynumber=shuffle(mynumber);
			for(var i=1;i<=36;i++){
				chknumber[i-1]=mynumber[i];
				$("#mynumber"+i).attr("class","chkbingo"+mynumber[i]);
				$("#mynumber"+i).html(mynumber[i]);
			}
			// console.log(chknumber);
		}

		function connectline(){
			var line=0;

			//橫線
			if(chknumber[0]==0 && chknumber[1]==0 && chknumber[2]==0 && chknumber[3]==0 && chknumber[4]==0 && chknumber[5]==0){
				line+=1;
			}
			if(chknumber[6]==0 && chknumber[7]==0 && chknumber[8]==0 && chknumber[9]==0 && chknumber[10]==0 && chknumber[11]==0){
				line+=1;
			}
			if(chknumber[12]==0 && chknumber[13]==0 && chknumber[14]==0 && chknumber[15]==0 && chknumber[16]==0 && chknumber[17]==0){
				line+=1;
			}
			if(chknumber[18] ==0 &&chknumber[19] ==0 && chknumber[20]==0 && chknumber[21]==0 && chknumber[22]==0 && chknumber[23]==0){
				line+=1;
			}
			if(chknumber[24]==0 && chknumber[25]==0 && chknumber[26]==0 && chknumber[27]==0 && chknumber[28]==0 && chknumber[29]==0){ 
				line+=1;
			}
			if(chknumber[30]==0 && chknumber[31]==0 && chknumber[32]==0 && chknumber[33]==0 && chknumber[34]==0 && chknumber[35]==0){
				line+=1;
			}
			//斜線
			if(chknumber[0]==0 && chknumber[7]==0 && chknumber[14]==0 && chknumber[21]==0&& chknumber[28]==0 &&  chknumber[35]==0){
				line+=1;
			}
			if(chknumber[5]==0 && chknumber[10]==0 && chknumber[15]==0 && chknumber[20]==0&& chknumber[25]==0 && chknumber[30]==0){
				line+=1;
			}
			//直線
			if(chknumber[0]==0 && chknumber[6]==0 && chknumber[12]==0 && chknumber[18]==0 && chknumber[24]==0 &&  chknumber[30]==0){
				line+=1;
			}
			if(chknumber[1]==0 && chknumber[7]==0 && chknumber[13]==0 && chknumber[19]==0 && chknumber[25]==0 &&  chknumber[31]==0){
				line+=1;
			}
			if(chknumber[2]==0 && chknumber[8]==0 && chknumber[14]==0 && chknumber[20]==0 && chknumber[26]==0 &&  chknumber[32]==0){
				line+=1;
			}
			if(chknumber[3]==0 && chknumber[9]==0 && chknumber[15]==0 && chknumber[21]==0 && chknumber[27]==0 &&  chknumber[33]==0){
				line+=1;
			}
			if(chknumber[4]==0 && chknumber[10]==0 && chknumber[16]==0 && chknumber[22]==0 && chknumber[28]==0 && chknumber[34]==0){
				line+=1;
			}
			if(chknumber[5]==0 && chknumber[11]==0 && chknumber[17]==0 && chknumber[23]==0 && chknumber[29]==0 && chknumber[35]==0){
				line+=1;
			}
			alline=line;
			// console.log(nowstop);
			if(line>4){
				nowstop=1;
				// overgame();
				alert("Bingo");

			}

		}


		function overgame(){
			nowstop=1;
		}

		function getnumber(){
			mynumber=shuffle(mynumber);
			for(var i=1;i<=36;i++){
				chknumber[i-1]=mynumber[i];
				$("#mynumber"+i).attr("class","chkbingo"+mynumber[i]);
				$("#mynumber"+i).html(mynumber[i]);
			}
			// console.log(chknumber);
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