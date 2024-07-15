<?php
include '../db_conn.php';

$sql = "SELECT target_no, target_name FROM target";
$result = $conn->query($sql);

$targets = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $targets[] = $row;
    }
}

echo json_encode($targets);

$conn->close();
?>
