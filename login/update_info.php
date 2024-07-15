<?php
session_start();
include "../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manager_id = $_SESSION['manager_id'];
    $manager_name = $_POST['manager_name'];
    $manager_email = $_POST['manager_email'];
    $manager_number = $_POST['manager_number'];
    $manager_pw = $_POST['manager_pw'];
    $manager_pw_confirm = $_POST['manager_pw_confirm'];

    // 비밀번호 확인
    if ($manager_pw !== "" && $manager_pw !== $manager_pw_confirm) {
        echo "<script>alert('비밀번호가 일치하지 않습니다.'); window.location.href = 'update_info.php';</script>";
        exit;
    }

    // 기본 정보 업데이트
    $sql = "UPDATE manager SET manager_name=?, manager_email=?, manager_number=? WHERE manager_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $manager_name, $manager_email, $manager_number, $manager_id);

    if ($stmt->execute()) {
        // 비밀번호 업데이트
        if ($manager_pw !== "") {
            $hashed_password = password_hash($manager_pw, PASSWORD_DEFAULT);
            $pw_sql = "UPDATE manager SET manager_pw=? WHERE manager_id=?";
            $pw_stmt = $conn->prepare($pw_sql);
            $pw_stmt->bind_param("ss", $hashed_password, $manager_id);
            $pw_stmt->execute();
            $pw_stmt->close();
        }

        echo "<script>alert('정보가 성공적으로 수정되었습니다.'); window.location.href = 'main_page.php';</script>";
        exit;
    } else {
        echo "<script>alert('정보 수정 실패'); window.location.href = 'update_info.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
