<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "employee_management"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['employee_id']) && !empty($_POST['employee_id'])) {
    $employee_id = intval($_POST['employee_id']); 
    $time = date("Y-m-d H:i:s");
    
    if (isset($_POST['arrival_time'])) {
        
        $check_sql = "SELECT id FROM clock_in WHERE employee_id = ? AND date = CURDATE() AND arrival_time IS NOT NULL";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $employee_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows == 0) {
            
            $sql = "INSERT INTO clock_in (employee_id, arrival_time, date) VALUES (?, ?, CURDATE())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $employee_id, $time);
            $stmt->execute();
        } else {
            echo "Already clocked in for today.";
        }
        $check_stmt->close();
    } elseif (isset($_POST['lunchstart'])) {
        
        $check_sql = "SELECT id FROM clock_in WHERE employee_id = ? AND date = CURDATE() AND arrival_time IS NOT NULL AND lunch_start IS NULL";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $employee_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            
            $sql = "UPDATE clock_in SET lunch_start = ? WHERE employee_id = ? AND date = CURDATE() AND lunch_start IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $time, $employee_id);
            $stmt->execute();
        } else {
            echo "Cannot start lunch. Either you're not clocked in or lunch already started.";
        }
        $check_stmt->close();
    } elseif (isset($_POST['lunchend'])) {
       
        $check_sql = "SELECT id FROM clock_in WHERE employee_id = ? AND date = CURDATE() AND lunch_start IS NOT NULL AND lunch_end IS NULL";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $employee_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
           
            $sql = "UPDATE clock_in SET lunch_end = ? WHERE employee_id = ? AND date = CURDATE() AND lunch_start IS NOT NULL AND lunch_end IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $time, $employee_id);
            $stmt->execute();
        } else {
            echo "Cannot end lunch. Either you haven't started lunch or lunch has already ended.";
        }
        $check_stmt->close();
    } elseif (isset($_POST['departure_time'])) {
       
        $check_sql = "SELECT id FROM clock_in WHERE employee_id = ? AND date = CURDATE() AND arrival_time IS NOT NULL AND departure_time IS NULL";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $employee_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            
            $sql = "UPDATE clock_in SET departure_time = ? WHERE employee_id = ? AND date = CURDATE() AND arrival_time IS NOT NULL AND departure_time IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $time, $employee_id);
            $stmt->execute();
        } else {
            echo "Cannot clock out. Either you haven't clocked in or you're already clocked out.";
        }
        $check_stmt->close();
    }
    
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}


$employees_sql = "SELECT id, name FROM employees ORDER BY name";
$employees_result = $conn->query($employees_sql);

$sql = "SELECT e.name, c.arrival_time, c.lunch_start, c.lunch_end, c.departure_time, c.date 
        FROM clock_in c 
        JOIN employees e ON c.employee_id = e.id 
        ORDER BY c.date DESC, c.arrival_time DESC";
$result = $conn->query($sql);
?>

<h1>Employee Clock-in System Dashboard</h1>


<form method="POST" action="">
    <label for="employee_select">Select Employee:</label>
    <select name="employee_id" id="employee_select" required>
        <?php
        if ($employees_result->num_rows > 0) {
            while ($employee = $employees_result->fetch_assoc()) {
                echo "<option value='" . $employee['id'] . "'>" . htmlspecialchars($employee['name']) . "</option>";
            }
        } else {
            echo "<option value=''>No employees found</option>";
        }
        ?>
    </select>
    <button name="arrival_time" type="submit">Clock In</button>
    <button name="lunchstart" type="submit">Lunch Start</button>
    <button name="lunchend" type="submit">Lunch End</button>
    <button name="departure_time" type="submit">Clock Out</button>
</form>

<h2>Recent Clock-in Records</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Arrival Time</th>
        <th>Lunch Start</th>
        <th>Lunch End</th>
        <th>Departure Time</th>
    </tr>
    
    <?php
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            $clock_in_date = date('Y-m-d', strtotime($row['date']));
            $arrival_time = $row['arrival_time'] ? date('H:i:s', strtotime($row['arrival_time'])) : '-';
            $lunch_start = $row['lunch_start'] ? date('H:i:s', strtotime($row['lunch_start'])) : '-';
            $lunch_end = $row['lunch_end'] ? date('H:i:s', strtotime($row['lunch_end'])) : '-';
            $depature_time = $row['departure_time'] ? date('H:i:s', strtotime($row['departure_time'])) : '-';
            
            echo "<tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . $clock_in_date . "</td>
                    <td>" . $arrival_time . "</td>
                    <td>" . $lunch_start . "</td>
                    <td>" . $lunch_end . "</td>
                    <td>" . $depature_time . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No clock-in data available</td></tr>";
    }
    ?>
</table>

<p><a href="/JOHNNY/employees2/php/touchscreen.php">Back to Main Page</a></p>

</body>
</html>

<?php
$conn->close();
?>
    <style>
      
body {
    font-family: 'Arial', sans-serif;
    background-color: #1a1a1a;
    color: #f4f4f4;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

h1, h2 {
    color: #f1c40f;
    text-align: center;
    text-shadow: 0 0 10px #f1c40f, 0 0 20px #f1c40f;
    margin-bottom: 20px;
}


table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background-color: #2c3e50;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
}

table, th, td {
    border: none;
}

th, td {
    padding: 12px;
    text-align: center;
    font-size: 16px;
}


th {
    background-color: #34495e;
    color: #f4f4f4;
    text-shadow: 0 0 5px #f1c40f;
}


tr:nth-child(even) {
    background-color: #2c3e50;
}

tr:hover {
    background-color: #f39c12;
    color: #fff;
    box-shadow: 0 0 10px #f39c12, 0 0 20px #f39c12;
}


form {
    margin: 20px;
    padding: 15px;
    background-color: #34495e;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
    text-align: center;
}

label {
    font-size: 18px;
    margin-right: 10px;
}

select, button {
    padding: 12px 20px;
    margin: 10px 5px;
    font-size: 16px;
    border-radius: 5px;
    border: none;
    background-color: #f39c12;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
}

select {
    width: 200px;
}

button {
    background-color: #16a085;
    text-transform: uppercase;
    box-shadow: 0 0 10px #16a085, 0 0 20px #16a085;
}

button:hover {
    background-color: #1abc9c;
    box-shadow: 0 0 20px #1abc9c, 0 0 30px #1abc9c;
}


button:active {
    transform: scale(0.98);
    box-shadow: 0 0 30px #1abc9c, 0 0 40px #1abc9c;
}


a {
    color: #f39c12;
    text-decoration: none;
    font-weight: bold;
    text-shadow: 0 0 5px #f39c12;
}

a:hover {
    color: #1abc9c;
    text-shadow: 0 0 10px #1abc9c, 0 0 15px #1abc9c;
}


input, select, textarea {
    background-color: #2c3e50;
    color: #fff;
    padding: 10px;
    border: 1px solid #f39c12;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: #f39c12;
    box-shadow: 0 0 15px rgba(241, 196, 15, 0.6);
}


tr {
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}


body {
    background: linear-gradient(to right, #1a1a1a, #34495e);
    animation: glowBackground 5s infinite alternate;
}

@keyframes glowBackground {
    0% {
        background-color: #1a1a1a;
    }
    100% {
        background-color: #2c3e50;
    }
}

    </style>
</head>
<body></body>
