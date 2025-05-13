<?php
session_start();
require_once 'picture_upload.php';
$post_title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$post_content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
$post_image = $_FILES['images'];
$errors = [];

$dbs = 'sqlite:../Database.db';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($post_title)) {
        $errors['post_title'] = '* The title of the post is required';
    } elseif (empty($post_content)) {
        $errors['post_content'] = '* The content is required';
    } elseif ($post_image['error'] > 0) {
        $errors['post_image'] = '* The image is required';
    } else {
        $upload_result = uploadPicture($post_image);
        if (isset($upload_result['error'])) {
            $errors['post_image'] = $upload_result['error'];
        } else {
            $image_path = $upload_result['path'];
            try {

                $pdo = new PDO($dbs, '', '', $options);
                $query = $pdo->prepare('INSERT INTO blog (title, image, content, created_at,user_id) VALUES (:title, :image, :content, :created_at, :user_id)');
                $query->execute([
                    'title' => $post_title,
                    'image' => $image_path,
                    'content' => $post_content,
                    'created_at' => date_create()->format('Y-m-d H:i:s'),
                    'user_id' => $_SESSION['id_user']]);
                $_SESSION['succes'] = 'The blog has been created successfully';

                header('Location: index.php');

                exit();

            } catch (PDOException $e) {
                $errors[] = 'Database errors : '.$e->getMessage();
            }
        }

    }
}
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
    <?php if (! isset($_SESSION['id_user'])) {
        header('Location: Login.php');
        ?>

    <?php } else { ?>
        <div class="page-ref">
            <a href="index.php">Home </a>
            <a href="Creation_post.php">Create a post</a>
            <a href="Detail_post.php"> View the details of a post</a>
        </div>
        <div class="space-btn">
            <a href="Logout.php">
                <button class="btn">Log Out</button>
            </a>

            <a style="height: 0px;width: 0px" href="user_profil.php?id=<?= $id_user ?>">
                <img alt="user-profil" style="height: 40px;width: 40px; margin: 0px"
                     src="style-image/profil_picture.png" width="20"
                     height="20">
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
            <?php if (! empty($errors['post_title'])) { ?>
                <p class="errors_message"><?= $errors['post_title'] ?></p>
            <?php } ?>
            <input type="text" placeholder="Enter post title" class="input" id="title" name="title">

            <label for="image" id="image"> Image </label>

            <div class="image">
                <input type="file" accept="image/png, image/jpeg" id="image" name="images"/>
                <?php if (! empty($errors['post_image'])) { ?>
                    <p class="errors_message"><?= $errors['post_image'] ?></p>
                <?php } ?>
            </div>

            <label for="content" id="content">Post content</label>
            <?php if (! empty($errors['post_content'])) { ?>
                <p class="errors_message"><?= $errors['post_content'] ?></p>
            <?php } ?>
            <textarea placeholder="Enter you content " id="content" name="content"></textarea>
            <?php if (! isset($_SESSION['id_user'])) { ?>
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


