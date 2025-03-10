<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum Web Progamming</title>
</head>
<body>
    <h1>Hello World</h1>

    <?php
        echo "<p>Ini adalah script PHP pertama saya</p>";

        /**
        * WHILE
        */

        $i = 1;
        while ($i < 6) {
            echo $i;
            echo("<br>");
            $i++;
        }

        // alternative syntax
        $i = 1;
        while ($i < 6):
            echo $i;
            $i++;
        endwhile;

        echo("<br>");

        // Break
            $i = 1;
            while ($i < 6) {
                if ($i == 3) break;
                echo $i;
                echo("<br>");
                $i++;
            }

        echo("<br>");

        // Continue
        $i = 0;
        while ($i < 6) {
            $i++;
            if ($i == 3) continue;
            echo $i;
            echo("<br>");

            }
        /**
        * DO WHILE
        */
        $i = 1;
        do {
            echo $i;
            echo("<br>");
            $i++;
            } while ($i < 6);

            echo("<br>");

        // what if 8
        // in do_while, loop will execute its statements at least once, even
        //if the condition is false
        
        $i = 8;
        do {
            echo $i;
            echo("<br>");
            $i++;
        } while ($i < 6);
        echo("<br>");

        $i = 1;
        do {
            if ($i == 3) break;
            echo $i;
            echo("<br>");
            $i++;
        } while ($i < 6);
        echo("<br>");

        $i = 0;
            do {
            $i++;
            if ($i == 3) continue;
            echo $i;
            echo("<br>");
        } while ($i < 6);
        echo("<br>");


        /**
        * FOR LOOP
        */
    for ($x = 0; $x <= 10; $x++) {
        echo "The number is: $x <br>";
    }

        echo("<br>");

    for ($x = 0; $x <= 10; $x++) {
        if ($x == 3) break;
    echo "The number is: $x <br>";
    }

    echo("<br>");

        for ($x = 0; $x <= 10; $x++) {
        if ($x == 3) continue;
        echo "The number is: $x <br>";
    }

    echo("<br>");
        for ($x = 0; $x <= 100; $x+=10) {
        echo "The number is: $x <br>";
    }

    echo("<br>");

    /**
    * FOR EACH
    */
    $colors = array("red", "green", "blue", "yellow");
    foreach ($colors as $x) {
        echo "$x <br>";
    }
        echo("<br>");

    // break
    foreach ($colors as $x) {
        if ($x == "blue") break;
        echo "$x <br>";
    }
    echo("<br>");

    // continue
    foreach ($colors as $x) {
        if ($x == "blue") continue;
        echo "$x <br>";
    }
    echo("<br>");

    // alternative syntax
    foreach ($colors as $x) :
        echo "$x <br>";
    endforeach;
    echo("<br>");

    // Key and value
        $members = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
        foreach ($members as $x => $y) {
    echo "$x : $y <br>";
    }
    echo("<br>");

    // Object
    class Car {
        public $color;
        public $model;
        public function __construct($color, $model) {
            $this->color = $color;
            $this->model = $model;
        }
    }

    $myCar = new Car("red", "Volvo");
    foreach ($myCar as $x => $y) {
        echo "$x: $y <br>";
    }
    echo("<br>");

    // Reference
    $colors = array("red", "green", "blue", "yellow");
        foreach ($colors as $x) {
        if ($x == "blue") $x = "pink";
    }
    var_dump($colors);
    echo("<br>");

        foreach ($colors as &$x) {
        if ($x == "blue") $x = "pink";
    }
    var_dump($colors);
    echo("<br>");

    ?>

</body>
</html>