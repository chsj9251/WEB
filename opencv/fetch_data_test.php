<?php
// 데이터베이스 연결 파일 포함
include "../db_conn.php";

// 데이터베이스에서 로봇 위치 정보를 모두 가져오는 쿼리
$sql = "SELECT * FROM detections";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 결과를 표 형식으로 출력
    echo "<table border='1'>";
    echo "<tr><th>객체</th><th>정확도</th><th>다른 컬럼1</th><th>다른 컬럼2</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["class_name"] . "</td>";
        echo "<td>" . round($row["confidence"] * 100) . "%</td>";
        echo "<td>" . $row["other_column1"] . "</td>";
        echo "<td>" . $row["other_column2"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "객체인식 정보가 없습니다.";
}

// 데이터베이스 연결 닫기
$conn->close();
?>
