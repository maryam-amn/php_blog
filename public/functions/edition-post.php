<?php

function edtionpost($results, $pdo, $post_content, $post_title, $id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $image_path = '';
            if (! empty($post_image['name'])) {
                $upload_result = uploadPicture($post_image);

                $image_path = $upload_result['path'];
            } else {
                $image_path = $results[0]['image'];
            }
            // to update the content , image or title of the blog , redirect and display the right message
            $query_to = $pdo->prepare('UPDATE blog SET content = :content, title = :title, image = :image WHERE id_blog = :id');
            $query_to->execute([
                'content' => $post_content,
                'title' => $post_title,
                'image' => $image_path,
                'id' => $id,

            ]);
            $_SESSION['succes'] = 'The blog has been edited successfully';

            header('Location: Detail_post.php?id='.$id);
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }
}
