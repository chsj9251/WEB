<?php
session_start();
require '../db_conn.php';
require 'phpqrcode/qrlib.php';

function generate_unique_code($length = 8) {
    return substr(str_shuffle
    ('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 
    0, $length);
}

$fixed_url = 'http://192.168.123.17:8080/validate_code?code=';
$ticket_code = generate_unique_code();
$full_code = $fixed_url . $ticket_code;

$qrDir = 'qr_codes/';
if (!file_exists($qrDir)) {
    mkdir($qrDir);
}

if (!is_writable($qrDir)) {
    die("$qrDir is not writable");
}

$qrFilePath = $qrDir . $ticket_code . '.png';
QRcode::png($full_code, $qrFilePath);

// 티켓 정보를 데이터베이스에 저장
$stmt = $conn->prepare("INSERT INTO ticket (ticket_code, ticket_qr) VALUES (?, ?)");
$stmt->bind_param("ss", $ticket_code, $qrFilePath);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    // 새로 생성된 티켓을 포함한 표를 다시 표시하기 위해 리다이렉트
    header('Location: qr_page_code.php');
    exit;
} else {
    echo "Error: " . $stmt->error;
}
?>
