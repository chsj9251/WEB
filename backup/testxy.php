<!DOCTYPE html>
<html>
<head>
    <title>로봇 위치 관제 시스템</title>
</head>
<body>
    <h1>로봇 위치 관제 시스템</h1>
    <meta http-equiv="refresh" content="1">

    <?php
    include "../db_conn.php";

    // 데이터베이스에서 로봇 위치 정보를 가져오는 쿼리
    $sql = "SELECT robot_x, robot_y FROM robot WHERE robot_key = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 결과를 표 형식으로 출력
        echo "<table border='1'>";
        echo "<tr><th>X 좌표</th><th>Y 좌표</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["robot_x"]. "</td><td>" . $row["robot_y"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "로봇 위치 정보가 없습니다.";
    }

    // 데이터베이스 연결 닫기
    $conn->close();
    ?>
</body>
</html>