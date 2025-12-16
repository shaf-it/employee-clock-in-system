<?php
$host = "localhost";
$dbname = "employee_management";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Example clock-in insert
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['card_id'])) {
    $card_id = $_POST['card_id'];

    $stmt = $conn->prepare("SELECT * FROM employees WHERE card_id = :card_id");
    $stmt->execute(['card_id' => $card_id]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($employee) {
        $stmt_insert = $conn->prepare("INSERT INTO clock_in (card_id, name, arrival_time, date, location) VALUES (:card_id, :name, :arrival_time, :date, :location)");
        $stmt_insert->execute([
            'card_id' => $card_id,
            'name' => $employee['name'],
            'arrival_time' => date('H:i:s'),
            'date' => date('Y-m-d'),
            'location' => 'Office Location'
        ]);
        echo "Clock-in successful!";
    } else {
        echo "Employee not found.";
    }
}
