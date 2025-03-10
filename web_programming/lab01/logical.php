<!DOCTYPE html>
<html lang="en">
    <head>
     <title>Praktikum Web Programming</title>
    </head>
    <body>
        <h1>Hello World!</h1>
    <?php
        echo "<p>Ini adalah script PHP pertama saya</p>"; 
        
        $x = 100;
        $y = 50;

        if ($x == 100 and $y == 50) {
        echo '$x == 100 and $y == 50';
        echo "</br>";
        }

        if ($x == 100 or $y == 80) {
        echo '$x == 100 or $y == 80';
        echo "</br>";
        }
        
        if ($x == 100 xor $y == 80) {
        echo '$x == 100 xor $y == 80';
        echo "</br>";
        }

        if ($x == 100 && $y == 50) {
        echo '$x == 100 && $y == 50';
        echo "</br>";
        }

        if ($x == 100 || $y == 80) {
        echo '$x == 100 || $y == 80';
        echo "</br>";
        }
            
        if (!($x == 90)) {
        echo '!($x == 90)';
        echo "</br>";
        }
        ?>

    </body>
</html>