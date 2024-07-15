<?php
session_start();
include "../db_conn.php"; // 데이터베이스 연결 파일 경로에 따라 수정 필요

// 게시글 키를 받아옴
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // 해당 게시글 정보 조회 쿼리
    $sql = "SELECT * FROM board WHERE board_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $board_title = $row['board_title'];
        $board_content = $row['board_content'];
        $board_author = $row['board_author'];
    } else {
        echo "해당 게시글을 찾을 수 없습니다.";
        exit();
    }
} else {
    echo "게시글 ID가 전달되지 않았습니다.";
    exit();
}

// 게시글 수정 처리
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_post'])) {
    $new_title = $_POST['board_title'];
    $new_content = $_POST['board_content'];

    // 게시글 업데이트 쿼리
    $update_sql = "UPDATE board SET board_title = ?, board_content = ? WHERE board_no = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $new_title, $new_content, $post_id);

    if ($stmt->execute()) {
        echo '<script>alert("게시글이 성공적으로 수정되었습니다.");</script>';
        echo '<script>window.location.href = "posts.php";</script>';
        exit();
    } else {
        echo "게시글 수정 중 오류가 발생했습니다.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>게시글 수정</title>
  <link rel="stylesheet" href="styles_write_post.css">
  <link rel="stylesheet" href="/styles_back.css">
  <link rel="stylesheet" href="/login/styles_login.css">
  <link rel="stylesheet" href="/menu/styles_menu.css">
  <script src="/menu/scripts.js"></script>
</head>
<body>
  <div class="container">
    <div class="back-button">
      <img src="./icon/back.png" alt="뒤로가기" onclick="history.back()">
    </div>
    <h2>게시글 수정</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $post_id; ?>">
      <label for="board_title">제목:</label><br>
      <input type="text" id="board_title" name="board_title" value="<?php echo $board_title; ?>" required><br>
      <label for="board_content">내용:</label><br>
      <textarea id="board_content" name="board_content" rows="5" required><?php echo $board_content; ?></textarea><br>
      <input type="submit" name="update_post" value="게시글 수정">
      <a href="delete_post.php?id=<?php echo $post_id; ?>" onclick="return confirm('정말로 이 게시글을 삭제하시겠습니까?');">게시글 삭제</a>
    </form>
  </div>
</body>
</html>

<?php
// 연결 종료
$conn->close();
?>
