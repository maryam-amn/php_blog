<?php
function uploadPicture($image)
{
    $directory = 'db-image-blog/';
    if (! file_exists($directory)) {
        mkdir($directory, 0777, true);

    }
    $namePicture = uniqid().'-'.basename($image['name']);
    $target = $directory.$namePicture;

    if (! getimagesize($image['tmp_name'])) {
        return false;
    }

    if (! in_array(strtolower(pathinfo($image['name'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) {
        return ['error' => 'Only JPG, JPEG, PNG formats are accepted'];
    }

    if (move_uploaded_file($image['tmp_name'], $target)) {
        return ['success' => true, 'path' => $target];
    }

    return ['error' => "An error occurred while uploading, please try again"];

}