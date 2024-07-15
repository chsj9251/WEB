<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로봇 위치 관제 시스템</title>
    <link rel="stylesheet" href="styles_monitoring.css">
    <link rel="stylesheet" href="/styles_back.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>로봇 위치 관제 시스템</h1>
        </div>

        <div class="back-button">
            <img src="./icon/back.png" alt="뒤로가기" onclick="history.back()">
        </div>

        <div class="status">
            <p>상태: <span id="status-text"></span><div id="status-indicator" class="status-indicator"></div></p>
        </div>

        <div id="mapContainer">
            <canvas id="mapCanvas" width="491" height="390"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/roslib@1.1.0/build/roslib.min.js"></script>
    <script>
        var ros = new ROSLIB.Ros({
            url: 'ws://192.168.123.118:9090'
        });

        ros.on('connection', function() {
            console.log('Connected to ROS');
            updateConnectionStatus(true);
        });

        ros.on('error', function(error) {
            console.log('Error connecting to ROS:', error);
            updateConnectionStatus(false);
        });

        ros.on('close', function() {
            console.log('Disconnected from ROS');
            updateConnectionStatus(false);
        });

        setInterval(function() {
            if (ros.isConnected) {
                console.log('ROS connection is alive');
            } else {
                console.log('ROS connection is not alive');
            }
        }, 5000);

        function updateConnectionStatus(connected) {
            var statusText = document.getElementById('status-text');
            var statusIndicator = document.getElementById('status-indicator');

            if (connected) {
                statusText.textContent = 'Online';
                statusIndicator.style.backgroundColor = 'green';
            } else {
                statusText.textContent = 'Offline';
                statusIndicator.style.backgroundColor = 'gray';
            }
        }

        var robotListener = new ROSLIB.Topic({
            ros: ros,
            name: '/tf',
            messageType: 'tf2_msgs/TFMessage'
        });

        robotListener.subscribe(function(message) {
            console.log('Received robot pose message:', message);

            var foundTransform = false;
            for (var i = 0; i < message.transforms.length; i++) {
                var transform = message.transforms[i];
                if (transform.header.frame_id === 'odom' && transform.child_frame_id === 'base_footprint') {
                    var posX = transform.transform.translation.x;
                    var posY = transform.transform.translation.y;
                    console.log('Robot position:', posX, posY);

                    var canvas = document.getElementById('mapCanvas');
                    if (!canvas) {
                        console.error('Canvas element not found');
                        return;
                    }
                    var ctx = canvas.getContext('2d');

                    var mapImage = new Image();
                    mapImage.src = 'map3.jpg';
                    mapImage.onload = function() {
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        ctx.drawImage(mapImage, 0, 0, canvas.width, canvas.height);

                        var mapWidth = canvas.width;
                        var mapHeight = canvas.height;
                        var resolution = 0.05;
                        var offsetX = 385;
                        var offsetY = 37;

                        var robotCanvasX = (posX / resolution) + offsetX;
                        var robotCanvasY = mapHeight - ((posY / resolution) + offsetY);

                        console.log('Robot canvas position:', robotCanvasX, robotCanvasY);

                        ctx.beginPath();
                        ctx.arc(robotCanvasX, robotCanvasY, 4, 0, 2 * Math.PI);
                        ctx.fillStyle = 'green';
                        ctx.fill();
                        ctx.stroke();
                    };
                    foundTransform = true;
                    break;
                }
            }
            if (!foundTransform) {
                console.log('No transform with frame_id "odom" and child_frame_id "base_footprint" found in the message');
            }
        });
    </script>
</body>
</html>
