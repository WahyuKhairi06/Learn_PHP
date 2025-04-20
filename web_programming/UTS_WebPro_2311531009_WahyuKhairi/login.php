<?php
// Koneksi database
session_start(); // Memulai sesi PHP (untuk menyimpan data login user nanti)
require_once 'db_connection.php'; // Menghubungkan ke database (file ini berisi koneksi PDO)


$loginErr = ""; // Variabel untuk menyimpan pesan error login (jika ada)


// Mengecek apakah form dikirim melalui metode POST (artinya tombol "Login" ditekan)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? "";  // Ambil input email dari form (pakai null coalescing operator)
    $password = $_POST["password"] ?? "";  // Ambil input password dari form

    // Validasi awal: memastikan email dan password tidak kosong
    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email"); // Siapkan query SELECT
        $stmt->bindParam(':email', $email); // Bind parameter agar aman dari SQL Injection
        $stmt->execute(); // Eksekusi query
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Ambil hasil sebagai array asosiatif


        if ($user && password_verify($password, $user['password'])) { //Verifikasi apakah user ditemukan dan password cocok dengan hash dari DB (menggunakan password_verify)
            $_SESSION["loggedin_user"] = $user; // Simpan data user ke session
            header("Location: dashboard.php"); // Redirect ke halaman dashboard
            exit;

        } else {
            $loginErr = "Email atau password salah."; // Kalau login gagal (data tidak cocok)
        }

    } else {
        $loginErr = "Mohon isi semua field."; // Kalau salah satu input kosong
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<!-- Form Login -->
<div class="card p-4 shadow-sm" style="width: 22rem;">
    <h1 class="text-center mb-4">Login</h1>

 
     <!-- Membuat card dengan padding dan shadow untuk form login -->
    <form method="post">
        <?php if ($loginErr): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $loginErr; ?>
            </div>
        <?php endif; ?>

        <!-- Jika ada error saat login, tampilkan alert Bootstrap berwarna merah -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required autofocus>
        </div>

        <!-- Input email dengan label dan class Bootstrap. required = wajib isi, 
        autofocus = langsung aktif saat halaman terbuka -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <!-- Link menuju halaman pendaftaran jika belum punya akun -->
        <div class="mt-3 text-center">
            <small>Belum punya akun? <a href="registration.php">Daftar di sini</a></small>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
