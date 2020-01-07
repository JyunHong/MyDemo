<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>留言板</title>
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
		.content{
			width: 100%;
			padding-top: 10px;
			padding-right: 5px;
			padding-left: 5px;
		}
		.pt{
			padding-top: 2px;
		}
		 p{
			white-space:nowrap; 
			width:100%;
			overflow:hidden;
			text-overflow:ellipsis;
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
	<div class="bd-example">
		<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
		    <ol class="carousel-indicators">
			    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
			    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
			    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
		    </ol>

		    <div class="carousel-inner">
			    <div class="carousel-item active myset bg_cover" style="background-image: url(images/05.jpg);">      
			        <div class="carousel-caption d-none d-md-block">
			        </div>
			    </div>

			    <div class="carousel-item myset bg_cover" style="background-image: url(images/04.jpg);">
			        <div class="carousel-caption d-none d-md-block">
			        </div>
			    </div>

				<div class="carousel-item myset bg_cover" style="background-image: url(images/06.jpg);">
			        <div class="carousel-caption d-none d-md-block">
			        </div>
			    </div>	
		    </div>

		    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
		    </a>
		    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
		    </a>
		</div>
	</div>

	<div class="bd-example">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <a class="navbar-brand">留言板</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="insert_message.php">我要發文 <img src="/images/icon/typing-50.png" alt="" width="20" height="20"></a>
		      </li>

		    </ul>
		    <ul class="form-inline my-2 my-lg-0">
		      <input class="form-control mr-sm-2" type="search" placeholder="尋找你要的文章" aria-label="Search" name="searchtitle" id="searchtitle">
		      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" onclick="searchtitle()">搜尋</button>
		    </ul>
		  </div>
		</nav>
	</div>
	<div class="row content">
	  <div class="col-3">
	    <div class="list-group">
		  <a href="#" class="list-group-item list-group-item-action" onclick="checkhtitle('有趣')">有趣</a>
		  <a href="#" class="list-group-item list-group-item-action" onclick="checkhtitle('閒聊')">閒聊</a>
		  <a href="#" class="list-group-item list-group-item-action" onclick="checkhtitle('美食')">美食</a>
		  <a href="#" class="list-group-item list-group-item-action" onclick="checkhtitle('電影')">電影</a>
		</div>
	  </div>
	  <div class="col-8" >
	  	<div class="list-group messageboard" id="messageboard">
	  	</div>
	  </div>
	</div>	
	<script src="../js/bootstrap.min.js"></script>
	<script>
		$(function(){
			//讀取留言
			var m_theme;
            $.ajax({
                type:"POST",
                url:"../api/mess_read_new_api.php",
                dataType:"json",
                success:show,
                error:function(){
                	$("#messageboard").html("目前沒有任何文章!!");
                }
        	});         
        });
        function checkhtitle (m_theme){
			//切換看板
            $.ajax({
                type:"POST",
                url:"../api/mess_read_title_api.php",
                data:{m_theme:m_theme},
                dataType:"json",
                success:show,
                error:function(){
		            $("#messageboard").html("目前沒有任何文章!!");
                }
            });
        }
        function searchtitle (){
			//搜尋留言
			var search_title;
            $.ajax({
                type:"POST",
                url:"../api/search_mess_api.php",
                data:{search_title:$("#searchtitle").val()},
                dataType:"json",
                success:show,
                error:function(){
		            $("#messageboard").html("沒有搜尋到任何文章!!");
                }
            });
        }
        function show(data){
			// console.log(data);
			strMESSAGE='';
			for(i=0;i<data.length;i++){
			strMESSAGE+='<div class="pt">';
			strMESSAGE+='<a href="message_content.php?m_id='+data[i].m_id+'" class="list-group-item list-group-item-action">';
			strMESSAGE+='<div class="d-flex w-100 justify-content-between align-items-center">';
			strMESSAGE+='<h4 class="mb-1">'+data[i].m_title+'</h4>';
			strMESSAGE+='<small>'+data[i].m_createtime+'</small>';
			strMESSAGE+='</div>';
			strMESSAGE+='<p class="mb-1 ellipsis">'+data[i].m_message+'</p>';
			strMESSAGE+='<div class="d-flex w-100 justify-content-between align-items-center">';
			strMESSAGE+='<small>作者: '+data[i].u_name+' <img src="./images/icon/relike-50.png" alt="" id="remesslike" width="15" height="15"> '+data[i].m_like+'</small>';
			strMESSAGE+='<small>已有 '+data[i].rem+'則留言</small>';
			strMESSAGE+='</div>';
			strMESSAGE+='</a>';
			strMESSAGE+='</div>';		
			}
			$("#messageboard").html(strMESSAGE);	
		}
	</script>
</body>
<foot>
	<div>作者:JH</div>
</foot>

</html>