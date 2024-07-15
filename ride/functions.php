<?php
include "../db_conn.php";

// 모든 놀이기구 정보를 가져오는 함수
function getAllTargets() {
    global $conn;
    $sql = "SELECT target_no, target_name, manager_code FROM target";
    $result = $conn->query($sql);
    $targets = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $targets[] = $row;
        }
    }
    return $targets;
}
?>
