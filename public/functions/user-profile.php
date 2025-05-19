<?php
function user($pdo, $results, $id_user, $username, $email)
{
// s'effectue si on soumets un formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // display a message if the field is incorrectly filled in
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
                // select the user with his email or name

                $check = $pdo->prepare('SELECT id_user FROM user WHERE (name = :name OR email = :email) AND id_user != :id_user');
                $check->execute([
                    'name' => $username,
                    'email' => $email,
                    'id_user' => $id_user,
                ]);

                if ($check->fetch()) {
                    // check if the user exist in th database and display a message

                    $_SESSION['error'] = 'Username or email already in use by another account.';
                } else {
                    // update the right field of the user , and display the right message to the user
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
                        $_SESSION['succes'] = 'Your username has been updated to  ' . $row['name'];
                    }
                    if ($email != $results['email'] && $username != $results['name']) {
                        $_SESSION['succes'] = 'Your email has been updated to  ' . $row['name'] . 'and your username has been updated to  ' . $row['email'];
                    } elseif ($email != $results['email']) {
                        $_SESSION['succes'] = 'Your email has been updated to  ' . $row['email'];
                    }

                    header('Location: user_profil.php?id=' . $id_user);
                    exit();
                }

            } catch (PDOException $e) {
                $_SESSION['error'] = 'Database error: ' . $e->getMessage();
            }
        }
    }
}