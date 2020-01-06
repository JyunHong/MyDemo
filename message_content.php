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
		.box{
			padding-top: 5px;
		}
/*		p{
		white-space:nowrap; 
		width:100%;
		overflow:hidden;
		text-overflow:ellipsis;
		}*/
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
	          <a class="nav-link" href="/message_board.php">留言版</a>
	        </li>
	        <li class="nav-item pl">
			  <a class="nav-link" href="/api/logout-api.php"><img class="shopbag" src="/images/icon/wbag-50.png" alt="" width="20" height="20"></a>
			</li>
	        <li class="nav-item notlogin pl">
	          <a class="nav-link btn btn-outline-primary" href="/login.php">登入</a>
	        </li>
	        <li class="nav-item notlogin pl">
	          <a class="nav-link btn btn-outline-primary" href="/register.php">註冊</a>
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
			  <a class="nav-link btn btn-outline-primary" href="/api/logout-api.php">登出</a>
			</li>
		  </ul>
		</div>
	  </nav>	
	</div>

	<div class="row content">
	  <div class="col-1">
	  	<button type="button" class="btn btn-outline-dark" onclick="history.back()">back</button>
	  </div>
	  <div class="col-10" id="messagecontent">
<!-- 	  	<div class="list-group messagecontent">
			<ul class="list-group-item">
			<li class="d-flex w-100 justify-content-between">
			<h4 class="mb-1">LAYOUT測試</h4>
			<small>20120-12-12</small>
			</li>
			<li class="d-flex w-100 justify-content-between align-items-center">
			<small>LAYOUT測試</small>
			<a href="/api/" class="chkuid"><img src="/images/icon/wbag-50.png" alt="編輯" width="15" height="15"></a>
			</li>
			<p class="mb-1 ellipsis">LAYOUT測試</p>
			</ul>
		</div> -->
	  </div>
	</div>
	<div class="row content">
	  <div class="col-1">
	  </div>
	  <div class="col-10" id="remess">
	  </div>
	</div>	
	<div class="row content">
	  <div class="col-1">
	</div>
	  <div class="col-10">
	    <div class="form-group">
	      <label for="rem_message">我要回覆</label>
	      <textarea class="form-control" id="rem_message" rows="3" name="rem_message" required="TRUE"></textarea>
	    </div>
	    <div class="form-group">
	      <button class="btn btn-outline-primary" id="submitbtn">回覆</button>
	    </div>
	  </div>
	</div>
	<script src="../js/bootstrap.min.js"></script>
	<script>
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
		$(function(){
			//讀取留言
            var m_id=getUrlParameter('m_id');
            // console.log(getUrlParameter('m_id'));
            $.ajax({
                type:"GET",
                url:"../api/mess_read_api.php",
                data:{m_id:getUrlParameter('m_id')},
                dataType:"json",
                success:show,
                error:function(){
		            $("#messagecontent").html("目前沒有任何評論!!");
		        }  
            });
        	function show(data){
				strMESSAGE='';
				strMESSAGE+='<div class="list-group messagecontent box">';
				strMESSAGE+='<ul class="list-group-item">';
				strMESSAGE+='<li class="d-flex w-100 justify-content-between">';
				strMESSAGE+='<h4 class="mb-1">'+data[0].m_title+'</h4>';
				strMESSAGE+='<small>'+data[0].m_createtime+'</small>';
				strMESSAGE+='</li>';
				strMESSAGE+='<li class="d-flex w-100 justify-content-between align-items-center">';
				strMESSAGE+='<small>作者: '+data[0].u_name+'</small>';
					if(data[0].u_ID==<?php if(isset($_SESSION["u_ID"])){echo $_SESSION["u_ID"];}else{echo "0";}?>){
					strMESSAGE+='<small><a href="#" id="'+data[0].u_ID+'" onclick="chkupdatemess()"><img src="/images/icon/edit-24.png" alt="編輯" width="15" height="15"></a></small>';
					}else{
					strMESSAGE+='<small><a href="" onclick="favorite()"><img src="/images/icon/wstar-50.png" alt="編輯" width="15" height="15" id="favoritemess"></a></small>';
					}
				strMESSAGE+='</li>';
				strMESSAGE+='<li class="d-flex w-100 justify-content-between align-items-center">';
				strMESSAGE+='<p class="mb-1 ellipsis">'+data[0].m_message+'</p>';
				strMESSAGE+='</li>';
				strMESSAGE+='<li class="d-flex w-100 justify-content-between align-items-center">';
				strMESSAGE+='<small><a href="" onclick="like()"><img src="./images/icon/like-50.png" alt="" id="like" width="20" height="20"></a> 已有'+data[0].m_like+'個讚</small>';
				strMESSAGE+='</li>';
				strMESSAGE+='</ul>';
				strMESSAGE+='</div>';
				$("#messagecontent").append(strMESSAGE);
			}
			// 讀取我是否按讚
            $.ajax({
                type:"POST",
                url:"../api/like_message_read_api.php",
                data:{u_ID:
                        <?php 
                            if(isset($_SESSION["u_ID"])){
                                echo $_SESSION["u_ID"];
                            }else{
                                echo "0";
                            }
                        ?>
                    ,m_id:getUrlParameter('m_id')},
                success:checklike,
                error:function(){
                    alert("like_message_read_api.php error");
                }
        	});
            //讀取我是否收藏
        	$.ajax({
                type:"POST",
                url:"../api/favorite_message_read_api.php",
                data:{u_ID:
                        <?php 
                            if(isset($_SESSION["u_ID"])){
                                echo $_SESSION["u_ID"];
                            }else{
                                echo "0";
                            }
                        ?>
                    ,m_id:getUrlParameter('m_id')},
                success:checkfavorite,
                error:function(){
                    alert("favorite_message_read_api.php error!!");
                }
        	});

        });
        $(function(){
			//讀取回覆留言
            var m_id=getUrlParameter('m_id');
            // console.log(getUrlParameter('m_id'));
            $.ajax({
                type:"GET",
                url:"../api/remess_read_api.php",
                data:{m_id:getUrlParameter('m_id')},
                dataType:"json",
                success:remess,
                error:function(){
		            $("#remess").html("目前沒有任何留言回覆!!");
		        }  
            });

            //讀取我回覆留言是否按讚
			function chkremesslike(rem_id){
	            $.ajax({
	                type:"POST",
	                url:"../api/like_remessage_read_api.php",
	                data:{u_ID:
	                        <?php 
	                            if(isset($_SESSION["u_ID"])){
	                                echo $_SESSION["u_ID"];
	                            }else{
	                                echo "0";
	                            }
	                        ?>
	                    ,m_id:getUrlParameter('m_id'),rem_id:rem_id},
	                success:showremesslike,
	                error:function(){
	                    alert("like_remessage_read_api.php error!!");
	                }
	        	});
	        	function showremesslike(data){
	        		// console.log(data);
	        		var remid;
	        		remid=rem_id;
	        		// console.log(remid);
	        		if(data==0){
	        			$("#"+remid).attr("src","images/icon/relike-50.png");
	        		}else{
	        			$("#"+remid).attr("src","images/icon/like-50.png");
	        		}
	        		
	        	}
        	}

      	 	function remess(data){
				for(i=0;i<data.length;i++){
					// console.log(chkremesslike(data[i].rem_id));
					chkremesslike(data[i].rem_id);
					strMESSAGE='';
					strMESSAGE+='<div class="list-group remess box">';
					strMESSAGE+='<ul class="list-group-item list-group-item-action">';
					strMESSAGE+='<li class="d-flex w-100 justify-content-between">';
					strMESSAGE+='<small>'+data[i].u_name+' 的回覆</small>';
					strMESSAGE+='<small>樓層: '+data[i].rem_floor+' '+data[i].rem_createtime+'</small>';
					strMESSAGE+='</li>';
					strMESSAGE+='<li class="d-flex w-100 justify-content-between align-items-center">';
					strMESSAGE+='<p class="mb-1">'+data[i].rem_message+'</p>';
					strMESSAGE+='</li>';
					strMESSAGE+='<li class="d-flex w-100 justify-content-between align-items-center">';				
                    strMESSAGE+='<small><a href="" onclick="remesslike('+data[i].rem_id+')" >';
                    // if(checkrelike){
                    strMESSAGE+='<img src="./images/icon/like-50.png" alt="" id="'+data[i].rem_id+'" width="15" height="15">';
                	// }
					strMESSAGE+='</a> 已有'+data[i].rem_like+'個讚</small>';
					strMESSAGE+='</li>';
					strMESSAGE+='</ul>';
					strMESSAGE+='</div>';
					$("#remess").append(strMESSAGE);
				}

			}
	
        });
        // 回覆留言
        var remess_ok=0;
        $("#submitbtn").bind("click",chkremess);
        $("#rem_message").bind("input propertychange",function(){
			if ($("#rem_message").val().length<0) {
				remess_ok=0;
			}else{
				remess_ok=1;
			}
		});
		function chkremess(){
	      	if(remess_ok){
		        if(confirm("確認回覆?")){
		        	insertmess();
		        }  	
    		}else{
	        	alert("留言不可以空白");
	        }
    	}
    	//回覆留言API
	    function insertmess(){	
			$.ajax({
		        type:"POST",
		        url:"../api/remessage_api.php",
		        data:{u_ID:
		            <?php 
		            if(isset($_SESSION["u_ID"])){
		                echo $_SESSION["u_ID"];
		                }else{
		                echo "0";
		                }
		            ?>
		            ,m_id:getUrlParameter('m_id'),rem_message:$("#rem_message").val()},
		        success:re_message,
		        error:function(){
		            alert("re_message!!");
		        }
		    });
		}
		function re_message(data){
		    alert(data);
		    location.href="message_content.php?m_id="+getUrlParameter('m_id');
		}
		//留言按讚加減
		function like(){
		    $.ajax({
		        type:"POST",
		        url:"../api/like_message_api.php",
		        data:{u_ID:
		            <?php 
		            if(isset($_SESSION["u_ID"])){
		                echo $_SESSION["u_ID"];
		                }else{
		                echo "0";
		                }
		            ?>
		            ,m_id:getUrlParameter('m_id')},
		        success:likemessage,
		        error:function(){
		            alert("re_message!!");
		        }
		    });
		}
		function likemessage(data){
            $("#like").attr("src","images/icon/relike-50.png");
        }

        //如果留言已經按過 讚會是黑色
        function checklike(data){
        // console.log(data);
        	if(data){
                $("#like").attr("src","images/icon/like-50.png");
            }else{
                $("#like").attr("src","images/icon/relike-50.png");
            }
        }
        //如果留言已經收藏 星星會是黑色
        function checkfavorite(data){
        // console.log(data);
        	if(data){
                $("#favoritemess").attr("src","images/icon/wstar-50.png");
            }else{
                $("#favoritemess").attr("src","images/icon/bstar-50.png");
            }
        }

        //按讚回覆留言
        function remesslike(rem_id){
		    $.ajax({
		        type:"POST",
		        url:"../api/like_remessage_api.php",
		        data:{u_ID:
		            <?php 
		            if(isset($_SESSION["u_ID"])){
		                echo $_SESSION["u_ID"];
		                }else{
		                echo "0";
		                }
		            ?>
		            ,rem_id:rem_id},
		        success:likeremess,
		        error:function(){
		            alert("re_message!!");
		        }
		    });
		}
		function likeremess(data){
            // $("#remesslike").attr("src","images/icon/relike-50.png");
        }

        //文章加入收藏
        function favorite(){
        	$.ajax({
		        type:"POST",
		        url:"../api/favorite_message_api.php",
		        data:{u_ID:
		            <?php 
		            if(isset($_SESSION["u_ID"])){
		                echo $_SESSION["u_ID"];
		                }else{
		                echo "0";
		                }
		            ?>
		            ,m_id:getUrlParameter('m_id')},
		        success:favoritemessage,
		        error:function(){
		            alert("re_message!!");
		        }
		    });
        }
        function favoritemessage(data){
        	alert(data);
            // $("#favoritemess").attr("src","images/icon/bstar-50.png");
        }
        function chkupdatemess(){
        	if(confirm("是否編輯文章?")){
        		location.href="update_message.php?m_id="+getUrlParameter('m_id');
        	}   	
        }
	</script>
</body>

</html>