<?php
require_once 'picture_upload.php';
session_start();
require 'functions/database-connection.php';
require 'functions/edition-post.php';
// used to connect to the database

$pdo = getPDO();
// View, to have a page
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$query = $pdo->prepare('SELECT * FROM blog WHERE id_blog = :id');
$query->execute(['id' => $id]);
$results = $query->fetchAll();
// UPDATE
$post_title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
$post_content = filter_input(INPUT_POST, 'textarea', FILTER_SANITIZE_SPECIAL_CHARS);
$post_image = $_FILES['avatar'];
edtionpost($results, $pdo, $post_content, $post_title, $id);

$id_user = $_SESSION['id_user']

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
<div class="space-between-header-post"></div>
<?php if ($results) { ?>

    <?php foreach ($results as $row) { ?>

        <section class="content">

            <h4>Edit a blog</h4>
            <p> Write the new content of your blog here </p>
            <form method="post" enctype="multipart/form-data">

                <label for="title">Post Title</label>
                <input name="title" id="title" type="text" placeholder="Enter post title" class="input"
                       value="<?= htmlspecialchars($row['title']) ?>">
                <label> Image </label>
                <a href="style-image/image_post_ex.jpg"></a>
                <img id="edit-img" src="<?= htmlspecialchars($row['image']) ?>" alt="Current Image" width="200"
                     height="200">

                <input name="avatar" type="file" id="avatar" value="style-image/image_post_ex.jpg"
                       accept="image/png, image/jpeg">
                <label for="textarea">Post content</label>
                <textarea name="textarea" id="textarea"
                          placeholder="Enter you content "><?= $row['content'] ?> </textarea>
                <a href="Detail_post.php?id=<?= $row['id_blog'] ?>">
                    <button type="submit"> Post the bog</button>
                </a>
            </form>
        </section>
    <?php } ?>

<?php } else { ?>
    <section class="content not-found">
        <h4>Post not found</h4>
        <p>The blog post you're trying to edit doesn't exist.</p>
        <a href="index.php">
            <button>Back to home</button>
        </a>
    </section>
<?php } ?>


</body>
</html>
