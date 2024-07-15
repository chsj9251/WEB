<?php
include "../db_conn.php";

$targetNo = $_GET['targetNo'];

$sql = "SELECT target_name, target_utilization, target_precautions, target_max_height, target_min_height, target_open_time, target_close_time, target_wait_time, target_status FROM target WHERE target_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $targetNo);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();

    // 키 제한 처리
    if ($data['target_min_height'] == 0 && $data['target_max_height'] == 0) {
        $height_limit = '제한없음';
    } else {
        $height_limit = htmlspecialchars($data['target_min_height']) . 'cm ~ ' . htmlspecialchars($data['target_max_height']) . 'cm';
    }

    // 상태 처리
    if ($data['target_status'] == 'Open') {
        $status = '운영중';
    } else if ($data['target_status'] == 'Close') {
        $status = '운영종료';
    } else {
        $status = htmlspecialchars($data['target_status']);
    }

    // 대기시간 처리
    $wait_time = htmlspecialchars($data['target_wait_time']) . '분';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['target_name']); ?> 정보</title>
    <link rel="stylesheet" href="styles_ride_info.css">

    <script>
        function goToAndroidActivity() {
            if (typeof Android !== 'undefined') {
                Android.goToAndroidActivity();
            } else {
                console.error('Android interface is not available.');
            }
        }
    </script>
</head>
<body>
    <div class="info-container">
        <h1><?php echo htmlspecialchars($data['target_name']); ?></h1>
        <div class="image-container">
            <img src="image/<?php echo htmlspecialchars($data['target_name']); ?>.png" alt="<?php echo htmlspecialchars($data['target_name']); ?> 사진">
        </div>
        <div class="content-container">
            <p><strong>이용안내:</strong><br> <?php echo nl2br(htmlspecialchars($data['target_utilization'])); ?></p>
            <p><strong>주의사항:</strong><br> <?php echo nl2br(htmlspecialchars($data['target_precautions'])); ?></p>
            <table>
                <tr>
                    <th>키 제한</th>
                    <td><?php echo $height_limit; ?></td>
                </tr>
                <tr>
                    <th>운영시간</th>
                    <td><?php echo htmlspecialchars($data['target_open_time']); ?> ~ <?php echo htmlspecialchars($data['target_close_time']); ?></td>
                </tr>
                <tr>
                    <th>대기시간</th>
                    <td><?php echo $wait_time; ?></td>
                </tr>
                <tr>
                    <th>상태</th>
                    <td><?php echo $status; ?></td>
                </tr>
            </table>
            <button onclick="goToAndroidActivity()">뒤로가기</button>
        </div>
    </div>
</body>
</html>
