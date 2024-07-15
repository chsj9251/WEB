<?php
session_start();
include "../db_conn.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /index.html');
    exit;
}

$manager_id = $_SESSION['manager_id'];

// 데이터베이스에서 사용자 삭제
$sql = "DELETE FROM manager WHERE manager_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $manager_id);

if ($stmt->execute()) {
    // 성공적으로 삭제되면 세션 삭제 및 로그아웃 처리
    unset($_SESSION['loggedin']);
    unset($_SESSION['manager_id']);
    unset($_SESSION['manager_name']);
    unset($_SESSION['role']);

    session_destroy();

    echo "<script>alert('회원 탈퇴가 완료되었습니다.'); window.location.href = '/index.html';</script>";
    exit;
} else {
    echo "<script>alert('회원 탈퇴 실패'); window.location.href = '/update_info.php';</script>";
    exit;
}

$stmt->close();
$conn->close();
?>
