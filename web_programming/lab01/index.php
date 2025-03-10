<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum Web Programming</title>
</head>
<body>
    <h1>Hello World</h1>

    <?php
    echo "<p> Ini adalah Script PHP Pertama Saya </p>";

    //variabel
    $name = "Wahyu khairi";
    $nim = "2311531009";

    //output dengan concatenation

    echo "<p>Nama saya: $name </p>";
    echo "<p>NIM : " . $nim . "</p>";

    //fungsi date()

    echo "<p>Hari ini : " . date("d--m-y") . "</p>";

    ?>

</body>
</html>