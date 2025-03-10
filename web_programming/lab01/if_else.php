<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>praktikum Web Programming</title>
</head>
<body>
    <h1>Hello World!</h1>
    <?php
    echo "<p>Ini adalah script PHP pertama saya</p>";

    $t = date("H");

    if ($t < "10") {
    echo "Have a good morning!";
    } elseif ($t < "20") {
    echo "Have a good day!";
    } else {
    echo "Have a good night!";
    }

    echo("<br>");
    echo("=========================================================");
    echo("<br>");

    $a = 13;

    $b = $a < 10 ? "hello" : "good bye";

    echo $b;

    echo("<br>");
    echo("=========================================================");
    echo("<br>");


    if ($a > 10) {
        echo "Above 10";
     if ($a > 20) {
        echo " and also above 20";
    } else {
        echo " but not above 20";
    }
     }

    echo("<br>");
    echo("=========================================================");
    echo("<br>");

    $favcolor = "red";

    switch ($favcolor) {
        case "red":
        echo "Your favorite color is red!";
        break;
    case "blue":
        echo "Your favorite color is blue!";
        break;
    case "green":
        echo "Your favorite color is green!";
        break;
    default:
        echo "Your favorite color is neither red, blue, nor green!";
        }

        ?>
    </body>
</html>