<?php
include "../auth_check.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>로봇 위치 관제 시스템</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_monitoring.css">
	<link rel="stylesheet" href="/styles_back.css">
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
                            let x = 463 + robot.robot_x * 24;
                            let y = 426 - robot.robot_y * 24;
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
            setInterval(updateRobotPosition, 10);
            updateRobotPosition();
        });
    </script>

    <script src="../modal.js"></script>
	
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