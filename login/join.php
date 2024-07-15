<?php
include "../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manager_name = $_POST['manager_name'];
    $manager_id = $_POST['manager_id'];
    $manager_pw = password_hash($_POST['manager_pw'], PASSWORD_DEFAULT);
    $manager_email = $_POST['manager_email'];
    $manager_number = $_POST['manager_number'];

    // SQL 삽입 쿼리 준비
    $sql = "INSERT INTO manager (manager_name, manager_id, manager_pw, manager_email, manager_number)
            VALUES ('$manager_name', '$manager_id', '$manager_pw', '$manager_email', '$manager_number')";

    // 쿼리 실행
    if ($conn->query($sql) === TRUE) {
        // 회원가입 성공 시 알림 메시지 출력 후 홈페이지로 리다이렉션
        echo "<script>alert('회원가입 되었습니다!'); window.location.href = '/index.html';</script>";
        exit(); // 리다이렉션 후 스크립트 실행을 위해 exit() 사용
    } else {
        // 쿼리 실행 실패 시 에러 메시지 출력
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
