<?php
session_start();
include "../db_conn.php"; // 데이터베이스 연결 파일 경로에 따라 수정 필요

// 게시글 키를 받아옴
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // 게시글 삭제 쿼리
    $delete_sql = "DELETE FROM board WHERE board_no = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        echo '<script>alert("게시글이 성공적으로 삭제되었습니다.");</script>';
        echo '<script>window.location.href = "posts.php";</script>';
        exit();
    } else {
        echo "게시글 삭제 중 오류가 발생했습니다.";
    }
} else {
    echo "게시글 ID가 전달되지 않았습니다.";
    exit();
}
?>

<?php
// 연결 종료
$conn->close();
?>
