<?php

// database Connection variables
define('HOST', 'localhost'); // Database host name ex. localhost
define('USER', 'root'); // Database user. ex. root 
define('PASSWORD', ''); // Database user password
define('DATABASE', 'HansonBank'); // Database Database name

function DB() {
    try {
        $db = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD);
        return $db;
    } catch (PDOException $e) {
        return "Error!: " . $e->getMessage();
        die();
    }
}

?>