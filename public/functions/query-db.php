<?php

function querydetailsgetblog($pdo, $id)
{    // to get the user

    $query = $pdo->prepare('SELECT * FROM blog WHERE id_blog = :id');
    $query->execute(['id' => $id]);
    $results = $query->fetchAll();

    return $results;
}

function querydetailsgetuser($pdo, $id)
{
    $query_user = $pdo->prepare('SELECT * FROM `user` WHERE id_user = :id');
    $query_user->execute(['id' => $id]);
    $row_user = $query_user->fetch();

    return $row_user;
}
