<?php
include "../auth_check.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/styles_home.css">
    <link rel="stylesheet" href="styles_monitoring.css">
    <script src="../modal.js"></script>
    <title>메인 화면</title>
</head>
<body>
    <!-- index.php 파일 불러오기 -->
    <div class="container">
        <div class="header-wrapper">
            <div class="header">
                <h1>로봇 위치 관제 시스템</h1>
            </div>
        </div>
        <div class="home-button">
            <img src="./icon/home.png" alt="메인화면" onclick="location.href='/login/main_page.php'">
        </div>
        <div class="status">
            <p>상태: <span id="status-text"></span><div id="status-indicator" class="status-indicator"></div></p>
        </div>
        <?php include 'map.php'; ?>
    </div>
</body>
</html>
