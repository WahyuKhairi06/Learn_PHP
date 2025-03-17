<?php
require_once 'db_connection.php';

try {
    // Prepare and execute the SQL query to select all data from MyGuests
    $stmt = $conn->prepare("SELECT * FROM MyGuests");
    $stmt->execute();

    // Set the fetch mode to associative array
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // Fetch all results into an associative array
    $result = $stmt->fetchAll();
} catch(PDOException $e) {
    // Handle any errors during the process
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Guests</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>My Guests</h1>

    <!-- Table to display guest data -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Registered Date</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through the result array and display each guest's information -->
            <?php foreach ($result as $guest) { ?>
                <tr>
                    <td><?= $guest['id'] ?></td>
                    <td><?= $guest['firstname'] ?></td>
                    <td><?= $guest['lastname'] ?></td>
                    <td><?= date_format(date_create($guest['reg_date']), 'D, d F Y H:i') ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
