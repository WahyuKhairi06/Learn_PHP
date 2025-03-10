<!DOCTYPE html>
<head>
    <title>Praktikum Web Programming</title>
</head>
<body>
    <h1>Hello World</h1>

    <?php       

        echo "<p> Ini Adalah Script PHP pertama saya </p>";

        //variabel
        $name = "Wahyu Khairi";
        $nim = "2311531009";     
        $a = 8;
        $b = 4;


        //Output dengan concatenation
        echo "<p> Nama saya : $name </p>";
        echo "<p> NIM : $nim </p>";

        //Fungsi date().
        echo '<p> Hari ini: ' . date('d-m-y H:m') .  '</p>';

        echo "<p> $a + $b = " . $a + $b . "</p>";
        echo "<p> $a - $b = " . $a - $b . "</p>";
        echo "<p> $a * $b = " . $a * $b . "</p>";
        echo "<p> $a / $b = " . $a / $b . "</p>";
        echo "<p> $a % $b = " . $a % $b . "</p>";
        echo "<p> $a ** $b = " . $a ** $b . "</p>";

    ?>

</body>
</html>