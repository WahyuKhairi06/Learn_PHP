<?php
session_start();
$loginErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    if (!isset($_SESSION["registered_user"])) {
        $loginErr = "Belum ada akun terdaftar. Silakan daftar terlebih dahulu.";
    } else {
        foreach ($_SESSION["registered_user"] as $user) {
            if ($user["email"] == $email && password_verify($password, $user["password"])) {
                $_SESSION["loggedin_user"] = $user;
                header("Location: dashboard.php");
                exit;
            }
        }
        $loginErr = "Email atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: calc(100% - 12px);
            padding: 6px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        .red-text {
          color: red;
          text-align: center;
        }
    </style>
</head>
<body>

    <form method="post">
        <h1>Login</h1>

        <label>Email</label>
        <input type="email" name="email"><br>

        <label>Password</label>
        <input type="password" name="password"><br>

        <input type="submit" value="Login">
        <p class="red-text"><?php echo $loginErr; ?></p>
        <p>Belum punya akun? <a href="registration.php">Daftar di sini</a></p>
    </form>

</body>
</html>