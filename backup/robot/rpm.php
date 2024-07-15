<?php
include "../db_conn.php";

// 데이터베이스에서 로봇 위치 정보를 가져오는 쿼리
$sql = "SELECT robot_x, robot_y, status FROM robot WHERE robot_no = 1";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['success'] = true;
    $response['robot'] = array(
        'robot_x' => $row['robot_x'],
        'robot_y' => $row['robot_y'],
        'robot_status' => $row['robot_status']
    );
} else {
    $response['success'] = false;
}

// JSON 형식으로 데이터 반환
header('Content-Type: application/json');
echo json_encode($response);

// 데이터베이스 연결 닫기
$conn->close();
?>