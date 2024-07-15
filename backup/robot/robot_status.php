<?php
header('Content-Type: text/html; charset=utf-8');
include "../db_conn.php";

$sql = "SELECT robot_x, robot_y, robot_status FROM robot WHERE robot_no = 1";
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

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);

$conn->close();
?>