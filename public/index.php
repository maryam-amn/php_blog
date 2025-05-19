<?php
session_start();
require_once 'functions/database-connection.php';
// used to connect to the database
$pdo = getPDO();

$query = $pdo->prepare('SELECT * FROM blog ORDER BY created_at DESC');

$query->execute();
$results = $query->fetchAll();

$id_user = $_SESSION['id_user']
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
    <?php if (!isset($_SESSION['id_user'])) { ?>
        <div class="page-ref">
            <a href="index.php">Home </a>

        </div>
        <div class="space-btn">
            <a href="Register.php">
                <button class="btn"> Register</button>
            </a>
            <a href="Login.php" style="padding-top: 0%; width: 50%">
                <button name="logout" class="btn">Log in</button>
            </a>


        </div>

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

<div class="space">
</div>
<?php
if (isset($_SESSION['succes'])) {
    echo '<p class="sucess_message">' . $_SESSION['succes'] . '</p>';
    unset($_SESSION['succes']);
}
?>

<?php $i = 0; ?>
<?php foreach ($results as $row) { ?>

    <?php if ($i % 3 == 0) {
        echo '<div class="homepage">';
    } ?>

    <div class="font-post-homepage">
        <h4><?= htmlspecialchars($row['title']) ?></h4>
        <a href="Detail_post.php?id=<?= $row['id_blog'] ?>">
            <img src="<?= $row['image'] ?>" width="300" height="200">
        </a>
        <p id="content-homepage"><?= $row['content'] ?></p>

        <div class="text">
            <a href="Detail_post.php?id=<?= $row['id_blog'] ?>">
                <button>See more</button>
            </a>
            <p id="text-p"><?= $row['created_at'] ?></p>
        </div>
    </div>

    <?php $i++; ?>
    <?php if ($i % 3 == 0) {
        echo '</div>';
    } ?>

<?php } ?>

<?php if ($i % 3 != 0) {
    echo '</div>';
} ?>


</body>
</html>
