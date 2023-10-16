<?php

try {
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login_db";

    $mysqli = new mysqli("localhost", "root", "", "login_db");


    $dsn = "mysql:host=$hostname;dbname=$dbname";

    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}