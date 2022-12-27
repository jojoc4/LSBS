<?php

//DB
$dsn = 'mysql:dbname=bench;host=db';
$user = 'root';
$password = 'example';

// DO NOT MODIFY UNDER THIS LINE
try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}
