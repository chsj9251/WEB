<?php
session_start();
include "../db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manager_id = $_POST['manager_id'];
    $manager_pw = $_POST['manager_pw'];
    $admin_code = $_POST['admin_code'];

    // Prepared Statement 사용
    $sql = "SELECT manager_no, manager_id, manager_name, manager_pw, role FROM manager WHERE manager_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $manager_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['manager_pw'];

        // 비밀번호 검증
        if (password_verify($manager_pw, $hashed_password)) {
            // 관리자 코드 검증
            if ($admin_code === '11223344') {
                $role = '총관리자';
            } elseif (!empty($admin_code)) {
                // 놀이기구 관리자 코드 검증
                $sql = "SELECT * FROM target WHERE manager_code = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $admin_code);
                $stmt->execute();
                $targetResult = $stmt->get_result();
                if ($targetResult && $targetResult->num_rows > 0) {
                    $target = $targetResult->fetch_assoc();
                    $role = '놀이기구관리자';
                    $target_no = $target['target_no'];
                } else {
                    echo "<script>alert('잘못된 관리자 코드입니다.'); window.location.href = '/index.html';</script>";
                    exit;
                }
            } else {
                $role = '직원';
            }

            // 세션에 사용자 정보 저장
            $_SESSION['loggedin'] = true;
            $_SESSION['manager_id'] = $row['manager_id'];
            $_SESSION['manager_name'] = $row['manager_name'];
            $_SESSION['role'] = $role;
            if (isset($target_no)) {
                $_SESSION['target_no'] = $target_no;
            }

            // 데이터베이스 역할(role) 업데이트
            $update_sql = "UPDATE manager SET role = ? WHERE manager_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $role, $manager_id);
            $update_stmt->execute();

            // 로그인 후 메인 페이지로 리다이렉션
            header('Location: main_page.php');
            exit;
        } else {
            echo "<script>alert('비밀번호가 일치하지 않습니다.'); window.location.href = '/index.html';</script>";
        }
    } else {
        echo "<script>alert('등록되지 않은 ID입니다.'); window.location.href = '/index.html';</script>";
    }
    $stmt->close();
    $conn->close();
}
?>
