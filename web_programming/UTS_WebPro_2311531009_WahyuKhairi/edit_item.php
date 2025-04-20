<?php
session_start();
require_once 'db_connection.php';

// Pastikan user sudah login
if (!isset($_SESSION["loggedin_user"])) {
    header("Location: login.php");
    exit;
}

// Cek kalau ada ID item
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

// Cek apakah parameter ID item ada:
$itemId = $_GET['id'];
$userId = $_SESSION["loggedin_user"]["id"];

// Ambil data item
// Mengambil Data Item dari Database:
$stmt = $conn->prepare("SELECT * FROM items WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $itemId, 'user_id' => $userId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

// Menampilkan Pesan jika Item Tidak Ditemukan:
if (!$item) {
    echo "Item tidak ditemukan atau Anda tidak berhak mengaksesnya.";
    exit;
}

// Ambil semua file terkait item
$fileStmt = $conn->prepare("SELECT * FROM files WHERE item_id = :item_id");
$fileStmt->execute(['item_id' => $itemId]);
$files = $fileStmt->fetchAll(PDO::FETCH_ASSOC);

// Update item
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update title dan description
    // Pengecekan metode HTTP POST: Mengecek apakah permintaan yang diterima adalah metode POST, yang berarti form telah disubmit.
   
    // Update Judu dan Deskripsi
    if (isset($_POST['update_item'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $updateStmt = $conn->prepare("UPDATE items SET title = :title, description = :description WHERE id = :id AND user_id = :user_id");
        $updateStmt->execute([
            'title' => $title,
            'description' => $description,
            'id' => $itemId,
            'user_id' => $userId
        ]);

        // Upload file baru jika ada
        // Jika ada file baru yang diupload melalui form, setiap file akan diproses untuk disimpan ke folder uploads/ 
        // dengan nama file yang unik. File yang diupload kemudian disimpan ke dalam database (files) dengan ID item yang sesuai.
        if (!empty($_FILES['new_files']['name'][0])) {
            foreach ($_FILES['new_files']['tmp_name'] as $key => $tmp_name) {
                $filename = basename($_FILES['new_files']['name'][$key]);
                $filepath = 'uploads/' . uniqid() . '_' . $filename;
                move_uploaded_file($tmp_name, $filepath);

                // Simpan ke database 
                $insertFileStmt = $conn->prepare("INSERT INTO files (item_id, filename, filepath) VALUES (:item_id, :filename, :filepath)");
                $insertFileStmt->execute([
                    'item_id' => $itemId,
                    'filename' => $filename,
                    'filepath' => $filepath
                ]);
            }
        }

        header("Location: edit_item.php?id=" . $itemId);
        exit;
    }

    // Menghapus File yang Terkait dengan Item
    if (isset($_POST['delete_file'])) { //Mengecek apakah tombol "Hapus" telah ditekan untuk sebuah file.
        $fileId = $_POST['file_id']; //Menyimpan ID file yang ingin dihapus dari form.

        // Ambil file path
        $fileToDeleteStmt = $conn->prepare("SELECT * FROM files WHERE id = :id AND item_id = :item_id");
        $fileToDeleteStmt->execute(['id' => $fileId, 'item_id' => $itemId]);
        $file = $fileToDeleteStmt->fetch(PDO::FETCH_ASSOC);

        if ($file) {
            // Hapus file fisik
            if (file_exists($file['filepath'])) {
                unlink($file['filepath']);
            }

            // Hapus data file dari database
            $deleteFileStmt = $conn->prepare("DELETE FROM files WHERE id = :id");
            $deleteFileStmt->execute(['id' => $fileId]);
        }

        header("Location: edit_item.php?id=" . $itemId);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex flex-column">

<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Edit Item</h2>
        </div>
        <div class="card-body">
            <a href="dashboard.php" class="btn btn-secondary mb-4">← Kembali ke Dashboard</a>

            <!-- Form untuk Edit Item -->
            <form method="post" enctype="multipart/form-data" class="mb-4">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control" 
                           value="<?= htmlspecialchars($item['title']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required><?= htmlspecialchars($item['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="new_files" class="form-label">Tambah File Baru</label>
                    <input type="file" name="new_files[]" id="new_files" class="form-control" multiple>
                </div>

                <button type="submit" name="update_item" class="btn btn-success w-100">Update Item</button>
            </form>

            <hr>

            <h4>File Terkait</h4>

            <?php if (empty($files)): ?>
                <div class="alert alert-info mt-3">Belum ada file terkait item ini.</div>
            <?php else: ?>
                <!-- Daftar File Terkait Item -->
                <ul class="list-group">
                    <?php foreach ($files as $file): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="<?= htmlspecialchars($file['filepath']) ?>" target="_blank">
                                <?= htmlspecialchars($file['filename']) ?>
                            </a>
                            <form method="post" class="d-inline" onsubmit="return confirm('Hapus file ini?')">
                                <input type="hidden" name="file_id" value="<?= $file['id'] ?>">
                                <button type="submit" name="delete_file" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

