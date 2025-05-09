<?php
session_start();
$db = 'sqlite:../Database.db';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($db, '', '', $options);
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$query = $pdo->prepare('SELECT * FROM blog WHERE id_blog = :id');

$query->execute(['id' => $id]);
$results = $query->fetchAll();

$query_to = $pdo->prepare('SELECT * FROM blog ORDER BY created_at DESC');

$query_to->execute();
$results_rows = $query_to->fetchAll();
?>
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
    <?php if (!isset($_SESSION['id_user'])) {
        header('Location: Login.php');
        exit();
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
            <a href="edit-user-profile.php?id=">
                <button class="btn">Edit profile</button>
            </a>
        </div>
    <?php } ?>
</div>
<div class="space-between-header-post"></div>
<div class="details-space">
    <div id="detail-post-page-tt">    <?php if ($results) { ?>
        <?php foreach ($results

        as $row) { ?>

        <h4 class="text-paragraphe"><?= htmlspecialchars($row['title']) ?></h4>
        <a href="Detail_post.php?id=<?= $row['id_blog'] ?>">
            <img src="<?= $row['image'] ?>" width="300" height="200" alt="Blog-img">
        </a>

        <p id="text-blog"> <?= $row['content'] ?>
        </p>
        <p id="date-blog">Published on <?= date('F j, Y', strtotime($row['created_at'])) ?></p>
        <br>
        <a href="Edition_post.php?id=<?= $row['id_blog'] ?>">
            <button id="button-blog">Edit</button>
        </a>
    </div>

</div>
<?php } ?>
<?php } else { ?> </div>


    <div class="detail-post-t">

        <div class="detail-post-page">            <?php foreach ($results_rows

            as $row) { ?>

            <div class="page-details">
                <div class="page-details-style">
                    <div class="page-details-style-img">
                        <p id="text-details-page"> <?= htmlspecialchars($row['title']) ?> </p
                        <a href="Detail_post.php">
                            <img src="<?= htmlspecialchars($row['image']) ?> " alt="Blog-img">
                        </a>
                    </div>
                    <div id="item-detail-page">
                        <p id="page-details-content"><?= $row['content'] ?></p>
                        <a href="Detail_post.php?id=<?= $row['id_blog'] ?>">
                            <button>See more</button>
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    </div>
<?php } ?>
<?php if (!isset($_SESSION['id_user'])) { ?>

    <div class="error-container">
        <div class="details-error">
            <p class="errors_message-details">Oops! You're on the wrong page.</p>
            <a href="index.php">
                <button> Click to see all blog</button>
            </a>
        </div>
    </div>

<?php } else { ?>
<?php } ?>


</body>
</html>
