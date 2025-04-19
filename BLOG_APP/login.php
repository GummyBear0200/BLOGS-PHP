<?php
session_start();
require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\User;

// mo redirect if naka log in na
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$error = '';

//mao ni mo handle sa login form or kanang mo identify sa mga credentials ba =)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $userModel = new User();
    $user = $userModel->getUserByUsername($username);

    if ($user && hash('sha256', $password) === $user['password']) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'first_name' => $user['first_name']
        ];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Blog App</title>
    <style>
        body {
            background: linear-gradient(to right, #2c3e50, #34495e);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #34495e;
            padding: 30px;
            border-radius: 15px;
            width: 320px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-family: 'Montserrat', sans-serif;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
            background-color: #2f3542;
            color: white;
            font-size: 1em;
            box-sizing: border-box;
            transition: background-color 0.3s ease;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #16a085;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #138d75;
        }

        .error {
            color: #e74c3c;
            text-align: center;
            margin-top: 10px;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            color: #1abc9c;
            text-decoration: none;
            font-weight: bold;
        }

        .link a:hover {
            text-decoration: underline;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            background-color: #1abc9c;
            color: black;
        }

        .back-button {
            background-color: #e74c3c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="link">
            Don't have an account? <a href="register.php">Register here</a>
        </div>


        <a href="index.php"><button class="back-button">Back</button></a>
    </div>
</body>
</html>
