<?php

function loginUser($pdo)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usernameOrEmail = trim($_POST['username']);
        $password = $_POST['password'];
        // select the user with his email or name and check if the password is correct
        $query = $pdo->prepare('SELECT * FROM `user` WHERE `name` = :input OR `email` = :input');
        $query->execute(['input' => $usernameOrEmail]);
        $row = $query->fetch();
        $password_true = password_verify($password, $row['password']);
        // diplay the right messag and redirects the user
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
}
