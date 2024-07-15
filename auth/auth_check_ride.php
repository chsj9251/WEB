<?php
session_start();

function checkUserRole($role, $target_no) {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        if ($role !== '총관리자' && ($_SESSION['target_no'] != $target_no || $role !== '놀이기구관리자')) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('권한이 부족하여 접근할 수 없습니다.', '/login/main_page.php');
                    });
                  </script>";
        }
    } else {
        echo "<script>window.location.href = '/index.html';</script>";
        exit;
    }
}

// 수정할 놀이기구 ID를 가져옵니다.
$target_no = $_GET['target_no'];

// 세션에 저장된 사용자 역할(role) 확인
$role = $_SESSION['role'];

// 사용자 역할과 놀이기구 ID를 함수에 전달하여 실행
checkUserRole($role, $target_no);
?>
