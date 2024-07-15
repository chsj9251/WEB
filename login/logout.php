<?php
session_start(); // 세션 시작

include "../db_conn.php"; // 데이터베이스 연결 설정

// 세션에 저장된 ID을 가져옴
if (isset($_SESSION['manager_id'])) {
    $manager_id = $_SESSION['manager_id'];

    // 데이터베이스에서 사용자의 role을 '직원'으로 업데이트
    $logoutSql = "UPDATE manager SET role='직원' WHERE manager_id='$manager_id'";

    if ($conn->query($logoutSql) === TRUE) {
        // 업데이트 성공 시
        // 세션에 저장된 사용자 정보 삭제
        unset($_SESSION['loggedin']);
        unset($_SESSION['manager_id']);
        unset($_SESSION['manager_name']);
        unset($_SESSION['role']);

        // 세션 파기
        session_destroy();

        // 로그아웃 후 메인 페이지로 리다이렉트 또는 다른 처리
        header('Location: /index.html');
        exit;
    } else {
        // 업데이트 실패 시 처리
        echo "<script>alert('로그아웃 실패'); window.location.href = '/index.html';</script>";
        exit;
    }
} else {
    // 세션에 ID이 없는 경우 처리
    echo "<script>alert('세션에 사용자 정보가 없습니다.'); window.location.href = '/index.html';</script>";
    exit;
}
?>
