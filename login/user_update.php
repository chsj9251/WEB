<?php
session_start();
include "../db_conn.php";

// 로그인 확인
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /index.html');
    exit;
}

// 세션에서 사용자 정보 가져오기
$manager_id = $_SESSION['manager_id'];

// 데이터베이스에서 사용자 정보 가져오기
$sql = "SELECT manager_name, manager_email, manager_number FROM manager WHERE manager_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $manager_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('사용자 정보를 불러올 수 없습니다.'); window.location.href = '/index.html';</script>";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles_login.css">
    <link rel="stylesheet" href="/styles_back.css">
    <link rel="stylesheet" href="styles_user_update.css">
    <title>정보 수정</title>
</head>
<body>
    <div class="container">
        <h2>정보 수정</h2>
        <div class="back-button">
            <img src="./icon/back.png" alt="뒤로가기" onclick="history.back()">
        </div>
        <form action="update_info.php" method="post">
            <div class="form-group">
                <div class="input-row">
                    <label for="manager_name" class="input-label">이름 :</label>
                    <input type="text" id="manager_name" name="manager_name" value="<?php echo $user['manager_name']; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-row">
                    <label for="manager_email" class="input-label">이메일 :</label>
                    <input type="text" id="manager_email" name="manager_email" value="<?php echo $user['manager_email']; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-row">
                    <label for="manager_number" class="input-label">전화번호:</label>
                    <input type="text" id="manager_number" name="manager_number" value="<?php echo $user['manager_number']; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-row">
                    <label for="manager_pw" class="input-label">새 비밀번호:</label>
                    <input type="password" id="manager_pw" name="manager_pw">
                </div>
            </div>
            <div class="form-group">
                <div class="input-row">
                    <label for="manager_pw_confirm" class="input-label">새 비밀번호 확인:</label>
                    <input type="password" id="manager_pw_confirm" name="manager_pw_confirm">
                </div>
            </div>
            <input type="submit" value="정보 수정">
            <div class="delete-link">
                <a href="/login/delete_account.php">회원탈퇴</a>
            </div>
        </form>
    </div>
</body>
</html>
