<?php
session_start();
require 'functions/database-connection.php';
require 'functions/user-profile.php';
//used to get connected to the database
$pdo = getPDO();

if (!isset($_SESSION['id_user'])) {
    header('Location: Login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
// select user who is connected
$query = $pdo->prepare('SELECT * FROM user WHERE id_user = :id_user');
$query->execute([':id_user' => $id_user]);
$results = $query->fetch();
// select all the blog of  user who is connected, and display them

$query_to = $pdo->prepare('SELECT * FROM blog WHERE user_id = :id_user ORDER BY created_at DESC ');
$query_to->execute([':id_user' => $id_user]);
$results_rows = $query_to->fetchAll();

// Update the username or email field
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if ($username && $email && $results && $id_user && $pdo) {
    user($pdo, $results, $id_user, $username, $email);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Profile</title>

    <link rel="stylesheet" href="style-page/style.css">
</head>
<body>
<div class="header">
    <div class="space-between"></div>
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
            <a href="Detail_post.php">View the details of a post</a>
        </div>
        <div class="space-btn">
            <a href="Logout.php">
                <button name="logout" class="btn">Log Out</button>
            </a>
        </div>
    <?php } ?>
</div>

<div style="display: flex; justify-content: space-between;">


    <div id="post">

        <p id="font-user">All Your post</p>
        <?php if (empty($results_rows)) { ?>
            <p style="display: flex; justify-content: center" class="nopost-message"> No content has been shared so far.
            </p>
            <p style="width: 150%; text-align: center" class="nopost-message">Why not add your first post and get
                started ?</p>
        <?php } ?>
        <div id="post-user-container">

            <?php foreach ($results_rows as $row) { ?>
                <div id="post-user">
                    <p><?= htmlspecialchars($row['title']) ?></p>
                    <a href="Detail_post.php?id=<?= $row['id_blog'] ?>">
                        <img src="<?= htmlspecialchars($row['image']) ?>" alt="Blog-img">
                    </a>
                    <p><?= htmlspecialchars($row['content']) ?></p>
                    <a href="Detail_post.php?id=<?= $row['id_blog'] ?>">
                        <button>See more</button>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div id="profil-test">
        <h1>Your profile</h1>

        <a style="height: 0px;width: 0" href="user_profil.php?id=<?= $id_user ?>">
            <img style="height: 100px;width: 100px; margin: 0px" src="style-image/profil_picture.png" width="20"
                 height="20">
        </a>

        <div id="post-info">
            <form method="post" action="user_profil.php">
                <label>Username:</label>
                <input type="text" name="username" value="<?= htmlspecialchars($results['name']) ?>">
                <label>Email:</label>
                <input type="text" name="email" value="<?= htmlspecialchars($results['email']) ?>">


        </div>
        <?php
        if (isset($_SESSION['error'])) { ?>
            <p class="errors_message_login"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
            <?php unset($_SESSION['error']);
        } ?>
        <?php
        if (isset($_SESSION['succes'])) { ?>
            <p class="sucess_message"><?php echo htmlspecialchars($_SESSION['succes']); ?></p>
            <?php unset($_SESSION['succes']);
        } ?> <div id="button-profil">

            <div  >
                <button type="submit">Edit my profile</button>
                </form>
                <a href="ChangePasword.php">
                    <button>Change Pasword</button>
                </a>
            </div>
        </div>



    </div>
</div>
</body>
</html>