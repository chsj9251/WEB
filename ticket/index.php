<?php
include "../auth/auth_check.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>이용권 관리</title>
    <link rel="stylesheet" href="styles_ticket.css">
    <link rel="stylesheet" href="/styles_home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../modal.js"></script>
    <link rel="stylesheet" href="/menu/styles_menu.css">
    <script src="/menu/scripts.js"></script>
</head>
<body>
    <div class="container">
        <h1>이용권 관리</h1>
        <div class="home-button">
            <a href="/login/main_page.php"><img src="./icon/home.png" alt="메인메뉴"></a>
        </div>
        <div class="show-button">
            <button class='show-code-button' onclick="location.href='qr_page_code.php'">QR코드 열람</button>
        </div>
    </div>
    
    <script>
        function redirectToAdminPageCode() {
            window.location.href = 'index.php';
        }
    </script>
</body>
</html>
