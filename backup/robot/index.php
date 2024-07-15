<?php
include "../auth_check.php"; // 인증 체크 파일 include 예시
include "../db_conn.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>로봇 위치 관제 시스템</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_monitoring.css">
    <link rel="stylesheet" href="/styles_back.css">
    <style>
        .map-container {
            position: relative;
            width: 600px; /* 맵 이미지 너비에 맞게 조정 */
            height: 476px; /* 맵 이미지 높이에 맞게 조정 */
            background-image: url('rpm_map.jpg'); /* 맵 이미지 경로 설정 */
            background-size: contain;
            background-repeat: no-repeat;
        }
        .robot {
            position: absolute;
            width: 10px; /* 로봇 아이콘 너비 */
            height: 10px; /* 로봇 아이콘 높이 */
            border-radius: 50%; /* 원형 모양 */
        }
        .status {
            margin-top: 10px;
        }
        .status-indicator {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 5px;
            vertical-align: middle;
        }
        .status-text {
            vertical-align: middle;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            function updateRobotPosition() {
                $.ajax({
                    url: "robot_status.php",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data.success) {
                            let robot = data.robot;
                            let color = robot.robot_status == "Online" ? "green" : "gray";
                            let initialX = 465; // 초기 x 위치
                            let initialY = 425; // 초기 y 위치
                            let speedx = 24.4;
                            let speedy = 24.4;
                            let x = initialX + robot.robot_x * speedx;
                            let y = initialY - robot.robot_y * speedy;
                            $("#robot_position").html(
                                `<div class='robot' style='left: ${x}px; top: ${y}px; background-color: ${color};'></div>`
                            );
                            $("#status-text").text(robot.robot_status);
                            $("#status-indicator").css("background-color", color);
                        } else {
                            $("#robot_position").html("로봇 위치 정보가 없습니다.");
                        }
                    }
                });
            }

            // 1초마다 로봇 위치를 업데이트
            setInterval(updateRobotPosition, 100);
            updateRobotPosition();
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="header-wrapper">
            <div class="header">
                <h1>로봇 위치 관제 시스템</h1>
            </div>
        </div>
        <div class="back-button">
            <img src="./icon/back.png" alt="뒤로가기" onclick="history.back()">
        </div>
        <div class="status">
            <p>상태: <span id="status-text"></span><div id="status-indicator" class="status-indicator"></div></p>
        </div>
        <div class="map-wrapper">
            <div class="map-container" id="robot_position"></div>
        </div>
    </div>
</body>
</html>

<?php
// 데이터베이스 연결 종료
$conn->close();
?>
