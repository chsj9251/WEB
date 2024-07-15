<?php
// ROS에서 로봇 좌표를 가져오는 코드
$robot_x = 10.5;  // 예시로 로봇의 x 좌표
$robot_y = 20.3;  // 예시로 로봇의 y 좌표

// 맵 이미지의 파일 경로 (예시)
$map_image_path = "testmap.jpg";

// 오프셋 계산
$offset_x = $robot_x - $map_offset_x;  // 적절한 맵 오프셋 x 값 설정
$offset_y = $robot_y - $map_offset_y;  // 적절한 맵 오프셋 y 값 설정
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>로봇 위치 모니터링</title>
  <style>
    /* 필요한 CSS 스타일 작성 */
  </style>
  <script>
    // 로봇 위치 표시를 위한 JavaScript 코드
    function updateRobotPosition(offsetX, offsetY) {
      // 맵 이미지 로드 후 offset을 적용하여 로봇 위치 표시
      var mapImage = document.getElementById('map');
      var marker = document.createElement('div');
      marker.className = 'robot-marker';
      marker.style.left = offsetX + 'px';
      marker.style.top = offsetY + 'px';
      mapImage.appendChild(marker);
    }
    
    // 페이지 로드 시 로봇 위치 업데이트
    window.onload = function() {
      updateRobotPosition(<?php echo $offset_x; ?>, <?php echo $offset_y; ?>);
    };
  </script>
</head>
<body>
  <div>
    <h1>로봇 위치 모니터링</h1>
    <img id="map" src="<?php echo $map_image_path; ?>" alt="맵 이미지">
  </div>
</body>
</html>
