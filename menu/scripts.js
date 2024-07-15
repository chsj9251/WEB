document.addEventListener('DOMContentLoaded', function() {
    // Fetch and insert menu
    fetch('/menu/menu.php')  // 실제 메뉴 파일 경로로 수정 필요
        .then(response => response.text())
        .then(html => {
            document.body.insertAdjacentHTML('afterbegin', html);
        })
        .catch(error => {
            console.error('Error fetching menu:', error);
        });
});
