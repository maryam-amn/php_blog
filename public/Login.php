<?php
session_start();
require 'functions/database-connection.php';
require 'functions/login-user.php';
// used to connect to the database

$pdo = getPDO();
// Call the function who can log in the user
loginUser($pdo);
$id_user = $_SESSION['id_user']

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in</title>
    <link rel="stylesheet" href="style-page/style.css">

</head>
<body>
<div class="header">
    <div class="space-between">
    </div>

    <?php if (isset($_SESSION['id_user'])) { ?>
        <div class="page-ref">
            <a href="index.php">Home </a>
            <a href="Creation_post.php">Create a post</a>
            <a href="Edition_post.php">Edit a post</a>
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
    <?php include 'style-page/style_login.css'; ?>
</style>

<div class="header-to">
    <div class="style-space">
    </div>

    <div id="login">

        <p>Log in </p>
        <p class="welcome">Welcome back!
        </p>
        <p class="welcome">Enter your details to access your account.
        </p>

        <form method="post" action="Login.php">
            <div class="enter_information">
                <label for="username">Email Address or Username</label>
                <input type="text" placeholder="Enter you email or username" name="username" id="username">
            </div>

            <div class="enter_information">
                <label for="password ">Passwords</label>
                <input type="password" placeholder="Enter your password" name="password" id="password ">
            </div>
            <?php
            if (isset($_SESSION['error'])) { ?>
                <p class="errors_message_login"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
                <?php unset($_SESSION['error']);
            } ?>
            <button>Log in</button>
            <div class="t">
                <a href="Register.php">Don't have an account ? </a>
            </div>
        </form>

    </div>
</div>

</body>
</html>






