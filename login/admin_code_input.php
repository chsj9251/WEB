<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 관리자 코드 검증 과정
    $admin_code = $_POST['admin_code']; // 입력된 관리자 코드

    // 여기서 관리자 코드를 데이터베이스와 비교하거나 하드코딩된 코드와 비교합니다.
    // 실제로는 데이터베이스에 저장된 코드와 비교하는 것이 안전합니다.
    $valid_admin_code = '11223344'; // 실제 코드는 데이터베이스에 저장하고, 여기서는 예시로 하드코딩 했습니다.

    if ($admin_code === $valid_admin_code) {
        // 관리자 코드가 일치할 경우 세션에 총관리자 권한 부여
        $_SESSION['role'] = '총관리자';
        // 세션 업데이트 후 메인 페이지로 리다이렉트
        header('Location: /ride/admin_page.php');
        exit;
    } else {
        // 관리자 코드가 일치하지 않을 경우 메시지 출력
        $error_message = "올바른 관리자 코드를 입력해주세요.";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>관리자 코드 입력</title>
    <link rel="stylesheet" href="/styles_common.css"> <!-- 필요한 경우 스타일 시트 링크 추가 -->
</head>
<body>
    <div class="container">
        <h2>관리자 코드 입력</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="admin_code">관리자 코드:</label>
                <input type="text" id="admin_code" name="admin_code" required>
            </div>
            <?php if (isset($error_message)) : ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <div class="form-group">
                <input type="submit" value="확인">
            </div>
        </form>
    </div>
</body>
</html>
