<?php
// 데이터베이스 연결 파일을 포함합니다.
include "../db_conn.php";

// JSON 형식으로 반환할 배열을 초기화합니다.
$response = array();

// target_no를 받아옵니다.
if (isset($_GET['target_no'])) {
    $targetNo = $_GET['target_no'];
    
    // 새로운 관리자 코드를 생성하는 함수를 호출합니다.
    $newCode = generateNewManagerCode();

    // 새로운 코드가 생성되었는지 확인합니다.
    if ($newCode !== false) {
        // 생성된 코드를 데이터베이스에 업데이트합니다.
        if (updateManagerCode($targetNo, $newCode)) {
            // 성공적으로 업데이트되었다면 성공 메시지를 설정합니다.
            $response['success'] = true;
        } else {
            // 업데이트 실패 시 오류 메시지를 설정합니다.
            $response['success'] = false;
            $response['error'] = "데이터베이스 업데이트 실패";
        }
    } else {
        // 코드 생성 실패 시 오류 메시지를 설정합니다.
        $response['success'] = false;
        $response['error'] = "코드 생성 실패";
    }
} else {
    // target_no가 제공되지 않은 경우에 대한 오류 처리
    $response['success'] = false;
    $response['error'] = "target_no가 제공되지 않았습니다.";
}

// JSON 형식으로 응답을 반환합니다.
header('Content-Type: application/json');
echo json_encode($response);

// 새로운 관리자 코드를 생성하는 함수
function generateNewManagerCode() {
    $newCode = mt_rand(100000, 999999); // 6자리 랜덤 숫자 생성

    return $newCode;
}

// 데이터베이스에 새로운 관리자 코드를 업데이트하는 함수
function updateManagerCode($targetNo, $newCode) {
    global $conn;

    // 데이터베이스 업데이트를 위한 SQL 쿼리를 준비합니다.
    $sql = "UPDATE target SET manager_code = ? WHERE target_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newCode, $targetNo);
    $result = $stmt->execute();
    $stmt->close();

    // 쿼리 실행 결과를 반환합니다.
    return $result;
}

// 데이터베이스 연결을 닫습니다.
$conn->close();
?>
