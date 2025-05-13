<?php
session_start();

$db = 'sqlite:../Database.db';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($db, '', '', $options);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username']);
    $password = $_POST['password'];

    $query = $pdo->prepare('SELECT * FROM `user` WHERE `name` = :input OR `email` = :input');
    $query->execute(['input' => $usernameOrEmail]);
    $row = $query->fetch();
    $password_true = password_verify($password, $row['password']);

    if ($password_true) {
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['admin_role'] = $row['admin_role'];
        $_SESSION['username'] = $row['name'];

        if ($row['admin_role'] == 1) {
            $_SESSION['succes'] = 'You are register as a administrator ';
            header('location: index.php');

        } elseif ($row['admin_role'] == 0) {
            $_SESSION['succes'] = 'Welecome back ' . $row['name'];
            header('location: index.php');
        }
    } else {
        $_SESSION['error'] = 'Invalid username or password, try again';
        header('Location: Login.php');
    }
    exit();
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
            <a href="Logout.php">
                <button class="btn">Log Out</button>
            </a>
            <a href="user_profil.php?id=<?= $id_user ?>">
                <button class="btn">Edit profile</button>
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
                <a> Forget password ?</a>
            </div>
        </form>

    </div>
</div>

</body>
</html>






