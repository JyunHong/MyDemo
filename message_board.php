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
		.yeslogin{
			display:<?php
			 if(isset($_SESSION["u_ID"])):
			 	echo "none";
			 else :
			 	echo "inline";
			 endif;?>;
		}
		.notlogin{
			display:<?php
			 if(!isset($_SESSION["u_ID"])):
			 	echo "none";
			 else :
			 	echo "inline";
			 endif;?>;
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
	          <li class="nav-item yeslogin">
	            <a class="nav-link btn btn-outline-primary" href="/login.php">登入</a>
	          </li>
	          <li class="nav-item yeslogin">
	            <a class="nav-link btn btn-outline-primary" href="/register.php">註冊</a>
	          </li>
	          <li class="nav-item active notlogin">
	            <a class="nav-link" href="/message_board.php">留言版</a>
	          </li>
	          <li class="nav-item notlogin">
				<a class="nav-link" href="/api/logout-api.php"><img class="shopbag" src="/images/icon/wbag-50.png" alt="" width="20" height="20"></a>
			  </li>
	        </ul>
	        <ul class="navbar-nav nav-pills notlogin">

		      <li class="nav-item active dropdown notlogin">
		        <a class="nav-link dropdown-toggle notlogin" data-toggle="dropdown"><?php if(isset($_SESSION["u_name"])){echo $_SESSION["u_name"];}?> 您好</a>
		        <div class="dropdown-menu">
		          <a class="dropdown-item notlogin <?php if($_SESSION["u_level"]==1){ echo "d-none";} ?>" href="yourdata.php">顯示個人資料</a>
		          <a class="dropdown-item notlogin <?php if($_SESSION["u_level"]==1){ echo "d-none";} ?>" href="userdata_up.php">修改個人資料</a>
		          <a class="dropdown-item notlogin <?php if($_SESSION["u_level"]==1){ echo "d-none";} ?>" href="user_up_password.php">變更密碼</a>
		          <a class="dropdown-item managerlogin <?php if((!$_SESSION["u_level"]==8)  || (!$_SESSION["u_level"]==9)){ echo "d-none";} ?>" href="backup.php">控制台分析圖表</a>
		          <a class="dropdown-item managerlogin <?php if((!$_SESSION["u_level"]==8)  || (!$_SESSION["u_level"]==9)){ echo "d-none";} ?>" href="userdata_list_table.php">會員列表</a>
		        </div>
		      </li>
		    </ul>
		    <li class="nav-item notlogin">
				<a class="nav-link btn btn-outline-primary" href="/api/logout-api.php">登出</a>
			</li>
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
			    <div class="carousel-item active myset bg_cover" style="background-image: url(images/03.jpg);">      
			        <div class="carousel-caption d-none d-md-block">
			        </div>
			    </div>

			    <div class="carousel-item myset bg_cover" style="background-image: url(images/02.jpg);">
			        <div class="carousel-caption d-none d-md-block">
			        </div>
			    </div>

				<div class="carousel-item myset bg_cover" style="background-image: url(images/01.jpg);">
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
		  <a href="message_board.php?m_theme=有趣" class="list-group-item list-group-item-action">有趣</a>
		  <a href="message_board.php?m_theme=閒聊" class="list-group-item list-group-item-action">閒聊</a>
		  <a href="message_board.php?m_theme=美食" class="list-group-item list-group-item-action">美食</a>
		  <a href="message_board.php?m_theme=電影" class="list-group-item list-group-item-action">電影</a>
		</div>
	  </div>
	  <div class="col-8" >
	  	<div class="list-group messageboard box" id="messageboard">
	  	</div>
	  </div>
	</div>	
	<script src="../js/bootstrap.min.js"></script>
	<script>
		$(function(){
			//讀取留言
			var getUrlParameter = function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
            };
            var m_theme=getUrlParameter('m_theme');
            // console.log(getUrlParameter('m_theme'));
            if(m_theme==undefined){ 	
            	$.ajax({
                type:"GET",
                url:"../api/mess_read_title_api.php",
                data:{m_theme:"有趣"},
                dataType:"json",
                success:show,
                error:function(){
                	$("#messageboard").html("目前沒有任何文章!!");
                }
        	});
            }else{
	            $.ajax({
	                type:"GET",
	                url:"../api/mess_read_title_api.php",
	                data:{m_theme:m_theme},
	                dataType:"json",
	                success:show,
	                error:function(){
	                	$("#messageboard").html("目前沒有任何文章!!");
	                }
	        	});	
            }
            
        });
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
		            $("#messageboard").html("目前沒有任何評論!!");
                }
            });
        }
        function show(data){
			// console.log(data);
			strMESSAGE='';
			for(i=0;i<data.length;i++){
			strMESSAGE+='<a href="message_content.php?m_id='+data[i].m_id+'" class="list-group-item list-group-item-action">';
			strMESSAGE+='<div class="d-flex w-100 justify-content-between align-items-center">';
			strMESSAGE+='<h4 class="mb-1">'+data[i].m_title+'</h4>';
			strMESSAGE+='<small>'+data[i].m_createtime+'</small>';
			strMESSAGE+='</div>';
			strMESSAGE+='<p class="mb-1 ellipsis">'+data[i].m_message+'</p>';
			strMESSAGE+='<div class="d-flex w-100 justify-content-between align-items-center">';
			strMESSAGE+='<small>作者: '+data[i].u_name+'</small>';
			strMESSAGE+='<small>已有 '+data[i].rem+'則留言</small>';
			strMESSAGE+='</div>';
			strMESSAGE+='</a>';		
			}
			$("#messageboard").html(strMESSAGE);	
		}
	</script>
</body>
<foot>
	<div>作者:JH</div>
</foot>

</html>