<?php
// 데이터베이스 연결 포함
include '../db_conn.php';

// SQL 쿼리 생성
$sql = "UPDATE detections SET class_name='none' WHERE detections_no='1'";

// 쿼리 실행 및 결과 확인
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

// 데이터베이스 연결 닫기
$conn->close();
?>
