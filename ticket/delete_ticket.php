<?php
// db_conn.php를 include하여 데이터베이스 연결 설정을 가져옴
include "../db_conn.php";

// POST로 전달된 티켓 번호 받기
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticket_no'])) {
    $ticket_no = $_POST['ticket_no'];

    // 티켓 삭제 SQL 쿼리
    $delete_query = "DELETE FROM ticket WHERE ticket_no = $ticket_no";

    if ($conn->query($delete_query) === TRUE) {
        // 삭제 성공 시 처리할 내용
        echo "<script>alert('티켓이 성공적으로 삭제되었습니다.');
                window.location.replace('qr_page_code.php');
                </script>";
    } else {
        // 삭제 실패 시 처리할 내용
        echo "<script>alert('삭제 중 오류가 발생하였습니다.');
                window.location.replace('qr_page_code.php');
                </script>";
    }
}

// 데이터베이스 연결 종료
$conn->close();
?>
