<?php
// DB 연결 정보
include "../db_conn.php";

// 게시글 목록 조회 쿼리
$sql = "SELECT * FROM board ORDER BY created_date DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>게시글 리스트</title>
  <link rel="stylesheet" href="/styles_back.css">
  <link rel="stylesheet" href="/login/styles_login.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      height: 100vh;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
      padding: 0;
      background-color: #f0f0f0;
    }
    .container {
      width: 90%;
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
      font-size: 24px;
      margin-bottom: 5px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #dddddd;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="login-link">
      <?php
      session_start();
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
          echo '<p>' . $_SESSION['manager_name'] . '님 (' . $_SESSION['role'] . ') 
          <a href="/login/logout.php"><img src="/login/icon/logout_icon.png" alt="로그아웃"></a> 
          <a href="/login/user_update.php"><img src="/login/icon/update_user.png" alt="회원정보 수정"></a>
          </p>';
      } else {
          echo '<a href="/index.html"><img src="./icon/login_icon.png" alt="로그인"></a>';
      }
      ?>
    </div>
    <h2>게시글 리스트</h2>
    <?php
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>제목</th><th>내용</th><th>작성자</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['board_title'] . '</td>';
            echo '<td>' . $row['board_content'] . '</td>';
            echo '<td>' . $row['board_author'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>게시글이 없습니다.</p>';
    }
    ?>

  </div>
</body>
</html>

<?php
// 연결 종료
$conn->close();
?>
