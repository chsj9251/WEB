<?php
session_start();
include "/db_conn.php"; // 데이터베이스 연결 파일 경로에 따라 수정 필요

// 게시글 키를 받아옴
if (isset($_GET['id'])) {
    $target_no = $_GET['id'];

    // 게시글 삭제 쿼리
    $delete_sql = "DELETE FROM target WHERE target_no = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $target_no);

    if ($stmt->execute()) {
        echo '<script>alert("놀이기구가 성공적으로 삭제되었습니다.");</script>';
        echo '<script>window.location.href = "/ride/index.php";</script>';
        exit();
    } else {
        echo "놀이기구 삭제 중 오류가 발생했습니다.";
    }
} else {
    echo "놀이기구 ID가 전달되지 않았습니다.";
    exit();
}
?>

<?php
// 연결 종료
$conn->close();
?>
