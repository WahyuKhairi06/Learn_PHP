<?php
 require_once 'db_connection.php';

try {
    $sql = "INSERT INTO MyGuests (firstname, lastname, email)
    VALUES ('John', 'Doe', 'john@example.com')";


    $conn->exec($sql);
    
    echo "New Record created succesfully <br>";
} catch (PDOException $e) {
    echo $sql . "<br>". $e->getMessage();
}
 
$conn = null;

?>