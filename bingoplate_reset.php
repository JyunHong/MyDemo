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
	

</head>
<body>
	<script src="../js/bootstrap.min.js"></script>
	<script>

		var bingonumber=[];
		var bingoplatedom=new Array();
		var chkbingotable=new Array();
		var yourchoose ;
		var chooseid ;

		$(function(){

		clearoldnumber();
		getbingonumber();
		insertbingoplate();



		});
		function clearoldnumber(){
			$.ajax({
			    type:"POST",
			    url:"../api/reset_bingoplate_api.php",
			    success:function(data){
			    	// console.log(data);
			    },
			    error:function(){
			        alert("reset_bingoplate_api.php");
			    }
			});
		}

		function insertbingoplate(){	
			for(i=1;i<=10;i++){
				$.ajax({
			        type:"POST",
			        url:"../api/insert_bingoplate_api.php",
			        data:{bp_number:i,bp_content:JSON.stringify(chkbingotable[i-1]),bp_chklinearray:JSON.stringify(chkbingotable[i-1])},
			        success:function(data){
			        	// console.log(data);
			        },
			        error:function(){
			            alert("insert_bingoplate_api.php");
			        }
			    });				
			}
			location.href = "bingo_game_online.php"

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
				// console.log(chkbingotable);
				}
				bingonumber=shuffle(bingonumber);
			// console.log(bingonumber);
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