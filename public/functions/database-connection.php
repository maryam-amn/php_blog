<?php

function getPDO()
{

    $db = 'sqlite:../Database.db';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        return new PDO($db, '', '', $options);
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
}
