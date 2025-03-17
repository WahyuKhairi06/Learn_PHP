<?php
require_once 'db_connection.php';

try {
    // Begin the transaction
    $conn->beginTransaction();

    // Insert records into the MyGuests table
    $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) VALUES ('Mary', 'Moe', 'mary@example.com')");
    $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) VALUES ('Julie', 'Dooley', 'julie@example.com')");
    $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) VALUES ('Kane', 'Que', 'kane@example.com')");

    // Commit the transaction
    $conn->commit();

    // Output success message
    echo "New records created successfully";
    
} catch(PDOException $e) {
    // Roll back the transaction if something failed
    $conn->rollback();

    // Output error message
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
