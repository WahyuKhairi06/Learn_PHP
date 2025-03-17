<?php

$servername = "localhost";
$username = "root";
$password = "";
$port = 3306;

try {
    $conn = new PDO("mysql:host=$servername; port=$port", $username, $password);
    //set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS my_db";
    $conn->exec($sql);
    
    echo "Databased created succesfully <br>";
} catch (PDOException $e) {
    echo $sql . "<br>". $e->getMessage();
}
 
//close connection
$conn = null;

?>