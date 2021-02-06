<?php

$dbn = "mysql:host=localhost;dbname=bullions";
$user = "root";
$pass = "";


$connection = new PDO($dbn, $user, $pass);

try {
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection Successful !";
} catch (PDOException $e) {
    echo "Faield : " . $e->getMessage();
}
