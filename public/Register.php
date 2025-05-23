<?php
require 'functions/database-connection.php';
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_SPECIAL_CHARS);

$errors = [];
$errors_username = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // display the right message if the user didn't enter a field

    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (strlen(trim($username)) < 3) {
        $errors['username'] = 'Username is too short';
    } elseif (empty($email)) {
        $errors['email'] = 'You need to provide a valid email';
    } elseif (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen(trim($password)) < 6) {
        $errors['password'] = 'Password is too short, enter a least 6 characters';
    } elseif (empty($confirm_password)) {
        $errors['confirm_password'] = 'Confirm your password ';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match';
    } else {
        try {
            // used to connect to the database
            $db = getPDO();
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $username && $password && $email) {
                // select the user with his email or name

                $check = $db->prepare('SELECT * FROM user WHERE name = :name OR email = :email');
                $check->execute(['name' => $username, 'email' => $email]);

                if ($check->fetch()) {
                    // check if the user exist in th database and display a message
                    $errors['user_exist'] = 'Username or email already exists';

                } else {
                    // if not, create the user and redirect to the login page
                    $query = $db->prepare('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');

                    $query->execute([
                        'name' => $username,
                        'email' => $email,
                        'password' => $password_hash,
                    ]);
                    header('Location: Login.php');
                    exit();
                }

            }
        } catch (PDOException $e) {
            $errors[] = 'Database error : ' . $e->getMessage();
        }
    }

}
$id_user = $_SESSION['id_user']

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>
    <link rel="stylesheet" href="style-page/style.css">

</head>
<body>
<div class="header">
    <div class="space-between">
    </div>
    <?php if (!isset($_SESSION['id_user'])) { ?>


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
            <a href="user_profil.php?id=<?= $id_user ?>">
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

            <p>Create your account </p>
            <?php if (!empty($errors['user_exist'])) { ?>
                <p class="errors_message_login"><?= $errors['user_exist'] ?></p>
            <?php } ?>
            <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                <div class="enter_information">
                    <label for="username" id="username">Username</label>
                    <?php if (!empty($errors['username'])) { ?>
                        <p class="errors_message_login"><?= $errors['username'] ?></p>
                    <?php } ?>
                    <input type="text" placeholder="Enter your username" id="username" name="username">
                </div>

                <div class="enter_information">
                    <label for="email" id="email">Email </label>
                    <?php if (!empty($errors['email'])) { ?>
                        <p class="errors_message_login"><?= $errors['email'] ?></p>
                    <?php } ?>
                    <input type="email" placeholder="Enter you email " id="email" name="email">
                </div>

                <div class="enter_information">
                    <label for="password" id="password">Passwords</label>
                    <?php if (!empty($errors['password'])) { ?>
                        <p class="errors_message_login"><?= $errors['password'] ?></p>
                    <?php } ?>
                    <input type="password" placeholder="Enter your password" id="password" name="password">
                </div>

                <div class="enter_information">
                    <label for="confirm_password" id="confirm_password">Confirm your password</label>
                    <?php if (!empty($errors['confirm_password'])) { ?>
                        <p class="errors_message_login"><?= $errors['confirm_password'] ?></p>
                    <?php } ?>
                    <input type="password" placeholder="Confirm your password" id="confirm_password"
                           name="confirm_password">
                </div>

                <button>Register</button>

                <div class="t">
                    <a href="Login.php">Already have an account ?</a>

                </div>
            </form>

        </div>
    </div>


</div>


</body>
</html>
