<?php
session_start();
include "../db_conn.php"; // 데이터베이스 연결 파일 경로에 따라 수정 필요

// POST 데이터 가져오기
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $board_title = $_POST['board_title'];
    $board_content = $_POST['board_content'];
    $manager_no = $_SESSION['manager_no']; // 현재 로그인한 관리자의 manager_no 사용

    // SQL 쿼리 작성
    $sql = "INSERT INTO board (manager_no, board_title, board_content, board_author) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $manager_no, $board_title, $board_content, $_SESSION['manager_name']);

    // 쿼리 실행
    if ($stmt->execute()) {
        echo "<script>alert('게시글이 성공적으로 작성되었습니다.'); window.location.href = './posts.php';</script>";
    } else {
        echo "<script>alert('게시글 작성 중 오류가 발생했습니다.'); window.location.href = './write_post.php';</script>";
    }

    // 연결 종료
    $stmt->close();
}

$conn->close();
?>
