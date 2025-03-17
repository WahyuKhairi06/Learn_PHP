<?php
$servername = "localhost";
$username = "root";
$password = "";
$port = 3306;
$dbname = "my_db";

try {
    
    $connection = new PDO("mysql:host=$servername;port=$port; dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected successfully <br>"; 
} catch (PDOException $e) {
    
    echo "Connection failed: " . $e->getMessage();
}
?>
