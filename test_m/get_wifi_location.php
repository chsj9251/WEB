<?php
include "db_conn.php";

// POST로 전달된 Wi-Fi MAC 주소 가져오기
$wifi_mac = isset($_POST['wifi_mac']) ? $_POST['wifi_mac'] : '';

if (empty($wifi_mac)) {
    $response = array(
        'error' => 'Wi-Fi MAC 주소가 전달되지 않았습니다.'
    );
    echo json_encode($response);
    exit;
}

// Wi-Fi MAC 주소를 기반으로 위치 데이터 조회 (예시로 데이터베이스에서 조회)
$sql = "SELECT latitude, longitude FROM wifi_locations WHERE wifi_mac = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $wifi_mac);
$stmt->execute();
$stmt->store_result();

// 조회 결과 바인딩
$stmt->bind_result($latitude, $longitude);

// 위치 정보 추출
if ($stmt->fetch()) {
    // 조회된 위치 정보를 JSON 형식으로 반환
    $response = array(
        'latitude' => $latitude,
        'longitude' => $longitude
    );
} else {
    $response = array(
        'error' => '해당 Wi-Fi MAC 주소에 대한 위치 정보를 찾을 수 없습니다.'
    );
}

// 결과 출력
echo json_encode($response);

// 데이터베이스 연결 및 문 종료
$stmt->close();
$conn->close();
?>
