<?php
// DB 연결 정보
// AWS EC2 MariaDB
$servername = "13.124.83.151";
$username = "rpm";
$password = "11223344";
$dbname = "rpm";

// 로컬 DB
// $servername = "39.120.22.103";
// $username = "rpm";
// $password = "19991215";
// $dbname = "rpm";

// DB 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
die("DB 연결 실패: " . $conn->connect_error);
}
?>