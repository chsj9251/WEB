<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>게시글 작성</title>
  <link rel="stylesheet" href="styles_write_post.css">
  <link rel="stylesheet" href="/styles_back.css">
  <link rel="stylesheet" href="/login/styles_login.css">
  <link rel="stylesheet" href="/menu/styles_menu.css">
  <script src="/menu/scripts.js"></script>
</head>
<body>
  <div class="container">
    <h2>게시글 작성</h2>
    <div class="back-button">
      <img src="./icon/back.png" alt="뒤로가기" onclick="history.back()">
    </div>
    <div class="write-form">
      <form action="process_post.php" method="post">
        <label for="board_title">제목:</label><br>
        <input type="text" id="board_title" name="board_title" required><br>
        <label for="board_content">내용:</label><br>
        <textarea id="board_content" name="board_content" rows="5" required></textarea><br>
        <input type="submit" value="게시글 작성">
      </form>
    </div>
  </div>
</body>
</html>
