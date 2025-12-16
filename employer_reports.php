<?php
$host = 'localhost';
$dbname = '`employee_management`'; // Wrap the name in backticks
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Employee Clock-In/Out Reports</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #121212;
        color: #fff;
        padding: 20px;
    }
    h1 {
        text-align: center;
        font-size: 2.5em;
        margin-bottom: 30px;
        color: #00bcd4;
    }
    table {
        width: 90%;
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
        background: #2c2f38;
        box-shadow: 0 2px 15px rgba(0,0,0,0.2);
        border-collapse: collapse;
    }
    th, td {
        padding: 12px;
        text-align: center;
        font-size: 1.1em;
        border-bottom: 1px solid #444;
    }
    th {
        background: #1e2630;
        color: #00bcd4;
        font-weight: bold;
    }
    td {
        background: #3c434a;
    }
    tr:nth-child(even) td {
        background: #333b43;
    }
    tr:hover {
        background: #444e57;
    }
    .logout {
        text-align: center;
        margin-top: 40px;
    }
    .logout a {
        text-decoration: none;
        color: #fff;
        background: #ff5722;
        padding: 12px 20px;
        border-radius: 5px;
        font-size: 1.2em;
        transition: background 0.3s ease;
    }
    .logout a:hover {
        background: #e64a19;
    }
    @media (max-width: 768px) {
        table { width: 100%; }
        th, td { font-size: 1em; padding: 10px; }
        .logout a { font-size: 1em; padding: 10px 15px; }
    }
</style>
</head>
<body>

<h1>Employee Clock-In/Out Reports</h1>

<table>
    <tr>
        <th>Employee Name</th>
        <th>Position</th>
        <th>Clock-In Time</th>
        <th>Lunch Start</th>
        <th>Lunch End</th>
        <th>Clock-Out Time</th>
        <th>Date</th>
        <th>Location</th>
    </tr>
    <?php if (!empty($records)): ?>
        <?php foreach ($records as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['position'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['arrival_time'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['lunch_start'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['lunch_end'] ?? '-') ?></td>
                <td><?= !empty($row['depature_time']) ? htmlspecialchars($row['depature_time']) : 'Still Working' ?></td>
                <td><?= htmlspecialchars($row['date'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['location'] ?? '-') ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">No records found</td>
        </tr>
    <?php endif; ?>
</table>

<div class="logout">
    <a href="login.php">Logout</a>
</div>

</body>
</html>
