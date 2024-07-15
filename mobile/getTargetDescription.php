<?php
include "../db_conn.php";

$targetNo = $_GET['targetNo']; // 요청된 targetNo를 가져옵니다.

$sql = "SELECT target_utilization FROM target WHERE target_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $targetNo);
$stmt->execute();
$stmt->bind_result($targetUtilization);
$stmt->fetch();
$stmt->close();
$conn->close();

echo json_encode(['target_utilization' => $targetUtilization]);
?>
