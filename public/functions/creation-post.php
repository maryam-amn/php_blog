<?php

function creationPost($post_image, $post_title, $post_content, $errors)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // display the right message if the user didn't enter a field
        if (empty($post_title)) {
            $errors['post_title'] = '* The title of the post is required';
        } elseif (empty($post_content)) {
            $errors['post_content'] = '* The content is required';
        } elseif ($post_image['error'] > 0) {
            $errors['post_image'] = '* The image is required';
        } else {
            // put the image in the right path or display an error message
            $upload_result = uploadPicture($post_image);
            if (isset($upload_result['error'])) {
                $errors['post_image'] = $upload_result['error'];
            } else {
                $image_path = $upload_result['path'];
                try {
                    // create the post in the datbase and direct the user the right page
                    $pdo = getPDO();
                    $query = $pdo->prepare('INSERT INTO blog (title, image, content, created_at,user_id) VALUES (:title, :image, :content, :created_at, :user_id)');
                    $query->execute([
                        'title' => $post_title,
                        'image' => $image_path,
                        'content' => $post_content,
                        'created_at' => date_create()->format('Y-m-d H:i:s'),
                        'user_id' => $_SESSION['id_user']]);
                    $_SESSION['succes'] = 'The blog has been created successfully';

                    header('Location: index.php');

                    exit();

                } catch (PDOException $e) {
                    $errors['database'] = 'Database errors : '.$e->getMessage();
                }
            }

        }
    }
}
