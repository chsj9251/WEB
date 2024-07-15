<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>로봇 위치 메인 페이지</title>
    <style>
        /* 맵 이미지 스타일링 */
        .map-container {
            position: relative;
            width: 100%; /* 반응형 디자인을 위해 너비를 100%로 설정 */
            max-width: 800px; /* 맵 이미지의 실제 너비에 맞게 설정 */
            height: auto;
        }

        .map-image {
            width: 100%; /* 반응형 디자인을 위해 너비를 100%로 설정 */
            height: auto;
            display: block;
        }

        /* 로봇 마커 스타일링 */
        .robot-marker {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: green;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            left: 569px; /* 예시로 설정한 좌표를 픽셀 단위로 지정 */
            top: 586px; /* 예시로 설정한 좌표를 픽셀 단위로 지정 */
        }

        @media (max-width: 768px) {
        .robot-marker {
            width: 6px;
            height: 6px;
        }
    }
    </style>
</head>
<body>
    <div class="map-container">
        <img src="../testmap2.jpg" alt="Map Image" class="map-image">
        <div class="robot-marker" id="robot-marker"></div>
    </div>
    <script>
        function updateRobotPosition() {
            fetch('robot_position.php')
                .then(response => response.json())
                .then(data => {
                    const robotMarker = document.getElementById('robot-marker');
                    const mapWidth = 800;  // 맵 이미지의 너비
                    const mapHeight = 635;  // 맵 이미지의 높이
                    const positionLeft = (data.x / mapWidth) * 100;
                    const positionTop = (data.y / mapHeight) * 100;

                    robotMarker.style.left = positionLeft + '%';
                    robotMarker.style.top = positionTop + '%';
                })
                .catch(error => console.error('Error fetching robot position:', error));
        }

        setInterval(updateRobotPosition, 1000); // 1초마다 좌표 업데이트
        updateRobotPosition(); // 초기 위치 설정
    </script>
</body>
</html>
