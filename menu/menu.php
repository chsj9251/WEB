<?php
session_start();
?>

<div id="header">
    <img src="/menu/icon/icon.png" alt="Icon" id="site-icon">
    <span id="page-title">RPM 랜드 관제 시스템</span>
    <div class="menu-login-link">
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            echo '<p>' . $_SESSION['manager_name'] . '님 (' . $_SESSION['role'] . ') </p>';
        }
        ?>
    </div>
</div>

<div id="menu-container">
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == '총관리자'): ?>
        <a class="menu-item" href="/robot/index_simul.php" data-title="로봇 위치 관제 시스템">로봇 관제</a>
        <!-- <a class="menu-item" href="/robot" data-title="로봇 위치 관제 시스템">로봇 관제</a> -->
        <a class="menu-item" href="/ride/index.php" data-title="놀이기구 관리">놀이기구 관리</a>
        <a class="menu-item" href="/ticket/index.php" data-title="이용권 관리">이용권 관리</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == '놀이기구관리자'): ?>
        <a class="menu-item" href="/ride/edit_page.php?target_no=<?php echo $_SESSION['target_no']; ?>">내 놀이기구 관리</a>
    <?php endif; ?>

    <a class="menu-item" href="/posts/posts.php" data-title="게시판">게시판</a>
    <!-- Add more menu items as needed -->
</div>
