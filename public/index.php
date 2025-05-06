<?php
session_start();
$db = 'sqlite:../Database.db';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($db, '', '', $options);

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Homepage</title>
    <link rel="stylesheet" href="style-page/style.css">
</head>
<body>
<div class="header">
    <div class="space-between">
    </div>
    <?php if (!isset($_SESSION['id_user'])) : ?>
        <div class="homepage-ref">
            <a href="index.php">Home </a>
        </div>
        <div class="space-btn">
            <a href="Register.php">
                <button class="btn">Register</button>
            </a>
            <a href="Login.php">
                <button class="btn">Log in</button>
            </a>
        </div>

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

<div class="space">
</div>

<div class="homepage">

    <div class="font-post-homepage">
        <h4>La natation</h4>
        <img src="style-image/image_home.jpg">
        <p class="text-paragraphe">La nage est une activité physique pratiquée depuis l’Antiquité, à la fois pour se
            déplacer dans l’eau,
            se détendre et entretenir sa santé.
        </p>
        <a href="Detail_post.php">
            <button> See more</button>
        </a>
        <br>
    </div>

    <div class="font-post-homepage">
        <h4>Le basketball</h4>
        <img src="style-image/img_post.jpg">

        <p class="text-paragraphe">Rapidité, précision, esprit d’équipe : le basketball ne laisse pas de place à
            l’ennui.
            Sur le terrain, chaque passe compte, chaque tir peut faire basculer le match.
        </p>
        <a href="Detail_post.php">
            <button> See more</button>
        </a>
        <br>
    </div>

    <div class="font-post-homepage">
        <h4 class="text-paragraphe">Le jardinage</h4>
        <a href="Detail_post.php"> <img src="style-image/login_img.jpg"> </a>
        <p class="text-paragraphe">Le jardinage, c’est un retour à l’essentiel. Chaque graine plantée, chaque fleur qui
            éclot
            est un petit miracle de la nature. Prendre soin d’un jardin, c’est prendre soin .
        </p>
        <a href="Detail_post.php">
            <button> See more</button>
        </a>
        <br>
    </div>

</div>

<div class="homepage">

    <div class="font-post-homepage">
        <h4>La natation</h4>
        <img src="style-image/image_home.jpg">
        <p class="text-paragraphe">La nage est une activité physique pratiquée depuis l’Antiquité, à la fois pour se
            déplacer dans l’eau,
            se détendre et entretenir sa santé.
        </p>
        <a href="Detail_post.php">
            <button> See more</button>
        </a>
        <br>
    </div>

    <div class="font-post-homepage">
        <h4>Le basketball</h4>
        <img src="style-image/img_post.jpg">

        <p class="text-paragraphe">Rapidité, précision, esprit d’équipe : le basketball ne laisse pas de place à
            l’ennui.
            Sur le terrain, chaque passe compte, chaque tir peut faire basculer le match.
        </p>
        <a href="Detail_post.php">
            <button> See more</button>
        </a>
        <br>
    </div>

    <div class="font-post-homepage">
        <h4 class="text-paragraphe">Le jardinage</h4>
        <a href="Detail_post.php"> <img src="style-image/login_img.jpg"> </a>
        <p class="text-paragraphe">Le jardinage, c’est un retour à l’essentiel. Chaque graine plantée, chaque fleur qui
            éclot
            est un petit miracle de la nature. Prendre soin d’un jardin, c’est prendre soin .
        </p>
        <a href="Detail_post.php">
            <button> See more</button>
        </a>
        <br>
    </div>

</div>
</body>
</html>
