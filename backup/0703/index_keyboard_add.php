<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로봇 위치 관제 시스템</title>
    <link rel="stylesheet" href="/robot/styles_monitoring.css">
    <link rel="stylesheet" href="/styles_home.css">
    <link rel="stylesheet" href="/menu/styles_menu.css">
    <script src="/menu/scripts.js"></script>
    <script src="../modal.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="header-wrapper">
            <div class="header">
                <h1>로봇 위치 관제 시스템</h1>
            </div>
        </div>

        <div class="home-button">
            <img src="/ride/icon/home.png" alt="메인화면" onclick="location.href='/login/main_page.php'">
        </div>
        
        <iframe src="/goal" style="width: 100%; height: 80px; border: none; margin-bottom: 20px;"></iframe>

        <div class="status_panel">
            <p>상태: <span id="status-text">Offline</span><div id="status-indicator" class="status-indicator" style="background-color: gray;"></div></p>
        </div>
        <div class="main-content">
            <div class="left-panel">
                <!-- 맵 컨테이너 -->
                <div class="map-container">
                    <canvas id="mapCanvas" width="491" height="390"></canvas>
                    <!-- 맵 위에 배치할 정보 -->
                    <div id="additionalInfo" class="additional-info"></div>
                    <!-- 마우스 위치 좌표 표시 -->
                    <div id="mousePositionInfo" class="additional-info" style="display: none;"></div>
                </div>
            </div>

            <div class="right-panel">
                <!-- 카메라 이미지 표시 -->
                <iframe src="./camera.html" style="width: 491px; height: 390px; border: none;"></iframe>
                <!-- <iframe src="/opencv/camera_cv.html" style="width: 100%; height: 300px; border: none;"></iframe> -->
                <!-- <iframe src="/opencv/camera_pi.html" style="width: 100%; height: 300px; border: none;"></iframe> -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/roslib@1.1.0/build/roslib.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var ros = new ROSLIB.Ros({
            url: 'ws://192.168.123.118:9090'
        });

        ros.on('connection', function() {
            console.log('Connected to ROS');
            updateStatusUI('Online', 'green');
        });

        ros.on('error', function(error) {
            console.log('Error connecting to ROS:', error);
            updateStatusUI('Offline', 'gray');
        });

        ros.on('close', function() {
            console.log('Disconnected from ROS');
            updateStatusUI('Offline', 'gray');
        });

        function updateStatusUI(status, color) {
            var statusText = document.getElementById('status-text');
            var statusIndicator = document.getElementById('status-indicator');

            if (statusText && statusIndicator) {
                statusText.textContent = status;
                statusIndicator.style.backgroundColor = color;
            }
        }

        var robotListener = new ROSLIB.Topic({
            ros: ros,
            name: '/tf',
            messageType: 'tf2_msgs/TFMessage'
        });

        var pathListener = new ROSLIB.Topic({
            ros: ros,
            name: '/move_base/NavfnROS/plan',
            messageType: 'nav_msgs/Path'
        });

        var goalReachedListener = new ROSLIB.Topic({
            ros: ros,
            name: '/move_base/result',
            messageType: 'move_base_msgs/MoveBaseActionResult'
        });

        var robotX = 0;
        var robotY = 0;
        var pathCoordinates = [];
        var goalReached = false;

        robotListener.subscribe(function(message) {
            var foundTransform = false;
            for (var i = 0; i < message.transforms.length; i++) {
                var transform = message.transforms[i];
                if (transform.header.frame_id === 'odom' && transform.child_frame_id === 'base_footprint') {
                    robotX = transform.transform.translation.x;
                    robotY = transform.transform.translation.y;

                    updateCanvas();
                    updateAdditionalInfo(); // 로봇 위치 업데이트 시 추가 정보도 업데이트
                    foundTransform = true;
                    break;
                }
            }
            if (!foundTransform) {
                console.log('No transform with frame_id "odom" and child_frame_id "base_footprint" found in the message');
            }
        });

        pathListener.subscribe(function(message) { // plan
            if (!goalReached) {
                pathCoordinates = message.poses.map(function(pose) {
                    return { x: pose.pose.position.x, y: pose.pose.position.y };
                });
                updateCanvas();
            }
        });

        goalReachedListener.subscribe(function(message) {
            if (message.status.status === 3) { // status 3 means goal reached
                goalReached = true;
                setTimeout(function() {
                    pathCoordinates = []; // 경로 데이터 초기화
                    updateCanvas(); // 캔버스 업데이트
                    goalReached = false;
                }, 1000); // 1초 후에 경로 초기화
            }
        });

        function updateCanvas() {
            var canvas = document.getElementById('mapCanvas');
            if (!canvas) {
                console.error('Canvas element not found');
                return;
            }
            var ctx = canvas.getContext('2d');

            var mapImage = new Image();
            mapImage.src = 'map_fun.jpg';
            mapImage.onload = function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(mapImage, 0, 0, canvas.width, canvas.height);

                var resolution = 0.05;
                var offsetX = 385;
                var offsetY = 38;

                var robotCanvasX = (robotX / resolution) + offsetX;
                var robotCanvasY = canvas.height - ((robotY / resolution) + offsetY);

                ctx.beginPath();
                ctx.arc(robotCanvasX, robotCanvasY, 4, 0, 2 * Math.PI);
                ctx.fillStyle = 'green';
                ctx.strokeStyle = 'blue';
                ctx.fill();
                ctx.stroke();

                if (pathCoordinates.length > 0) {
                    ctx.beginPath();
                    ctx.moveTo((pathCoordinates[0].x / resolution) + offsetX, canvas.height - ((pathCoordinates[0].y / resolution) + offsetY));
                    for (var i = 1; i < pathCoordinates.length; i++) {
                        var x = (pathCoordinates[i].x / resolution) + offsetX;
                        var y = canvas.height - ((pathCoordinates[i].y / resolution) + offsetY);
                        ctx.lineTo(x, y);
                    }
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }
            };
        }

        // 추가 정보 업데이트 함수
        function updateAdditionalInfo() {
            var additionalInfo = document.getElementById('additionalInfo');
            if (!additionalInfo) return;

            // 로봇의 현재 좌표를 기반으로 특정 정보를 표시
            var infoText = '로봇 현재 위치: X=' + robotX.toFixed(2) + ', Y=' + robotY.toFixed(2);
            additionalInfo.textContent = infoText;

            // 위치 계산
            var resolution = 0.05;
            var offsetX = 385;
            var offsetY = 38;
            var infoLeft = (robotX / resolution) + offsetX + 10; // 왼쪽으로 10px 이동
            var infoTop = canvas.height - ((robotY / resolution) + offsetY) + 10; // 아래로 10px 이동

            additionalInfo.style.left = infoLeft + 'px';
            additionalInfo.style.top = infoTop + 'px';
        }

        // 맵 캔버스 요소
        var mapCanvas = document.getElementById('mapCanvas');


        // 마우스 파라미터(로봇위치와의 오차가 생각보다 크다.)
        var mouseResolution = 0.0512;
        var mouseOffsetX = 375;
        var mouseOffsetY = 45;

        // 마우스가 맵 캔버스 위에 있을 때 이벤트 리스너 추가
        mapCanvas.addEventListener('mousemove', function(e) {
            var rect = mapCanvas.getBoundingClientRect();
            var x = e.clientX - rect.left; // 마우스 X 좌표
            var y = e.clientY - rect.top; // 마우스 Y 좌표

            // 좌표를 맵의 해상도에 맞게 계산 (예시로 0.05 해상도를 사용)
            var mapX = ((x - mouseOffsetX) * mouseResolution).toFixed(2);
            var mapY = ((mapCanvas.height - y - mouseOffsetX) * mouseResolution).toFixed(2);

            var mousePositionInfo = document.getElementById('mousePositionInfo');
            mousePositionInfo.textContent = '마우스 위치: X=' + mapX + ', Y=' + mapY;
            mousePositionInfo.style.left = (x + 10) + 'px'; // 정보 박스를 마우스 오른쪽에 위치
            mousePositionInfo.style.top = (y + 10) + 'px'; // 정보 박스를 마우스 아래쪽에 위치
            mousePositionInfo.style.display = 'block';
        });

        // 마우스가 맵 캔버스 밖으로 나갈 때 좌표 표시 숨기기
        mapCanvas.addEventListener('mouseleave', function() {
            var mousePositionInfo = document.getElementById('mousePositionInfo');
            mousePositionInfo.style.display = 'none';
        });

        // goal 설정 관련 코드
        var moveBaseClient = new ROSLIB.ActionClient({
            ros: ros,
            serverName: '/move_base',
            actionName: 'move_base_msgs/MoveBaseAction'
        });

        mapCanvas.addEventListener('click', function(e) {
            var rect = mapCanvas.getBoundingClientRect();
            var clickX = e.clientX - rect.left; // 마우스 클릭 X 좌표
            var clickY = e.clientY - rect.top; // 마우스 클릭 Y 좌표

            var goalX = (clickX - mouseOffsetX) * mouseResolution;
            var goalY = (mapCanvas.height - clickY - mouseOffsetY) * mouseResolution;

            var goal = new ROSLIB.Goal({
                actionClient: moveBaseClient,
                goalMessage: {
                    target_pose: {
                        header: {
                            frame_id: 'map'
                        },
                        pose: {
                            position: {
                                x: goalX,
                                y: goalY,
                                z: 0.0
                            },
                            orientation: {
                                x: 0.0,
                                y: 0.0,
                                z: 0.0,
                                w: 1.0
                            }
                        }
                    }
                }
            });

            goal.send();

            console.log('Goal sent: X=' + goalX + ', Y=' + goalY);
        });

        // 수동 조작을 위한 Twist 메시지 발행
        var cmdVel = new ROSLIB.Topic({
            ros: ros,
            name: '/cmd_vel',
            messageType: 'geometry_msgs/Twist'
        });

        function publishTwist(linear, angular) {
            var twist = new ROSLIB.Message({
                linear: {
                    x: linear,
                    y: 0.0,
                    z: 0.0
                },
                angular: {
                    x: 0.0,
                    y: 0.0,
                    z: angular
                }
            });
            cmdVel.publish(twist);
        }

        // 키보드 이벤트 리스너
        document.addEventListener('keydown', function(event) {
            var linear = 0.0;
            var angular = 0.0;

            switch(event.key) {
                case 'ArrowUp':
                    linear = 0.5; // 전진
                    break;
                case 'ArrowDown':
                    linear = -0.5; // 후진
                    break;
                case 'ArrowLeft':
                    angular = 1.0; // 좌회전
                    break;
                case 'ArrowRight':
                    angular = -1.0; // 우회전
                    break;
                default:
                    return; // 위, 아래, 왼쪽, 오른쪽 키가 아닐 경우 무시
            }
            publishTwist(linear, angular);
        });

        document.addEventListener('keyup', function(event) {
            publishTwist(0.0, 0.0); // 키를 놓으면 멈춤
        });
    </script>
</body>
</html>
