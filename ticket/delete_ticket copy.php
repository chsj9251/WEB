<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ticket'])) {
    $ticket_no = $_POST['ticket_no'];
    
    // 티켓 정보 조회
    $sql_select = "SELECT * FROM ticket WHERE ticket_no = $ticket_no";
    $result_select = $conn->query($sql_select);
    
    if ($result_select->num_rows > 0) {
        $row_select = $result_select->fetch_assoc();
        $ticket_qr = $row_select['ticket_qr'];
        
        // 티켓 레코드 삭제
        $sql_delete = "DELETE FROM ticket WHERE ticket_no = $ticket_no";
        if ($conn->query($sql_delete) === TRUE) {
            // QR 코드 파일 삭제
            if (file_exists($ticket_qr)) {
                unlink($ticket_qr); // 파일 삭제
            }
            echo "<script>alert('티켓이 성공적으로 삭제되었습니다.');
                  window.location.replace('index.php');
                  </script>";
            exit; // 리디렉션 후 스크립트 실행 중지
        } else {
            echo "Error: " . $sql_delete . "<br>" . $conn->error;
        }
    } else {
        echo "해당하는 티켓이 존재하지 않습니다.";
    }
}
?>
