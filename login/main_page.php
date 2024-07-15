<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>RPM 로봇 관제 시스템</title>
  <link rel="stylesheet" href="styles_main.css">
  <link rel="stylesheet" href="styles_login.css">
  <link rel="stylesheet" href="styles_admin.css">
</head>
<body>
  <div class="container">
    <div class="login-link">
      <?php
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
          echo '<p>' . $_SESSION['manager_name'] . '님 (' . $_SESSION['role'] . ') 
          <a href="logout.php"><img src="./icon/logout_icon.png" alt="로그아웃"></a> 
          <a href="user_update.php"><img src="./icon/update_user.png" alt="정보 수정"></a>
          </p>';
      } else {
          echo '<a href="/index.html"><img src="./icon/login_icon.png" alt="로그인"></a>';
      }
      ?>
    </div>
    <h2>RPM Main</h2>
    <div class="button-container">
      <!-- <button onclick="location.href='/opencv/cv.php'">CV test</button>
      <button onclick="location.href='/robot/index_hardware.php'">HW test</button>
      <button onclick="location.href='/mobile'">mobile test</button> -->
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] == '직원'): ?>
        <button onclick="location.href='/posts/posts.php'">게시판</button>
      <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == '총관리자'): ?>
        <!-- <button onclick="location.href='/robot'">로봇 관제</button> -->
        <button onclick="location.href='/robot/index_simul.php'">로봇 관제</button>
        <button onclick="location.href='/ride/index.php'">놀이기구 관리</button>
        <button onclick="location.href='/posts/posts.php'">게시판</button>
        <button onclick="location.href='/ticket'">이용권 관리</button>
        <a href="/ride/admin_page.php" class="admin-button admin-button-link">놀이기구 관리자 코드 관리</a>
      <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == '놀이기구관리자'): ?>
        <button onclick="location.href='/ride/edit_page.php?target_no=<?php echo $_SESSION['target_no']; ?>'">내 놀이기구 관리</button>
        <button onclick="location.href='/posts/posts.php'">게시판</button>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
