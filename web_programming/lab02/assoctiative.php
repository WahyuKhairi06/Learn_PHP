<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>assoctiative</title>
</head>
<body>
    <?php
    // cara 1
    $student = Array(
        "nama" => "Wahyu Khairi",
        "nim" => "2311531009",
        "jurusan" => "Informatika",
        "ipk" => 4.00
    );

    // cara 2 (sintaks pendek)
    $student = [
        "nama" => "Wahyu Khairi",
        "nim" => "2311531009",
        "jurusan" => "Informatika",
        "ipk" => 4.00
    ];

    // mengakses elemen array assosiatif
    echo $student ["nama"];
    echo "<br>";
    echo $student ["jurusan"];

?>
</body>
</html>