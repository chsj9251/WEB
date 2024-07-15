<?php
include "/auth/auth_check_high.php";
include "../db_conn.php"; // 데이터베이스 연결 설정 포함

session_start();

// 페이지네이션 설정
$items_per_page = 3; // 한 페이지 당 보여질 항목 수
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // 현재 페이지, 기본값은 1

// 표시할 항목의 시작 인덱스 계산
$start = ($current_page - 1) * $items_per_page;

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>이용권 관리</title>
    <link rel="stylesheet" href="styles_ticket.css">
    <link rel="stylesheet" href="/styles_home.css">
    <link rel="stylesheet" href="styles_page.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../modal.js"></script>
    <link rel="stylesheet" href="/menu/styles_menu.css">
    <script src="/menu/scripts.js"></script>
</head>
<body>
    <div class="container">
        <h1>이용권 관리</h1>
        <div class="home-button">
            <a href="/login/main_page.php">
                <img src="./icon/home.png" alt="메인화면">
            </a>
        </div>
        <form method="POST" action="generate_ticket.php">
            <div class="input-row">
                <input type="submit" value="QR 생성">
            </div>
        </form>
        <br>
        <table>
            <thead>
                <tr>
                    <th>ticket_no</th>
                    <th>ticket_code</th>
                    <th>ticket_qr</th>
                    <th>delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 티켓 목록 조회
                $query = "SELECT * FROM ticket LIMIT $start, $items_per_page";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['ticket_no']}</td>";
                        echo "<td>{$row['ticket_code']}</td>";
                        echo "<td><img src='{$row['ticket_qr']}' alt='QR Code'></td>";
                        echo "<td>
                                <form method='POST' action='delete_ticket.php'>
                                    <input type='hidden' name='ticket_no' value='{$row['ticket_no']}'>
                                    <input type='submit' name='delete_ticket' value='삭제'>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>티켓이 없습니다.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- 페이지네이션 UI -->
        <div class="pagination">
            <?php
            // 전체 항목 수 계산
            $count_query = "SELECT COUNT(*) AS total FROM ticket";
            $count_result = $conn->query($count_query);
            $row_count = $count_result->fetch_assoc()['total'];

            // 전체 페이지 수 계산
            $total_pages = ceil($row_count / $items_per_page);

            // 이전 페이지 링크
            if ($current_page > 1) {
                echo "<a href='?page=".($current_page - 1)."'>이전</a>";
            }

            // 페이지 번호 링크
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $current_page) {
                    echo "<span>$i</span>";
                } else {
                    echo "<a href='?page=$i'>$i</a>";
                }
            }

            // 다음 페이지 링크
            if ($current_page < $total_pages) {
                echo "<a href='?page=".($current_page + 1)."'>다음</a>";
            }

            $conn->close(); // 데이터베이스 연결 종료
            ?>
        </div>
    </div>
</body>
</html>
