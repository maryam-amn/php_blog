<?php
session_start();
require 'functions/database-connection.php';
require 'functions/changepassword.php';
// used to connect to the database

$pdo = getPDO();

$acc_password = filter_input(INPUT_POST, 'acc_password', FILTER_SANITIZE_SPECIAL_CHARS);
$new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_SPECIAL_CHARS);
$confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_SPECIAL_CHARS);
$id_user = $_SESSION['id_user'] ?? null;
// if the user in not connected, it redirects to the correct page
if (! $id_user) {
    header('Location: login.php');
    exit();
}
// Call the function who change the password and display the correct message
changepassword($pdo, $id_user, $acc_password, $new_password, $confirm_password);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change your password</title>
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
<style>
    <?php include 'style-page/style_register.css'; ?>
</style>

<div class="header-to">
    <div class="background">
        <div id="login">
            <p style="font-family: 'Cantarell Extra Bold'; font-style: normal">Change your password </p>
            <?php
            if (isset($_SESSION['error-message'])) { ?>
                <p class="errors_message_login"><?php echo htmlspecialchars($_SESSION['error-message']); ?></p>
                <?php unset($_SESSION['error-message']);
            } ?>

            <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                <div class="enter_information">
                    <label for="password" id="password">Actuel Passwords</label>

                    <input type="password" placeholder="Enter your password" id="password" name="acc_password">
                </div>

                <div class="enter_information">
                    <label for="password" id="password">New Passwords</label>

                    <input type="password" placeholder="Enter your password" id="password" name="new_password">
                </div>

                <div class="enter_information">
                    <label for="confirm_password" id="confirm_password">Confirm your password</label>

                    <input type="password" placeholder="Confirm your password" id="confirm_password"
                           name="confirm_password">
                </div>

                <button style="width: 40%" type="submit">Change Password</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
