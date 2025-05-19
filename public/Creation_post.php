<?php
session_start();
require_once 'picture_upload.php';
require 'functions/database-connection.php';
// to get the input of the user

$post_title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$post_content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
$post_image = $_FILES['images'];
$errors = [];

require 'functions/creation-post.php';
// create a post and display the correct message
creationPost($post_image, $post_title, $post_content, $errors);
$id_user = $_SESSION['id_user']

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a blog</title>
    <link rel="stylesheet" href="style-page/style.css">

</head>
<body>
<div class="header">
    <div class="space-between">
    </div>
    <?php if (!isset($_SESSION['id_user'])) {
        header('Location: Login.php');
        ?>

    <?php } else { ?>
        <div class="page-ref">
            <a href="index.php">Home </a>
            <a href="Creation_post.php">Create a post</a>
            <a href="Detail_post.php"> View the details of a post</a>
        </div>
        <div class="space-btn">
            <a href="user_profil.php?id=<?= $id_user ?>">
                <img style="height: 40px;width: 40px; margin: 0px" src="style-image/profil_picture.png" width="20"
                     height="20">
            </a>
            <a href="Logout.php" style="padding-top: 0%; width: 50%">
                <button name="logout" class="btn">Log Out</button>
            </a>


        </div>
    <?php } ?>

</div>
<div class="space-between-header-post">


    <section class="content">
        <h4>Create a blog</h4>
        <p> Write the content of your new blog here </p>
        <form method="post" enctype="multipart/form-data">

            <label for="title" id="title">Post Title</label>
            <?php if (!empty($errors['post_title'])) { ?>
                <p class="errors_message"><?= $errors['post_title'] ?></p>
            <?php } ?>
            <input type="text" placeholder="Enter post title" class="input" id="title" name="title">

            <label for="image" id="image"> Image </label>

            <div class="image">
                <input type="file" accept="image/png, image/jpeg" id="image" name="images"/>
                <?php if (!empty($errors['post_image'])) { ?>
                    <p class="errors_message"><?= $errors['post_image'] ?></p>
                <?php } ?>
            </div>

            <label for="content" id="content">Post content</label>
            <?php if (!empty($errors['post_content'])) { ?>
                <p class="errors_message"><?= $errors['post_content'] ?></p>
            <?php } ?>
            <textarea placeholder="Enter you content " id="content" name="content"></textarea>
            <?php if (!isset($_SESSION['id_user'])) { ?>
                <a href="Login.php">
                    <button type="submit" disabled> Post this blog</button>
                </a>
            <?php } else { ?>

                <button>Post the blog</button>

            <?php } ?>
        </form>

    </section>

</body>
</html>


