<?php
// 데이터베이스 연결 설정
$servername = "192.168.45.118";
$username = "rpm";
$password = "11223344";
$dbname = "rpm";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 로봇 상태를 체크하는 쿼리
$sql = "UPDATE robot SET status = 'offline' WHERE TIMESTAMPDIFF(SECOND, update_date, NOW()) > 10";
$conn->query($sql);

// 데이터베이스 연결 닫기
$conn->close();