<?php
session_start();
$db = 'sqlite:../Database.db';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

if (! isset($_SESSION['id_user'])) {
    header('Location: Login.php');
    exit();
}

$pdo = new PDO($db, '', '', $options);
$id_user = $_SESSION['id_user'];

$query = $pdo->prepare('SELECT * FROM user WHERE id_user = :id_user');
$query->execute([':id_user' => $id_user]);
$results = $query->fetch();

$query_to = $pdo->prepare('SELECT * FROM blog WHERE user_id = :id_user');
$query_to->execute([':id_user' => $id_user]);
$results_rows = $query_to->fetchAll();

// Update
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($username)) {
        $_SESSION['error'] = 'Username is required';
    } elseif (strlen(trim($username)) < 3) {
        $_SESSION['error'] = 'Username is too short';
    }
    if (empty($email)) {
        $_SESSION['error'] = 'You need to provide a valid email';
    }
    if (empty($username) && empty($email)) {
        $_SESSION['error'] = 'Username and email is required';
    }

    if (empty($_SESSION['error'])) {
        try {
            $check = $pdo->prepare('SELECT id_user FROM user WHERE (name = :name OR email = :email) AND id_user != :id_user');
            $check->execute([
                'name' => $username,
                'email' => $email,
                'id_user' => $id_user,
            ]);

            if ($check->fetch()) {
                $_SESSION['error'] = 'Username or email already in use by another account.';
            } else {
                $update = $pdo->prepare('UPDATE user SET name = :name, email = :email WHERE id_user = :id_user');
                $update->execute([
                    'name' => $username,
                    'email' => $email,
                    'id_user' => $id_user,
                ]);
                $query_user = $pdo->prepare('SELECT * FROM user WHERE id_user = :id_user');
                $query_user->execute(['id_user' => $id_user]);
                $row = $query_user->fetch();

                if ($username != $results['name']) {
                    $_SESSION['succes'] = 'Your username has been updated to  '.$row['name'];
                }
                if ($email != $results['email'] && $username != $results['name']) {
                    $_SESSION['succes'] = 'Your email has been updated to  '.$row['name'].'and your username has been updated to  '.$row['email'];
                } elseif ($email != $results['email']) {
                    $_SESSION['succes'] = 'Your email has been updated to  '.$row['email'];
                }

                header('Location: user_profil.php?id='.$id_user);
                exit();
            }

        } catch (PDOException $e) {
            $_SESSION['error'] = 'Database error: '.$e->getMessage();
        }
    }
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
    <?php if (! isset($_SESSION['id_user'])) { ?>
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
            <p style="display: flex; justify-content: center" class="errors_message_login"> You haven't made any
                posts. </p>
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
        </div><?php
        if (isset($_SESSION['error'])) { ?>
            <p class="errors_message_login"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
            <?php unset($_SESSION['error']);
        } ?>
        <?php
        if (isset($_SESSION['succes'])) { ?>
            <p class="sucess_message"><?php echo htmlspecialchars($_SESSION['succes']); ?></p>
            <?php unset($_SESSION['succes']);
        } ?>
        <button type="submit">Edit my profile</button>
        </form>


    </div>
</div>
</body>
</html>
