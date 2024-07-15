<?php
include "../db_conn.php";

$sql = "SELECT target_utilization FROM target";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['target_utilization'];
    }
}

$conn->close();

echo json_encode($data);
?>
