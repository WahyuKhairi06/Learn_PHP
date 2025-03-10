<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>loop</title>
</head>
<body>

<?php

    $fruits = ["Apel", "Jeruk", "Mangga", "Pisang"];
    $student = [
        "nama" => "Wahyu Khairi",
        "nim" => "2311531009",
        "jurusan" => "Teknik Informatika"
    ];

    /**
     * FOR LOOP
     */
    $total = count($fruits);
    for ($i = 0; $i < $total; $i++) {
        echo $fruits[$i] . "<br>";
    }

    echo "<br>";
    echo "<br>";

    /**
     * FOR EACH
     */
    # Untuk array terindeks
    foreach ($fruits as $item) {
        echo $item . "<br>";
    }

    echo "<br>";
    echo "<br>";

    # Bisa juga menggunakan key dan value
    foreach ($fruits as $index => $value) {
        echo $index . ": " . $value . "<br>";
    }

    echo "<br>";
    echo "<br>";

    # Cara pertama, untuk array asosiatif, tanpa key
    foreach ($student as $value) {
        echo $value . "<br>";
    }

    echo "<br>";
    echo "<br>";

    # Cara kedua, untuk array asosiatif, menggunakan key
    foreach ($student as $key => $value) {
        echo $key . ": " . $value . "<br>";
    }
?>

</body>
</html>