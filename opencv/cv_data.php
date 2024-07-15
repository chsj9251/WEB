<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>객체인식 관제 시스템</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="./styles_cv_data.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2; /* 테이블 헤더 배경색 */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* 짝수 번째 행 배경색 */
        }

        tr:hover {
            background-color: #e9e9e9; /* 마우스 호버 시 배경색 */
        }

        #update-button {
            background-color: #0d1b2a;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        #update-button:hover {
            background-color: #1a2e44;
        }
    </style>
    <script>
        $(document).ready(function() {
            function fetchData() {
                $.ajax({
                    url: 'fetch_data.php',
                    type: 'GET',
                    success: function(response) {
                        $('#data-container').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('데이터를 가져오는 중 에러 발생');
                    }
                });
            }

            fetchData();
            setInterval(fetchData, 500);

            $('#update-button').click(function() {
                $.ajax({
                    url: 'update_class.php',
                    type: 'POST',
                    success: function(response) {
                        fetchData(); // 데이터를 다시 가져와서 업데이트된 내용을 반영
                    },
                    error: function(xhr, status, error) {
                        console.error('데이터를 업데이트하는 중 에러 발생');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <button id="update-button">객체 초기화</button>
        <div id="data-container">
            <!-- 데이터가 업데이트될 곳 -->
            <table>
                <thead>
                    <tr>
                        <th>컬럼 제목 1</th>
                        <th>컬럼 제목 2</th>
                        <!-- 필요한 만큼 컬럼 제목 추가 -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>데이터 1</td>
                        <td>데이터 2</td>
                        <!-- 필요한 만큼 데이터 추가 -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
