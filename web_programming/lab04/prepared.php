<?php
require_once 'db_connection.php';

try {
    // Prepare SQL statement and bind parameters
    $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) 
    VALUES (:firstname, :lastname, :email)");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);

    // Insert first row
    $firstname = "Sophie";
    $lastname = "Randall";
    $email = "sophie.randall@example.com";
    $stmt->execute();

    // Insert second row
    $firstname = "Abigail";
    $lastname = "Wilkins";
    $email = "abigail.wilkins@example.com";
    $stmt->execute();

    // Insert third row
    $firstname = "Alison";
    $lastname = "Newman";
    $email = "alison.newman@example.com";
    $stmt->execute();

    // Output success message
    echo "New records created successfully";
} catch(PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
