<?php session_start()?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details post </title>
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
<div class="details-space">
    <div class="detail-post">
        <h4 class="text-paragraphe">Le jardinage</h4>
        <a href="Detail_post.php"> <img src="style-image/login_img.jpg"> </a>

        <p class="text-paragraphe"> Le jardinage, c’est un retour à l’essentiel. Chaque graine plantée, chaque fleur qui
            éclot
            est un petit miracle de la nature. Prendre soin d’un jardin, c’est prendre soin de soi.
        </p>
        <br>
        <?php if ( ! isset($_SESSION['id_user'])):?>
            <a href="Edition_post.php">
                <button>Edt</button>
            </a>
        <?php else  :?>
        <?php endif ?>
        <a href="Edition_post.php">
            <button>Edit</button>
        </a>
    </div>
</div>

</body>
</html>
