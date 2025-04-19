<?php
session_start();
require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\Blog;

$blog = new Blog();
$posts = [];

if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user']['id'];
    $posts = $blog->getPostsByUser($userId);
} else {
    $posts = $blog->getAllPosts();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Posts</title>
    <style>
        body {
            background: linear-gradient(to right, #2c3e50, #34495e);
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            font-family: 'Montserrat', sans-serif;
            color: #ecf0f1;
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.5em;
        }

        .post-container {
            background: #2f3542;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .post-container:hover {
            transform: translateY(-5px);
        }

        .post-title {
            font-size: 1.8em;
            color: #1abc9c;
            margin: 0;
        }

        .post-meta {
            font-size: 0.9em;
            color: #bdc3c7;
            margin-top: 5px;
        }

        .post-content {
            margin-top: 15px;
            font-size: 1.1em;
            line-height: 1.6;
        }

        .buttons {
            text-align: center;
            margin-bottom: 40px;
        }

        .buttons a {
            background-color: #16a085;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            margin-right: 15px;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .buttons a:hover {
            background-color: #138d75;
        }

        .buttons a:active {
            background-color: #16a085;
        }

        .post-container .post-title,
        .post-meta {
            font-family: 'Arial', sans-serif;
        }

        .post-container .post-content {
            font-family: 'Georgia', serif;
            color: #ecf0f1;
        }
    </style>
</head>
<body>

    <h1><?php echo isset($_SESSION['user']) ? 'My Blog Posts' : 'Recent Blog Posts'; ?></h1>

    <div class="buttons">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="add_post.php">Add New Post</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>

    <?php foreach ($posts as $post): ?>
        <div class="post-container">
            <div class="post-title"><?php echo htmlspecialchars($post['title']); ?></div>
            <div class="post-meta">
                Posted on <?php echo date("F j, Y, g:i a", strtotime($post['created_at'])); ?>
                by User ID <?php echo $post['author_id']; ?>
            </div>
            <div class="post-content"><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>
        </div>
    <?php endforeach; ?>

</body>
</html>
