<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Post</title>
    <link rel="stylesheet" href="style-page/style.css">

</head>
<body>
<div class="header">
    <div class="space-between">
    </div>
    <?php if (!isset($_SESSION['id_user']))  :
        header('Location: Login.php');
        ?>
    <?php else : ?>
        <div class="page-ref">
            <a href="index.php">Home </a>
            <a href="Creation_post.php">Create a post</a>
            <a href="Edition_post.php">Edit a post</a>
            <a href="Detail_post.php"> View the details of a post</a>
        </div>
        <div class="space-btn">
            <a href="Logout.php">
                <button class="btn">Log Out</button>
            </a>
            <a href="edit-user-profile.php?id=">
                <button class="btn">Edit profile</button>
            </a>
        </div>

    <?php endif ?>

</div>
<div class="space-between-header-post"></div>
<section class="content">
    <h4>Edit a blog</h4>
    <p> Write the new content of your blog here </p>
    <form method="post">
        <label>Post Title</label>
        <input type="text" placeholder="Enter post title" class="input">
        <label>Post number</label>
        <input type="number" placeholder="Enter post number" class="input">
        <label> Image </label>
        <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg"/>
        <label>Post content</label>
        <textarea placeholder="Enter you content "></textarea>
        <?php if (!isset($_SESSION['id_user'])) : ?>
            <a href="Login.php">
                <button> Post the blog</button>
            </a>        <?php else : ?>
            <button>Post the blog</button>
        <?php endif ?>
    </form>

</section>

</body>
</html>
