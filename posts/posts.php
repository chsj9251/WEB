<?php
session_start();
include "../db_conn.php"; // 데이터베이스 연결 파일 경로에 따라 수정 필요

// 페이지네이션 설정
$items_per_page = 5; // 한 페이지 당 보여질 게시글 수
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // 현재 페이지, 기본값은 1

// 표시할 항목의 시작 인덱스 계산
$start = ($current_page - 1) * $items_per_page;

// 게시글 목록 조회 쿼리 (페이지네이션 추가)
$sql = "SELECT * FROM board ORDER BY created_date DESC LIMIT $start, $items_per_page";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>게시판 리스트</title>
  <link rel="stylesheet" href="/styles_home.css">
  <link rel="stylesheet" href="styles_posts.css">
  <link rel="stylesheet" href="styles_page.css">
  <link rel="stylesheet" href="/login/styles_login.css">
  <link rel="stylesheet" href="/styles_add.css">
  <link rel="stylesheet" href="/menu/styles_menu.css">
  <script src="/menu/scripts.js"></script>
</head>
<body>
  <div class="container">
    <div class="login-link">
      <?php
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
          echo '<p>' . $_SESSION['manager_name'] . '님 (' . $_SESSION['role'] . ') 
          <a href="/login/logout.php"><img src="/login/icon/logout_icon.png" alt="로그아웃"></a> 
          <a href="/login/main_page.php"><img src="./icon/home.png" alt="메인메뉴"></a>
          </p>';
      } else {
          echo '<a href="/index.html"><img src="./icon/login_icon.png" alt="로그인"></a>';
      }
      ?>
    </div>
    <h2>게시판</h2>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        echo '<div class="add-button">';
        echo '<a href="write_post.php"><img src="./icon/plus.png" alt="추가"></a>';
        echo '</div>';
    }    
    ?>
    <table>
      <thead>
        <tr>
          <th>제목</th>
          <th>작성자</th>
          <th>작성 시간</th>
          <th>수정 시간</th>
          <th>수정</th>
          <th>삭제</th>
        </tr>
      </thead>
      <tbody>
          <?php
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td><a href="view_post.php?id=' . $row['board_no'] . '">' . $row['board_title'] . '</a></td>';
                  echo '<td>' . $row['board_author'] . '</td>';
                  echo '<td>' . $row['created_date'] . '</td>';
                  echo '<td>' . $row['updated_date'] . '</td>';
                  echo '<td class="edit-cell">';
                  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                      // 현재 로그인한 사용자와 게시글 작성자가 같은 경우 또는 총관리자인 경우에만 수정 가능
                      if ($_SESSION['manager_name'] == $row['board_author'] || $_SESSION['role'] == '총관리자') {
                          echo "<a href='edit_post.php?id=" . $row["board_no"] . "'><img src='./icon/edit.png' alt='수정' width='30' height='30'></a>";
                      } else {
                          echo ''; // 다른 사용자의 게시글이면 수정 버튼 없음
                      }
                  } else {
                      echo ''; // 로그인하지 않은 경우 수정 버튼 없음
                  }
                  echo '</td>';
                  echo '<td class="delete-cell">';
                  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                      // 현재 로그인한 사용자와 게시글 작성자가 같은 경우 또는 총관리자인 경우에만 삭제 가능
                      if ($_SESSION['manager_name'] == $row['board_author'] || $_SESSION['role'] == '총관리자') {
                          echo "<a href='delete_post.php?id=" . $row["board_no"] . "' onclick='return confirm(\"정말로 이 게시글을 삭제하시겠습니까?\");'><img src='./icon/delete.png' alt='삭제' width='30' height='30'></a>";
                      } else {
                          echo ''; // 다른 사용자의 게시글이면 삭제 버튼 없음
                      }
                  } else {
                      echo ''; // 로그인하지 않은 경우 삭제 버튼 없음
                  }
                  echo '</td>';
                  echo '</tr>';
              }
          } else {
              echo '<tr><td colspan="6">게시글이 없습니다.</td></tr>';
          }
          ?>
      </tbody>
    </table>

    <!-- 페이지네이션 UI -->
    <div class="pagination">
      <?php
      // 전체 게시글 수 가져오기
      $total_query = "SELECT COUNT(*) AS total FROM board";
      $total_result = $conn->query($total_query);
      $total_rows = $total_result->fetch_assoc()['total'];

      // 전체 페이지 수 계산
      $total_pages = ceil($total_rows / $items_per_page);

      // 이전 페이지 링크
      if ($current_page > 1) {
          echo "<a href='?page=" . ($current_page - 1) . "'>이전</a>";
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
          echo "<a href='?page=" . ($current_page + 1) . "'>다음</a>";
      }
      ?>
    </div>
  </div>
</body>
</html>

<?php
// 연결 종료
$conn->close();
?>
