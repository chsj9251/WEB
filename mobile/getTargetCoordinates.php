<?php
include '../db_conn.php';

if (isset($_GET['targetNo'])) {
    $targetNo = $_GET['targetNo'];

    $sql = "SELECT target_x, target_y, target_z, target_w FROM target WHERE target_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $targetNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(array('error' => 'Target not found'));
    }

    $stmt->close();
} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$conn->close();
?>
