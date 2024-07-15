<?php
include "../auth/auth_check_high.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>놀이기구 관리자 페이지</title>
    <link rel="stylesheet" href="/ride/styles_admin.css">
    <link rel="stylesheet" href="/styles_home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/modal.js"></script>
    <link rel="stylesheet" href="/menu/styles_menu.css">
    <script src="/menu/scripts.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="admin-title">놀이기구 관리자 페이지</h1>
        <div class="home-button">
            <a href="/login/main_page.php"><img src="/ride/icon/home.png" alt="메인메뉴"></a>
        </div>
        <div id="target-table">
            <table>
                <thead>
                    <tr>
                        <th>놀이기구 이름</th>
                        <th>관리자 코드</th>
                        <th>랜덤 코드 재생성</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../ride/functions.php'; // 위에서 작성한 함수 포함
                    
                    $targets = getAllTargets();
                    foreach ($targets as $target) {
                        echo "<tr>";
                        echo "<td>" . $target['target_name'] . "</td>";
                        echo "<td>" . $target['manager_code'] . "</td>";
                        echo "<td><button class='generate-code-button' onclick=\"generateNewCode(" . $target['target_no'] . ")\">재생성</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        function generateNewCode(targetNo) {
            if (confirm("정말로 새로운 코드를 생성하시겠습니까?")) {
                fetch('/ride/generate_code.php?target_no=' + targetNo)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('새로운 코드가 생성되었습니다.');
                            location.reload(); // 페이지 새로고침
                        } else {
                            alert('코드 생성에 실패했습니다.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }
    </script>
</body>
</html>
