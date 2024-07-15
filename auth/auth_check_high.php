<?php
session_start();

function checkUserRole() {
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
		if ($_SESSION['role'] !== '총관리자') {
            echo "<script>window.location.href = '/login/main_page.php';</script>";
        }
    } else {
        echo "<script>window.location.href = '/login/main_page.php';</script>";
        exit;
    }
}

checkUserRole();
?>