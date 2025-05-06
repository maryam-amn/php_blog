<?php
session_start();
$db = 'sqlite:../Database.db';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($db, '', '', $options);

$query = $pdo->prepare('SELECT * FROM blog ORDER BY created_at DESC');

$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

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

    <?php } else { ?>
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

    <?php } ?>

</div>

<div class="space">
</div>


<?php $i = 0; ?>
<?php foreach ($results as $row) : ?>

    <?php if ($i % 3 == 0) echo '<div class="homepage">'; ?>

    <div class="font-post-homepage">
        <h4><?= htmlspecialchars($row['title']) ?></h4>
        <a href="Detail_post.php?id=<?= $row['id_blog'] ?>">
            <img src="<?= $row['image'] ?>">
        </a>
        <p><?= $row['content'] ?></p>

        <div class="text">
            <a href="Detail_post.php?id=<?= $row['id_blog'] ?>">
                <button>See more</button>
            </a>
            <p id="text-p"><?= $row['created_at'] ?></p>
        </div>
    </div>

    <?php $i++; ?>
    <?php if ($i % 3 == 0) echo '</div>'; ?>

<?php endforeach; ?>

<?php if ($i % 3 != 0) echo '</div>'; ?>


</body>
</html>
