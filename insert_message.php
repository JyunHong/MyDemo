<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>新增留言</title>
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
    <form action="../api/insertmessage_api.php" method="POST">
      <div class="form-group">
        <label for="messagetitle">標題</label>
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
        <input type="submit" class="btn btn-outline-primary" id="submit">
      </div>
    </form>  
  </div>

  <script src="../js/bootstrap.min.js"></script> 
</body>
</html>
