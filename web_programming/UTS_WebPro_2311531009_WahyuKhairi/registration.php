<?php
// koneksi database
require_once 'db_connection.php'; 
session_start();

// Inisialisasi variabel
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$name = $email = $password = $confirmPassword = "";
$registrationSuccess = false;
$registrationError = "";

// Fungsi untuk sanitasi input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Fungsi validasi password
function validatePassword($password) {
    if (strlen($password) < 8) {
        return "Password minimal 8 karakter.";
    }
    if (!preg_match("/[A-Z]/", $password)) {
        return "Password harus mengandung minimal 1 huruf besar.";
    }
    if (!preg_match("/[a-z]/", $password)) {
        return "Password harus mengandung minimal 1 huruf kecil.";
    }
    if (!preg_match("/[0-9]/", $password)) {
        return "Password harus mengandung minimal 1 angka.";
    }
    return ""; // Tidak ada error
}

// Proses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi nama
    if (empty($_POST["name"])) {
        $nameErr = "Nama harus diisi.";
    } else {
        $name = sanitizeInput($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Nama hanya boleh berisi huruf dan spasi.";
        }
    }

    // Validasi email
    if (empty($_POST["email"])) {
        $emailErr = "Email harus diisi.";
    } else {
        $email = sanitizeInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Format email tidak valid.";
        }
    }

    // Validasi password
    if (empty($_POST["password"])) {
        $passwordErr = "Password harus diisi.";
    } else {
        $password = $_POST["password"];
        $passwordErr = validatePassword($password);
    }

    // Validasi konfirmasi password
    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Konfirmasi password harus diisi.";
    } else {
        $confirmPassword = $_POST["confirm_password"];
        if ($password != $confirmPassword) {
            $confirmPasswordErr = "Konfirmasi password tidak cocok.";
        }
    }

    // Jika tidak ada error, simpan data ke database
    if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        try {
            // Enkripsi password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $createdAt = date('Y-m-d H:i:s');

            // Query Insert menggunakan PDO
            $sql = "INSERT INTO users (username, email, password, created_at) VALUES (:name, :email, :password, :created_at)";
            $stmt = $conn->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':created_at', $createdAt);

            if ($stmt->execute()) {
                $registrationSuccess = true;
            } else {
                $errorInfo = $stmt->errorInfo();
                $registrationError = "Gagal menyimpan data: " . $errorInfo[2];
            }
        } catch (PDOException $e) {
            $registrationError = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <div class="card-body">
                        <h1 class="card-title text-center mb-4">Form Registrasi</h1>

                        <?php if ($registrationSuccess): ?>
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">Registrasi Berhasil!</h4>
                                <p>Selamat datang, <strong><?php echo htmlspecialchars($name); ?></strong>! Akun Anda berhasil dibuat.</p>
                                <hr>
                                <p class="mb-0">Email: <?php echo htmlspecialchars($email); ?></p>
                                <a href="login.php" class="btn btn-success mt-3">Login ke akun Anda</a>
                            </div>
                        <?php else: ?>
                            <?php if (!empty($registrationError)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $registrationError; ?>
                                </div>
                            <?php endif; ?>

                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control <?php echo !empty($nameErr) ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                                    <div class="invalid-feedback"><?php echo $nameErr; ?></div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control <?php echo !empty($emailErr) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                                    <div class="invalid-feedback"><?php echo $emailErr; ?></div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control <?php echo !empty($passwordErr) ? 'is-invalid' : ''; ?>" id="password" name="password">
                                    <div class="invalid-feedback"><?php echo $passwordErr; ?></div>
                                    <small class="form-text text-muted">
                                        Password harus:
                                        <ul>
                                            <li>Minimal 8 karakter</li>
                                            <li>Mengandung minimal 1 huruf besar</li>
                                            <li>Mengandung minimal 1 huruf kecil</li>
                                            <li>Mengandung minimal 1 angka</li>
                                        </ul>
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control <?php echo !empty($confirmPasswordErr) ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password">
                                    <div class="invalid-feedback"><?php echo $confirmPasswordErr; ?></div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Daftar</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
