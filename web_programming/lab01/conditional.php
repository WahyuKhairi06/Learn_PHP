<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum Web Programming</title>
</head>
<body>
    <h1>Hello World!</h1>
    <?php
        echo "<p>Ini adalah script PHP pertama saya</p>";
        // if empty($user) = TRUE, set $status = "anonymous"
        echo $status = (empty($user)) ? "anonymous" : "logged in";

        echo("<br>");
        $user = "Wahyu Khairi";

        // if empty($user) = FALSE, set $status = "logged in"
        echo $status = (empty($user)) ? "anonymous" : "logged in";
        echo("<br>");
        echo("=========================================================");
        echo("<br>");

        // variable $user is the value of $_GET['user']
        // and 'anonymous' if it does not exist
        echo $user = $_GET["user"] ?? "anonymous";
        echo("<br>");

        // variable $color is "red" if $color does not exist or is null
        echo $color = $color ?? "red";
        ?>
</body>
</html>