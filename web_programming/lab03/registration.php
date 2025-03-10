<?php
// registration.php
session_start();

// Inisialisasi variabel
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$name = $email = $password = $confirmPassword = "";
$registrationSuccess = false;

// Fungsi untuk sanitasi input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Fungsi validasi password
function validatePassword($password) {
    if (strlen($password) < 8) {
        return "Password minimal 8 karakter ";
    }
    if (!preg_match("/[A-Z]/", $password)) {
        return "Password harus mengandung minimal 1 huruf besar";
    }
    if (!preg_match("/[a-z]/", $password)) {
        return "Password harus mengandung minimal 1 huruf kecil";
    }
    if (!preg_match("/[0-9]/", $password)) {
        return "Password harus mengandung minimal 1 angka";
    }
    return ""; // Tidak ada error
}

// Proses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi nama
    if (empty($_POST["name"])) {
        $nameErr = "Nama harus diisi";
    } else {
        $name = sanitizeInput($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Nama hanya boleh berisi huruf dan spasi";
        }
    }

    // Validasi email
    if (empty($_POST["email"])) {
        $emailErr = "Email harus diisi";
    } else {
        $email = sanitizeInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Format email tidak valid";
        }
    }

    // Validasi password
    if (empty($_POST["password"])) {
        $passwordErr = "Password harus diisi";
    } else {
        $password = $_POST["password"];
        $passwordErr = validatePassword($password);
    }

    // Validasi konfirmasi password
    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Konfirmasi password harus diisi";
    } else {
        $confirmPassword = $_POST["confirm_password"];
        if ($password != $confirmPassword) {
            $confirmPasswordErr = "Konfirmasi password tidak cocok";
        }
    }

    // Jika tidak ada error, simpan data ke session
    if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        if (!isset($_SESSION["registered_user"])) {
            $_SESSION["registered_user"] = [];
        }

        $newUser = [
            "name" => $name,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT), // Enkripsi password
            "registration_time" => date("Y-m-d H:i:s")
        ];

        $_SESSION["registered_user"][] = $newUser;
        $registrationSuccess = true;
    }
}
// Fungsi untuk mereset session
function resetSession() {
    $_SESSION = array();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Cek apakah tombol reset ditekan
if (isset($_POST['reset'])) {
    resetSession();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Form Registrasi</h1>

    <?php if ($registrationSuccess): ?>
        <div class="success-message">
            <h3>Registrasi Berhasil!</h3>
            <p>Selamat datang, <strong><?php echo $name; ?></strong>! Akun Anda berhasil dibuat.</p>
            <p>Email: <?php echo $email; ?></p>
            <p>Waktu Registrasi: <?php echo end($_SESSION["registered_user"])["registration_time"]; ?></p>
            <p><a href="login.php">Login ke akun Anda</a></p>
        </div>
    <?php else: ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="name">Nama Lengkap:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                <span class="error"><?php echo $nameErr; ?></span>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailErr; ?></span>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <span class="error"><?php echo $passwordErr; ?></span>
                <div class="password-requirements">
                    Password harus:
                    <li>Minimal 8 karakter</li>                         
                    <li>Mengandung minimal 1 huruf besar</li>                         
                    <li>Mengandung minimal 1 huruf kecil</li>                         
                    <li>Mengandung minimal 1 angka</li>              
                </div> 
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password:</label>
                <input type="password" id="confirm_password" name="confirm_password">
                <span class="error"><?php echo $confirmPasswordErr; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" value="Daftar">
                
            </div>
        </form>
    <?php endif; ?>

    <div class="session-info">
        <h3>Informasi Session</h3>
        <p>Session ID: <?php echo session_id(); ?></p>
        <?php if (isset($_SESSION["registered_user"])): ?>
            <h4>Data User Terdaftar:</h4>
            <pre><?php print_r($_SESSION["registered_user"]); ?></pre>
        <?php else: ?>
            <p>Belum ada user yang terdaftar.</p>
        <?php endif; ?>
        
    </div>
    <form method='post' action=''>
        <input type='submit' name='reset' value='Reset Data User'>
    </form>
</body>
</html>
