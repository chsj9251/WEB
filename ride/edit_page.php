<?php
session_start();

include "../db_conn.php";
include "../auth/auth_check_ride.php";

// 수정할 놀이기구 ID를 가져옵니다.
$target_no = $_GET['target_no'];

// 세션에 저장된 사용자 역할(role) 확인
$role = $_SESSION['role'];

// 해당 ID의 놀이기구 정보를 조회합니다.
$sql = "SELECT * FROM target WHERE target_no = '$target_no'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // 데이터를 변수에 저장합니다.
    $target_name = $row["target_name"];
    $wait_time = $row["target_wait_time"];
    $open_time = $row["target_open_time"];
    $close_time = $row["target_close_time"];
    $min_height = $row["target_min_height"];
    $max_height = $row["target_max_height"];
    $target_x = $row["target_x"];
    $target_y = $row["target_y"];
    $target_z = $row["target_z"];
    $target_w = $row["target_w"];
    $target_status = $row["target_status"];
    $target_utilization = $row["target_utilization"];
    $target_precautions = $row["target_precautions"];
} else {
    echo "놀이기구 정보를 찾을 수 없습니다.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>놀이기구 정보 수정</title>
    <link rel="stylesheet" href="/ride/styles_update.css">
    <link rel="stylesheet" href="/styles_back.css">
    <link rel="stylesheet" href="/menu/styles_menu.css">
    <script src="/menu/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../modal.js"></script>
    <script>
        $(document).ready(function() {
            // 수정 폼 제출 이벤트
            $('#edit-form').submit(function(event){
                event.preventDefault();
                $.ajax({
                    url: '/ride/target_update.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('놀이기구 정보가 성공적으로 수정되었습니다.');
                        // 세션에 저장된 역할(role) 가져오기
                        var role = '<?php echo $_SESSION['role']; ?>';
                        // 권한에 따라 리다이렉션 처리
                        if (role === '총관리자') {
                            window.location.replace('index.php');
                        } else {
                            window.location.replace('/login/main_page.php');
                        }
                    },
                    error: function() {
                        alert('놀이기구 정보 수정에 실패했습니다.');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="right-panel">
            <h2>놀이기구 정보 수정</h2>
            <div class="back-button">
                <img src="/ride/icon/back.png" alt="뒤로가기" onclick="history.back()">
            </div>
            <form id="edit-form" class="edit-form" method="post">
                <input type="hidden" id="edit_target_no" name="target_no" value="<?php echo $target_no; ?>">
                
                <div class="form-group">
                    <div class="input-row">
                        <label for="edit_target_name">놀이기구 이름: </label>
                        <input type="text" id="edit_target_name" name="target_name" value="<?php echo $target_name; ?>" required><br><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="edit_wait_time">대기 시간 (분):</label>
                        <input type="number" id="edit_wait_time" name="target_wait_time" value="<?php echo $wait_time; ?>" required><br><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="edit_open_time">개장 시간:</label>
                        <input type="text" id="edit_open_time" name="target_open_time" value="<?php echo $open_time; ?>" required><br><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="edit_close_time">폐장 시간:</label>
                        <input type="text" id="edit_close_time" name="target_close_time" value="<?php echo $close_time; ?>" required><br><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="edit_min_height">최소 키 제한 (cm):</label>
                        <input type="number" id="edit_min_height" name="target_min_height" value="<?php echo $min_height; ?>" required><br><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="edit_max_height">최대 키 제한 (cm):</label>
                        <input type="number" id="edit_max_height" name="target_max_height" value="<?php echo $max_height; ?>" required><br><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="edit_target_x">X 좌표:</label>
                        <input type="number" step="0.0001" id="edit_target_x" name="target_x" value="<?php echo $target_x; ?>" required><br><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="edit_target_y">Y 좌표:</label>
                        <input type="number" step="0.0001" id="edit_target_y" name="target_y" value="<?php echo $target_y; ?>" required><br><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="edit_target_z">Z 값:</label>
                        <input type="number" step="0.0001" id="edit_target_z" name="target_z" value="<?php echo $target_z; ?>" required><br><br>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="edit_target_w">W 값:</label>
                        <input type="number" step="0.0001" id="edit_target_w" name="target_w" value="<?php echo $target_w; ?>" required><br><br>
                    </div>
                </div>

                <div class="input-row">
                    <label for="edit_target_status">상태:</label>
                    <select type="status" id="edit_target_status" name="target_status" required>
                        <option value="Open" <?php if ($target_status == 'Open') echo 'selected'; ?>>Open</option>
                        <option value="Close" <?php if ($target_status == 'Close') echo 'selected'; ?>>Close</option>
                    </select><br><br>
                </div>

                <div class="input-row">
                    <label for="edit_target_utilization">이용 정보:</label>
                    <textarea type="textarea" id="edit_target_utilization" name="target_utilization" required><?php echo $target_utilization; ?></textarea><br><br>
                </div>

                <div class="input-row">
                    <label for="edit_target_precautions">주의 사항:</label>
                    <textarea type="textarea" id="edit_target_precautions" name="target_precautions" required><?php echo $target_precautions; ?></textarea><br><br>
                </div>

                <div class="input-row">
                    <input type="submit" value="정보 업데이트">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
