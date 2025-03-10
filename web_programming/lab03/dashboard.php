<?php
session_start();
if (!isset($_SESSION["loggedin_user"])) {
    header("Location: login.php");
    exit;
}

// Logout
if (isset($_POST["logout"])) {
    unset($_SESSION["loggedin_user"]);
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 1080px; 
            margin: 0 auto; 
            padding: 20px; 
        }
        .welcome-container {
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .welcome-container p {
            font-size: 18px;
            margin: 0;
        }
        .welcome-container h1 {
            font-size: 24px; 
            margin: 0;
            color: #2c3e50; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px;
        }
        th, td { 
            padding: 8px; 
            text-align: left; 
            border-bottom: 1px solid #ddd; 
        }
        th { 
            background-color: #f2f2f2; 
        }
        .logout-container {
            text-align: right;
            margin-top: 10px;
            
        }
        .logout-btn {
            background-color: red; 
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <h1>Dashboard </h1>
    
    <div class="welcome-container">
        <p>Selamat Datang,</p> 
        <h1><?php echo $_SESSION["loggedin_user"]["name"]; ?></h1>
    </div>

    <h3>Daftar Pengguna Terdaftar:</h3>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Password (Terenkripsi)</th>
            <th>Waktu Registrasi</th>
        </tr>
        <?php foreach ($_SESSION["registered_user"] as $user): ?>
        <tr>
            <td><?php echo $user["name"]; ?></td>
            <td><?php echo $user["email"]; ?></td>
            <td><?php echo $user["password"]; ?></td>
            <td><?php echo $user["registration_time"]; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="logout-container">
        <form method="post">
            <input type="submit" name="logout" value="Logout" class="logout-btn">
        </form>
    </div>
</body>
</html>
