<?php
session_start();

// 예제에서는 하드코딩된 관리자 코드를 사용합니다.
$adminCode = "admin123"; // 실제 사용할 코드로 변경해야 합니다.

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $adminInput = $_POST["admin_code"];

    // 여기서는 간단히 하기 위해 사용자 이름과 비밀번호를 확인하는 로직을 생략합니다.
    // 실제로는 데이터베이스 조회 등을 통해 사용자를 인증합니다.

    // 관리자 코드를 확인하고 세션에 role을 설정합니다.
    if ($adminInput === $adminCode) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = '총관리자'; // 관리자 코드가 일치하면 총관리자로 설정
    } else {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = '직원'; // 관리자 코드가 일치하지 않으면 직원으로 설정
    }
}

if (isset($_GET['logout'])) {
    // 로그아웃 처리
    unset($_SESSION['loggedin']);
    unset($_SESSION['username']);
    unset($_SESSION['role']);
    session_destroy(); // 세션 파기
    header('Location: /index.html');
    exit;
}
?>
