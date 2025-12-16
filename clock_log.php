<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "employee_system"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $card_number = $_POST['card_id'];
    $action = ''; 


    $sql = "SELECT id, name FROM employees WHERE card_number = '$card_number'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        $employee_id = $employee['id'];
        $current_time = date('Y-m-d H:i:s');
        $current_date = date('Y-m-d');

        if (isset($_POST['clockin'])) {
            $action = "Clock In";
        
            $sql = "INSERT INTO clock_log (employee_id, clockin_time, date) VALUES ('$employee_id', '$current_time', '$current_date')";
        } elseif (isset($_POST['lunchstart'])) {
            $action = "Lunch Start";
            // Update lunch start time
            $sql = "UPDATE clock_log SET lunch_start = '$current_time' WHERE employee_id = '$employee_id' AND date = '$current_date'";
        } elseif (isset($_POST['lunchend'])) {
            $action = "Lunch End";
            // Update lunch end time
            $sql = "UPDATE clock_log SET lunch_end = '$current_time' WHERE employee_id = '$employee_id' AND date = '$current_date'";
        } elseif (isset($_POST['clockout'])) {
            $action = "Clock Out";
            // Update clock out time
            $sql = "UPDATE clock_log SET clockout_time = '$current_time' WHERE employee_id = '$employee_id' AND date = '$current_date'";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Successfully logged $action for " . $employee['name'];
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Card not recognized.";
    }
}

$conn->close();
?>
