<?php
session_start();
require 'config.php'; // Ensure this contains the DB connection

// Fetch employer details (Replace with database logic if needed)
$employer_username = 'johnny';
$employer_password_hash = password_hash('442windows6654', PASSWORD_DEFAULT); // Store hashed password

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($username === $employer_username && password_verify($password, $employer_password_hash)) {
        $_SESSION['employer_id'] = 1; // Set employer session
        $_SESSION['employer_username'] = $username;
        
        header('Location: /JOHNNY/employees2/php/employer_reports.php');
        exit;
    } else {
        $error_message = "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }
        .login-container { display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box {
            background: rgba(0, 0, 0, 0.5);
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            text-align: center;
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease-in-out;
        }
        .login-box:hover {
            transform: scale(1.05);
        }
        h1 { font-size: 2.5em; margin-bottom: 30px; font-weight: 700; color: #ff8c00; text-shadow: 0 0 8px #ff8c00, 0 0 10px #ff8c00; }
        input[type="text"], input[type="password"] {
            width: 100%; padding: 15px; margin: 10px 0; border: none;
            border-radius: 5px; background-color: rgba(255, 255, 255, 0.1);
            color: #fff; font-size: 1em; transition: all 0.3s ease;
            box-shadow: 0 0 8px rgba(255, 140, 0, 0.7);
        }
        input::placeholder { color: rgba(255, 255, 255, 0.7); }
        input:focus { 
            outline: none; 
            border: 2px solid #ff8c00; 
            background-color: rgba(255, 255, 255, 0.2); 
            box-shadow: 0 0 15px rgba(255, 140, 0, 1);
        }
        button {
            width: 100%; padding: 15px; border: none; border-radius: 5px;
            background-color: #ff8c00; color: white; font-size: 1.2em;
            cursor: pointer; transition: background-color 0.3s ease;
            box-shadow: 0 0 8px rgba(255, 140, 0, 0.8);
        }
        button:hover { background-color: #ff7300; box-shadow: 0 0 15px rgba(255, 115, 0, 0.8); }
        .error { color: #ff4d4d; font-size: 0.9em; margin-top: 15px; }
        
        /* Glow effect on inputs and button */
        input:focus, button:hover {
            text-shadow: 0 0 10px #ff8c00, 0 0 20px #ff8c00, 0 0 30px #ff8c00;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .login-box { width: 90%; }
            h1 { font-size: 2em; }
            input[type="text"], input[type="password"], button {
                font-size: 1em;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Login</h1>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <?php if (!empty($error_message)): ?>
                <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
