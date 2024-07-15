<!DOCTYPE html>
<html>
<head>
    <title>로봇 위치 관제 시스템</title>
    <style>
        .map-container {
            position: relative;
            width: 200px;
            height: 150px;
            border: 1px solid black;
            background-image: url('map_image.jpg'); /* 배경 이미지 설정 */
            background-size: cover; /* 배경 이미지를 요소에 맞추어 출력 */
        }
        .robot {
            position: absolute;
            width: 5px;
            height: 5px;
            background-color: green;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <h1>로봇 위치 관제 시스템</h1>
    <div class="map-container">
        <?php
        // 데이터베이스 연결 설정
		$servername = "192.168.45.118";
		$username = "rpm";
		$password = "11223344";
		$dbname = "rpm";

        // 데이터베이스 연결
        $conn = new mysqli($servername, $username, $password, $dbname);

        // 연결 확인
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // 데이터베이스에서 로봇 위치 정보를 가져오는 쿼리
        $sql = "SELECT current_x, current_y FROM robot WHERE robot_id = 1";
        $result = $conn->query($sql);
		
		// 초기 위치 설정

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // 로봇의 좌표를 점으로 표시
                $x = 20 + $row["current_x"] * 50;
                $y = 130 - ($row["current_y"] * 50);
                echo "<div class='robot' style='left: ".$x."px; top: ".$y."px;'></div>";
            }
        } else {
            echo "로봇 위치 정보가 없습니다.";
        }

        // 데이터베이스 연결 닫기
        $conn->close();
        ?>
    </div>
</body>
</html>