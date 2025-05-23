<?php
session_start();
require_once 'functions/database-connection.php';
require 'functions/query-db.php';
// used to connect to the database

$pdo = getPDO();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$results = querydetailsgetblog($pdo, $id);
// to get the blog  and diplay them
$query_to = $pdo->prepare('SELECT * FROM blog ORDER BY created_at DESC');
$query_to->execute();
$results_rows = $query_to->fetchAll();

$row_user = querydetailsgetuser($pdo, $_SESSION['id_user']);

$_SESSION['admin_role'] = $row_user['admin_role'];

$id_user = $_SESSION['id_user']

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
    <?php if (! isset($_SESSION['id_user'])) {
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
<div class="space-between-header-post"></div> <?php
if (isset($_SESSION['succes'])) {
    echo '<p class="sucess_message">'.$_SESSION['succes'].'</p>';
    unset($_SESSION['succes']);
}
?>
<div class="details-space">


    <div id="detail-post-page-tt">
        <?php if ($results) { ?>
        <?php foreach ($results as $row) { ?>

        <h4 class="text-paragraphe"><?= htmlspecialchars($row['title']) ?></h4>
        <a href="Detail_post.php?id=<?= $row['id_blog'] ?>">
            <img src="<?= $row['image'] ?>" width="300" height="200" alt="Blog-img">
        </a>

        <p id="text-blog"> <?= $row['content'] ?>
        </p>

        <br>
        <a href="Edition_post.php?id=<?= $row['id_blog'] ?>">
            <?php if ($row_user && $row_user['admin_role'] == 1) {
                echo '<p id="date-blog">Published on '.date('F j, Y', strtotime($row['created_at'])).'</p>';
                echo '<button id="button-blog">Edit</button>';
            } elseif (isset($results[0]) && $_SESSION['id_user'] == $results[0]['user_id']) {
                echo '<p id="date-blog">Published on '.date('F j, Y', strtotime($row['created_at'])).'</p>';

                echo '<button>Edit your post</button>';
            } elseif ($row_user && $row_user['admin_role'] == 0) {
                echo '<p id="date-blog">Published on '.date('F j, Y', strtotime($row['created_at'])).'</p>';
            } else {
                echo '<p>Erreur ou utilisateur non trouvé</p>';
            } ?>
        </a>
    </div>

</div>
<?php } ?>
<?php } else { ?> </div>


    <div class="detail-post-t">

        <div class="detail-post-page">
            <?php foreach ($results_rows as $row) { ?>

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
<?php if (! isset($_SESSION['id_user'])) { ?>

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
