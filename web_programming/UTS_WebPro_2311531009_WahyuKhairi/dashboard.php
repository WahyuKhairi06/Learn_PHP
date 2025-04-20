<?php
session_start();  // Mulai session untuk akses data login
require_once 'db_connection.php';  // Koneksi ke database

// Cek apakah user sudah login
if (!isset($_SESSION["loggedin_user"])) {
    header("Location: login.php");  // Redirect jika belum login
    exit;
}


// Logout handler
// Jika tombol logout ditekan, maka hapus session dan alihkan ke login.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    session_destroy();  // Hapus semua data session
    header("Location: login.php");  // Redirect ke login
    exit;
}


// Query pengguna
$query = "SELECT username, email, created_at FROM users";
$result = $conn->query($query);  // Ambil semua user dari DB


// Ambil ID user yang sedang login
$loggedInUserId = $_SESSION["loggedin_user"]["id"];

// Query items hanya milik user login
// Ambil semua item milik user yang sedang login (menggunakan JOIN agar bisa tampilkan username juga).
$itemStmt = $conn->prepare(
    "SELECT items.id, items.title, items.description, items.created_at, users.username
     FROM items 
     JOIN users ON items.user_id = users.id 
     WHERE users.id = :user_id
     ORDER BY items.created_at DESC"
);
$itemStmt->execute(['user_id' => $loggedInUserId]);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f8f9fa; 
        }
        .dashboard-header {
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center dashboard-header">
        <div>
            <h1 class="mb-0">Dashboard</h1>
            <p class="text-muted mb-0">Selamat Datang, <strong class="h4 text-primary"><?= htmlspecialchars($_SESSION["loggedin_user"]["username"]); ?></strong></p>
        </div>

        <!-- Tombol logout kirim POST dengan name logout, diproses di bagian atas -->
        <form method="post" class="d-inline">
            <button type="submit" name="logout" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <!-- Data User -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Pengguna Terdaftar</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Waktu Registrasi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Tabel Pengguna Terdaftar -->
                    <!--  Loop untuk menampilkan semua user dari tabel users. -->
                    <?php $no = 1; while ($user = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Data Items -->
<div class="card shadow-sm">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Items Anda</h5>
        <a href="create_item.php" class="btn btn-light btn-sm">+ Tambah Item Baru</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Dibuat</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Tabel Item Milik User -->
                 <!-- ✅ Untuk setiap item user:
                     - Ambil detail item
                     - Ambil file terkait dari tabel files -->
                <?php 
                $noItem = 1;
                while ($item = $itemStmt->fetch(PDO::FETCH_ASSOC)):
                    $stmtFiles = $conn->prepare("SELECT * FROM files WHERE item_id = :item_id");
                    $stmtFiles->execute(['item_id' => $item['id']]);
                    $files = $stmtFiles->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <tr>
                    <td><?= $noItem++ ?></td>
                    <td><?= htmlspecialchars($item['username']) ?></td>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td><?= htmlspecialchars($item['created_at']) ?></td>
                    <td>
                        <?php if (!empty($files)): ?>
                            
                             <!-- Tampilkan File-File Item -->
                            <?php foreach ($files as $file): ?>
                                <div>
                                    <a href="<?= htmlspecialchars($file['filepath']) ?>" target="_blank" class="badge bg-primary text-decoration-none">
                                        <?= htmlspecialchars($file['filename']) ?>
                                    </a>
                                </div>


                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-muted fst-italic">Tidak ada file</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit_item.php?id=<?= $item['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_item.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus item ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>