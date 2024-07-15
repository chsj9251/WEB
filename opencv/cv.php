<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cv test</title>
    <link rel="stylesheet" href="styles_cv_test.css">
    <link rel="stylesheet" href="/styles_back.css">
</head>
<body>
    <div class="container">
        <div class="header-wrapper">
            <div class="header">
                <h1>cv test</h1>
            </div>
        </div>

        <div class="back-button">
            <img src="./icon/back.png" alt="뒤로가기" onclick="history.back()">
        </div>
        <div class="data-table">
                <iframe src="./cv_data.php" style="width: 400px; height: 150px; border: none;"></iframe>
        </div>
        <div class="main-content">
            <!-- 카메라 이미지 표시 -->
            <!-- <iframe src="./camera.html" style="width: 400px; height: 300px; border: none;"></iframe> -->
            <!-- <iframe src="./camera_cv.html" style="width: 400px; height: 300px; border: none;"></iframe> -->
            <iframe src="./camera_pi.html" style="width: 400px; height: 300px; border: none;"></iframe>
        </div>
    </div>
</body>
</html>
