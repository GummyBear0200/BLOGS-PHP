<?php
session_start();
require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\Blog;

// mo redirect siyas login page if wala nka login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$blog = new Blog();
$error = '';
$title = '';
$content = '';

// uhhh mao ni ang mo handle sa form or like validation... 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title === '' || $content === '') {
        $error = "Both title and content are required.";
    } else {
        $authorId = $_SESSION['user']['id'];

        $blog->createPost([
            'title' => $title,
            'content' => $content,
            'author_id' => $authorId
        ]);

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Post - Blog App</title>
    <style>
        body {
            background-color: #2c3e50;
            color: white;
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            background-color: #34495e;
            padding: 30px;
            border-radius: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: none;
            border-radius: 8px;
            resize: vertical;
        }

        input[type="submit"] {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #1abc9c;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }

        .error {
            color: #e74c3c;
            margin-top: 10px;
            text-align: center;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #1abc9c;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add New Post</h2>

    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title); ?>" required>

        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="8" required><?php echo htmlspecialchars($content); ?></textarea>

        <input type="submit" value="Publish Post">
    </form>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="back-link">
        <a href="index.php">← Back to Home</a>
    </div>
</div>

</body>
</html>
