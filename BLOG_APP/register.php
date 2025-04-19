<?php
session_start();
require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\User;

$userModel = new User();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // validation nga sayun ehey
    if (empty($firstName) || empty($lastName) || empty($username) || empty($password)) {
        $error = "All fields are required.";
    } else {
        $hashedPassword = hash('sha256', $password);

        // check kung naay exisrting user
        $existing = $userModel->getUserByUsername($username);
        if ($existing) {
            $error = "Username is already taken.";
        } else {
            $userModel->createUser([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $username,
                'password' => $hashedPassword
            ]);
            $success = "User registered successfully! You can now <a href='login.php'>log in</a>.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            background: linear-gradient(to right, #2c3e50, #34495e);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            background-color: #2f3542;
            padding: 30px;
            border-radius: 15px;
            max-width: 450px;
            margin: auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            color: #ecf0f1;
            margin-bottom: 20px;
            font-size: 2em;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            background-color: #34495e;
            color: white;
            font-size: 1em;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #16a085;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            width: 100%;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #138d75;
        }

        .message {
            margin-top: 15px;
            text-align: center;
        }

        .error {
            color: #e74c3c;
            font-size: 1.2em;
        }

        .success {
            color: #2ecc71;
            font-size: 1.2em;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: #ecf0f1;
            font-size: 1.1em;
        }

        input[type="text"], input[type="password"] {
            transition: background-color 0.3s ease;
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

<div class="form-container">
    <h2>Register</h2>

    <?php if ($error): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="message success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>First Name:</label>
        <input type="text" name="first_name" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" required>

        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <input type="submit" value="Register">
    </form>

   
    <a href="index.php"><button class="back-button">Back</button></a>
</div>

</body>
</html>
