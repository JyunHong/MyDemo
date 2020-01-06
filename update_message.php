<?php

  session_start();
  // $u_ID = $_POST["u_ID"];
  if(!isset($_SESSION["u_ID"])){
  header("Location: home_page.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>編輯留言</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/all.min.css">
  <script src="../js/jquery-3.3.1.min.js"></script>
  <style>
  .body{
    padding-top: 10px;
    padding-right: 5px;
    padding-left: 5px;
    border-radius: 2%;
  }
  </style>
</head>
<body>
  <div class="body">
      <div class="form-group">
        <div class="row">
        <div class="col-11"><label for="messagetitle">標題</label></div>
        <div class="col-1"><a href="" onclick="delete_mess()"><img src="./images/icon/trash-can-30.png" alt=""></a></div></div>
        <input type="text" class="form-control" id="messagetitle" placeholder="輸入標題" name="messagetitle" required="TRUE">
      </div>
      <div class="form-group">
        <label for="messagetheme">主題</label>
        <select class="form-control" id="messagetheme" name="messagetheme">
          <option>有趣</option>
          <option>閒聊</option>
          <option>美食</option>
          <option>電影</option>
        </select>
      </div>
      <div class="form-group">
        <label for="message">內容</label>
        <textarea class="form-control" id="message" rows="5" name="message" required="TRUE"></textarea>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-outline-primary" id="submit" onclick="update_mess()">
        <input type="submit" class="btn btn-outline-primary" id="submit" value="返回" onclick="cancel()">
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
    var messagetitle=1;
    var message=1;
    $("#messagetitle").bind("input propertychange",function(){
      if ($("#messagetitle").val().length<1) {
        messagetitle=0;
      }else{
        messagetitle=1;
      }
    });
    $("#message").bind("input propertychange",function(){
      if ($("#message").val().length<1) {
        message=0;
      }else{
        message=1;
      }
    });

    $(function(){
      // postID = getUrlParameter('u_ID');
      var ID = <?php echo $_SESSION["u_ID"];?>;
      // console.log(ID);
      // console.log(getUrlParameter('m_id'));
      $.ajax({
        type: "GET",
        url: "../api/update_mess_read_api.php",
        data: {u_ID:ID,m_id:getUrlParameter('m_id')},
        dataType: "json",  
        success: show,
        error: function(){
          alert("update_mess_read_api.php error");
        }
      });
      function show(data){
        if(data[0].u_ID!=<?php echo $_SESSION["u_ID"];?>){
          alert("沒有權限");
          location.href = "home_page.php";
        }
        console.log(data);
        // $("#messagetitle").html("input",data[0].m_title);
        $("#messagetitle").val(data[0].m_title);
        $("#messagetheme").val(data[0].m_theme);;
        $("#message").val(data[0].m_message);
        // $("#chk_btn").attr("data-id", data[0].u_ID);
        }
    });
    function update_mess(){
      // console.log(message);
      // console.log(messagetitle);
      if(message&&messagetitle){
        if(confirm("確認編輯留言??")){
        var ID = <?php echo $_SESSION["u_ID"];?>;
          $.ajax({
            type: "POST",
            url: "../api/update_message_api.php",
            data: {u_ID: ID, m_title: $("#messagetitle").val(), m_theme: $("#messagetheme").val(), m_message: $("#message").val(),m_id:getUrlParameter('m_id')},
            success: showupdate,
            error: function(){
              alert("update_message_api.php error");
            }
          });
        }
      }else{
        alert("不可空白");
      }
    }
    function showupdate(data){
      if (data == 1) {
        location.href = "message_board.php";
      }else{
        alert(data);
      }
    }

    function delete_mess(){
      if(confirm("確認刪除留言??")){
        $.ajax({
          type: "POST",
          url: "../api/delete_mess_api.php",
          data: {m_id:getUrlParameter('m_id')},
          success: showdelete,
          error: function(){
              alert("delete_mess_api.php error");
          }
        });
      }
    }
    function showdelete(data){
      alert(data);
      location.href = "message_board.php";
    }

    function cancel(){
        location.href = "message_board.php";
    }
  </script>
</body>
</html>
