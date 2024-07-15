<?php
session_start();
include "../db_conn.php"; // 데이터베이스 연결 파일 경로에 따라 수정 필요

// 게시글 상세 조회 쿼리
if (isset($_GET['id'])) {
    $board_no = $_GET['id'];
    $sql = "SELECT * FROM board WHERE board_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $board_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
} else {
    echo "잘못된 접근입니다.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title><?php echo $post['board_title']; ?></title>
  <link rel="stylesheet" href="/styles_home.css">
  <link rel="stylesheet" href="styles_posts.css">
  <link rel="stylesheet" href="/login/styles_login.css">
  <link rel="stylesheet" href="/styles_back.css">
  <link rel="stylesheet" href="styles_view_post.css">
  <link rel="stylesheet" href="/menu/styles_menu.css">
  <script src="/menu/scripts.js"></script>
</head>
<body>
  <div class="container">
    <div class="back-button">
      <img src="./icon/back.png" alt="뒤로가기" onclick="history.back()">
    </div>
    <h2><?php echo $post['board_title']; ?></h2>
    <div class="post-info">
      <p>작성자: <?php echo $post['board_author']; ?></p>
      <p>작성 시간: <?php echo $post['created_date']; ?></p>
      <p>수정 시간: <?php echo $post['updated_date']; ?></p>
    </div>
    <div class="post-content">
      <p><?php echo nl2br($post['board_content']); ?></p>
    </div>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['manager_name'] == $post['board_author']) {
        echo '<div class="edit-button">';
        echo "<a href='edit_post.php?id=" . $post["board_no"] . "'>수정</a>";
        echo '</div>';
    }
    ?>
  </div>
</body>
</html>

<?php
// 연결 종료
$conn->close();
?>
