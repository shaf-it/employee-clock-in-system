<?php
$servername = "127.0.0.1"; // Use this instead of 'localhost'
$username = "johnny"; // Your MySQL username
$password = "442windows6654"; // Your MySQL password
$dbname = "employers"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
