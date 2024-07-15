<?php
// 데이터베이스 연결 파일 포함
include "../db_conn.php";

// 데이터베이스에서 로봇 위치 정보를 가져오는 쿼리
$sql = "SELECT class_name, ROUND(confidence * 100, 1) AS confidence_percent FROM detections WHERE detections_no = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 결과를 표 형식으로 출력
    echo "<table border='1'>";
    echo "<tr><th>객체</th><th>정확도 (%)</th></tr>";
    while($row = $result->fetch_assoc()) {
        // confidence_percent 값을 소수점 첫 번째 자리까지 포맷팅
        $formatted_percent = number_format($row["confidence_percent"], 1);
        echo "<tr><td>" . $row["class_name"]. "</td><td>" . $formatted_percent . "%</td></tr>";
    }
    echo "</table>";
} else {
    echo "객체인식 정보가 없습니다.";
}

// 데이터베이스 연결 닫기
$conn->close();
?>
