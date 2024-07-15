<!DOCTYPE html>
<html>
<head>
    <title>QR Code Generator</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>QR Code Ticket Generator</h1>
    <form method="POST" action="generate_ticket.php">
        <button type="submit">Generate Ticket</button>
    </form>
    <br>
    <table>
        <thead>
            <tr>
                <th>Ticket No</th>
                <th>Ticket Code</th>
                <th>Ticket QR</th>
            </tr>
        </thead>
        <tbody>
            <?php
            session_start();
            require '../db_conn.php';
            $result = $conn->query("SELECT * FROM tickets");

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['ticket_no']}</td>";
                    echo "<td>{$row['ticket_code']}</td>";
                    echo "<td><img src='{$row['ticket_qr']}' alt='QR Code'></td>";
                    echo "</tr>";
                }
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
