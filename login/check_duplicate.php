<?php
include "../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $manager_id = $_POST['manager_id'];

  $sql = "SELECT manager_id FROM manager WHERE manager_no='$manager_no'";
  $result = $conn->query($sql);

  if (mysqli_num_rows($result)) {
    echo "중복된 ID입니다.<br>";
  } else {
    echo "사용 가능한 ID입니다.<br>";
  }
}
?>
