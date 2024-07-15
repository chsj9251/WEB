<?php
// 데이터베이스 연결 파일 포함
include "../db_conn.php";

// 데이터베이스에서 로봇의 현재 위치 가져오기 (예시로 MySQL 사용)
$sql = "SELECT robot_x, robot_y FROM robot ORDER BY roboy_key DESC LIMIT 1"; // 가장 최근의 위치를 가져옴
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 결과에서 데이터를 가져옴
    $row = $result->fetch_assoc();
    $robot_x = $row["robot_x"];
    $robot_y = $row["robot_y"];
    
    // JSON 형식으로 반환
    header('Content-Type: application/json');
    echo json_encode(array('robot_x' => $robot_x, 'robot_y' => $robot_y));
} else {
    // 결과가 없을 경우 에러 처리
    echo "No robot location found";
}

// 데이터베이스 연결 종료
$conn->close();
?>
