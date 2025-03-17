<?php

$servername = "localhost";
$username = "root";
$password = "";
$port = 3306;
$dbname = "my_db";

try {
    $conn = new PDO("mysql:host=$servername; port=$port; dbname=$dbname", $username, $password);
    //set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "connected succesfully <br>";
} catch (PDOException $e) {
    echo "Connection failed". $e->getMessage();
}


?>