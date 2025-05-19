<?php

function changepassword($pdo, $id_user, $acc_password, $new_password, $confirm_password)
{

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // display the correct message if the field is entered incorrectly
        if (empty($acc_password)) {
            $_SESSION['error-message'] = 'Actuel password is required';
        } elseif (empty($new_password)) {
            $_SESSION['error-message'] = 'Enter a  password , to change your password';
        } elseif (strlen($new_password) < 6) {
            $_SESSION['error-message'] = 'New password must be at least 6 characters long';
        } elseif (empty($confirm_password)) {
            $_SESSION['error-message'] = 'Please confirm your password';
        } elseif ($new_password !== $confirm_password) {
            $_SESSION['error-message'] = 'Passwords does not match';
        } else {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && $acc_password && $new_password && $confirm_password) {
                    // to get the right user
                    $query = $pdo->prepare('SELECT password FROM user WHERE id_user = :id_user');
                    $query->execute(['id_user' => $id_user]);
                    $row = $query->fetch();

                    if ($row && password_verify($acc_password, $row['password'])) {
                        if ($new_password === $confirm_password) {

                            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                            // update the password in the database,  redirects to the right page and display a message
                            $update_query = $pdo->prepare('UPDATE user SET password = :password WHERE id_user = :id_user');
                            $update_query->execute([
                                'password' => $new_password_hash,
                                'id_user' => $id_user,
                            ]);

                            $_SESSION['succes'] = 'Password updated successfully';
                            header('location: index.php');
                            exit();

                        }
                    } else {
                        $_SESSION['error-message'] = 'Password incorect, try again';

                    }
                }

            } catch (PDOException $e) {
                $_SESSION['error-message'] = 'Database error : ' . $e->getMessage();
            }
        }

    }
}
