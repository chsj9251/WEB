<?php
include "../auth/auth_check.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>놀이공원 관리 시스템</title>
    <link rel="stylesheet" href="/ride/styles_update.css">
    <link rel="stylesheet" href="/styles_back.css">
    <link rel="stylesheet" href="/menu/styles_menu.css">
    <script src="/menu/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/modal.js"></script>
<script>
    $(document).ready(function() {
        // 데이터 로드
        function loadTable() {
            $.ajax({
                url: 'target_get.php',
                type: 'GET',
                success: function(data) {
                    $('#target-table').html(data);
                },
                error: function() {
                    alert('데이터를 가져오는 데 실패했습니다.');
                }
            });
        }

        loadTable();

        // 추가 버튼 클릭 이벤트
        $('#add-button').click(function(){
            $('.edit-form').hide();
            $('.add-form').show();
        });

        // 추가 폼 제출 이벤트
        $('#add-form').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: '/ride/target_add.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert('놀이기구가 추가되었습니다.');
                    loadTable();
                    $('.add-form').hide();
                    window.location.replace('/ride/index.php'); // 다른 페이지로 이동
                },
                error: function() {
                    alert('놀이기구 추가에 실패했습니다.');
                }
            });
        });
    });
</script>
</head>
<body>
    <div class="container">
        <div class="right-panel">
        <h2>놀이기구 추가</h2>
        <div class="back-button">
            <img src="/ride/icon/back.png" alt="뒤로가기" onclick="history.back()">
        </div>
        <form id="add-form" class="add-form">
                <div class="form-group">
                    <div class="input-row">
                        <label for="add_target_name">놀이기구 이름:</label>
                        <input type="text" id="add_target_name" name="target_name" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_wait_time">대기 시간 (분):</label>
                        <input type="number" id="add_wait_time" name="target_wait_time" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_open_time">개장 시간:</label>
                        <input type="text" id="add_open_time" name="target_open_time" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_close_time">폐장 시간:</label>
                        <input type="text" id="add_close_time" name="target_close_time" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_min_height">최소 키 제한 (cm):</label>
                        <input type="number" id="add_min_height" name="target_min_height" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_max_height">최대 키 제한 (cm):</label>
                        <input type="number" id="add_max_height" name="target_max_height" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_target_x">X 좌표:</label>
                        <input type="number" step="0.0001" id="add_target_x" name="target_x" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_target_y">Y 좌표:</label>
                        <input type="number" step="0.0001" id="add_target_y" name="target_y" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_target_z">Z 값:</label>
                        <input type="number" step="0.0001" id="add_target_z" name="target_z" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_target_w">W 값:</label>
                        <input type="number" step="0.0001" id="add_target_w" name="target_w" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_target_status">상태:</label>
                        <select type="status" id="add_target_status" name="target_status" required>
                            <option value="Open">Open</option>
                            <option value="Close">Close</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_target_utilization">이용 정보:</label>
                        <textarea type="textarea" id="add_target_utilization" name="target_utilization" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <label for="add_target_precautions">주의 사항:</label>
                        <textarea type="textarea" id="add_target_precautions" name="target_precautions" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-row">
                        <input type="submit" value="추가">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
