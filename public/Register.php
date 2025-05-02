<?php

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_SPECIAL_CHARS);

$errors = [];
$errors_username = [];

$dbs = 'sqlite:../Database.db';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
if (empty($username)) {
    $errors_username['username'] = 'Username is required';
} elseif (strlen(trim($username)) < 3) {
    $errors['username'] = 'Username is too short';
} elseif (empty($email)) {
    $errors['email'] = 'You need to provide a valid email';
} elseif (empty($password)) {
    $errors['password'] = 'Password is required';
} elseif (strlen(trim($password)) < 6) {
    $errors['password'] = 'Password is too short';
} elseif (empty($confirm_password)) {
    $errors['confirm_password'] = 'Confirm password ';
} elseif ($password !== $confirm_password) {
    $errors['confirm_password'] = 'Passwords do not match';
} else {

    try {
        $db = new PDO($dbs, '', '', $options);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $username && $password && $email) {
            $check = $db->prepare('SELECT * FROM user WHERE name = :name OR email = :email');
            $check->execute(['name' => $username, 'email' => $email]);
            if ($check->fetchColumn() > 0) {
                $errors[] = 'Username or email already exists';
            } else {
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
        $errors[] = 'Database error : '.$e->getMessage();
    }
}

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
    <div class="page-ref">
        <a href="index.php">Home </a>
        <a href="Creation_post.php">Create a post</a>
        <a href="Edition_post.php">Edit a post</a>
        <a href="Detail_post.php"> View the details of a post</a>
    </div>
    <div class="register-header">
        <a href="Login.php">Login</a>
        <a href="Register.php">Get started</a>
    </div>
</div>
<style>
    <?php include 'style-page/style_register.css'; ?>
</style>

<div class="header-to">
    <div class="background">
        <div id="login">

            <p>Create your account </p>

            <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                <div class="enter_information">
                    <label for="username" id="username">Username</label>

                    <input type="text" placeholder="Enter your password" id="username" name="username">
                </div>

                <div class="enter_information">
                    <label for="email" id="email">Email </label>
                    <input type="email" placeholder="Enter you email or username" id="email" name="email">
                </div>

                <div class="enter_information">
                    <label for="password" id="password">Passwords</label>
                    <input type="password" placeholder="Enter your password" id="password" name="password">
                </div>

                <div class="enter_information">
                    <label for="confirm_password" id="confirm_password">Confirm your password</label>
                    <input type="password" placeholder="Enter your password" id="confirm_password"
                           name="confirm_password">
                </div>
                <?php if (count($errors) > 0) { ?>
                    <?php foreach ($errors as $error) { ?>
                        <p id="errors_message"><?= $error ?></p>
                    <?php } ?>
                <?php } ?>
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

