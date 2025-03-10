<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>multidimension</title>
</head>

    <?php
        // Array Multidimensi
        $student = [
            [
            "nama" => "Wahyu",
            "nilai" => [85, 90, 95]
        ],
        [
            "nama" => "Budi",
            "nilai" => [85, 90, 95]
        ],
        [
            "nama" => "Citra",
            "nilai" => [85, 90, 95]
        ]
        ];

        // mengakses elemen array multidimensi
        echo $student[0] ["nama"]; // Andi
        echo "<br>";
        echo $student[2] ["nilai"][1]; //90
    ?>
</body>
</html>