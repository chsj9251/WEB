<?php
session_start();
include "../db_conn.php";

// POST 데이터 가져오기
$target_no = $_POST['target_no'];
$target_name = $_POST['target_name'];
$wait_time = $_POST['target_wait_time'];
$open_time = $_POST['target_open_time'];
$close_time = $_POST['target_close_time'];
$min_height = $_POST['target_min_height'];
$max_height = $_POST['target_max_height'];
$target_x = $_POST['target_x'];
$target_y = $_POST['target_y'];
$target_z = $_POST['target_z'];
$target_w = $_POST['target_w'];
$target_status = $_POST['target_status'];
$target_utilization = $_POST['target_utilization'];
$target_precautions = $_POST['target_precautions'];

// 권한 확인
if ($_SESSION['role'] !== '총관리자' && $_SESSION['target_no'] != $target_no) {
    echo "권한이 부족하여 수정할 수 없습니다.";
    exit;
}

// 데이터 업데이트 쿼리
$sql = "UPDATE target SET 
        target_name='$target_name', 
        target_wait_time='$wait_time', 
        target_open_time='$open_time', 
        target_close_time='$close_time', 
        target_min_height='$min_height', 
        target_max_height='$max_height', 
        target_x='$target_x', 
        target_y='$target_y', 
        target_z='$target_z', 
        target_w='$target_w', 
        target_status='$target_status', 
        target_utilization='$target_utilization', 
        target_precautions='$target_precautions' 
        WHERE target_no='$target_no'";

if ($conn->query($sql) === TRUE) {
    echo "놀이기구 정보가 성공적으로 업데이트되었습니다.";
} else {
    echo "오류: " . $sql . "<br>" . $conn->error;
}

// 데이터베이스 연결 종료
$conn->close();
?>
