<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progamming Web </title>
</head>
<body>
    <h1>Hello World</h1>

    <?php
    echo "<p>ini adalah Script PHP pertama saya </p>";

    $x = 100;
    $y = "100";

    var_dump($y);
    echo("</br");

    echo var_dump($x == $y) . "</br>";
    echo (var_dump($x === $y) . "</br>");
    echo (var_dump($x !== $y) . "</br>");

    $y = (int) $y; //parsing string to integer
    var_dump($y);
    echo("</br>");
    echo (var_dump($x != $y) . "</br>");
    echo (var_dump($x <> $y) . "</br>");
    echo (var_dump($x !== $y) . "</br>");


    echo (var_dump($x > $y) . "</br>");
    echo (var_dump($x < $y) . "</br>");
    echo (var_dump($x >= $y) . "</br>");
    echo (var_dump($x <= $y) . "</br>");
    echo (var_dump($x <=> $y) . "</br>");

    ?>

</body>
</html>