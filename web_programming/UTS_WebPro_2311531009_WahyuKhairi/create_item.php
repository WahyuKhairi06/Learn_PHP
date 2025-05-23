<?php
session_start();
require_once 'db_connection.php'; 

// Cek login (kalau perlu login, aktifkan ini)
// if (!isset($_SESSION['loggedin_user'])) {
//     header("Location: login.php");
//     exit;
// }

$errors = [];  //Menyimpan pesan error saat validasi form gagal.
$success = ''; // Definisikan $success dengan nilai kosong

// Ambil data dari form input. Gunakan trim() untuk menghapus spasi depan-belakang.
// Jika session user tidak tersedia, default user_id adalah 1 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $user_id = $_SESSION['loggedin_user']['id'] ?? 1; 

    // Tentukan ekstensi file dan ukuran maksimum file yang diizinkan diupload.
    $allowedImages = ['image/jpeg', 'image/png', 'image/gif'];
    $allowedDocs = [
        'application/pdf', 
        'application/msword', 
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    $maxSize = 2 * 1024 * 1024; // 2MB
    
    // Validasi input: jika kosong, masukkan pesan error ke array $errors.
    if (empty($title) || empty($description)) {
        $errors[] = "Judul dan Deskripsi wajib diisi.";
    }

    // Simpan Item dan Upload File (jika tidak ada error)
    if (empty($errors)) {

        // Insert ke tabel items
        $stmt = $conn->prepare("INSERT INTO items (title, description, user_id, created_at, updated_at) VALUES (:title, :description, :user_id, NOW(), NOW())");
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'user_id' => $user_id
        ]);
        // Query untuk menyimpan item ke tabel items.

        $item_id = $conn->lastInsertId();
        // Ambil id dari item terakhir yang baru saja dimasukkan — penting untuk relasi file ke item tersebut.

        // Upload file kalau ada
        if (!empty($_FILES['files']['name'][0])) {
            foreach ($_FILES['files']['name'] as $index => $name) { //Cek apakah user memilih file untuk diupload. Lalu lakukan loop untuk tiap file.

                // Ambil informasi per file: nama sementara, ukuran, jenis file (MIME type), dan status error.
                $tmpName = $_FILES['files']['tmp_name'][$index];
                $size = $_FILES['files']['size'][$index];
                $type = mime_content_type($tmpName);
                $error = $_FILES['files']['error'][$index];

                if ($error === UPLOAD_ERR_OK) { //Lanjutkan jika tidak ada error saat upload file.

                    //Validasi tipe dan ukuran file serta buat folder baru untuk menyimpan file
                    if (($size <= $maxSize) && (in_array($type, $allowedImages) || in_array($type, $allowedDocs))) {
                        $ext = pathinfo($name, PATHINFO_EXTENSION);
                        $newName = uniqid() . "." . $ext;
                        $uploadDir = 'uploads/';

                        //Buat folder uploads jika belum ada.
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }

                        // Path lengkap lokasi file yang akan disimpan.
                        $path = $uploadDir . $newName;

                        // Pindahkan file ke server, lalu simpan datanya ke tabel files.
                        if (move_uploaded_file($tmpName, $path)) {
                            $stmtFile = $conn->prepare("INSERT INTO files (item_id, filename, filepath, filetype, filesize, uploaded_at) VALUES (:item_id, :filename, :filepath, :filetype, :filesize, NOW())");
                            $stmtFile->execute([
                                'item_id' => $item_id,
                                'filename' => $name,
                                'filepath' => $path,
                                'filetype' => $type,
                                'filesize' => $size
                            ]);
                        }

                    //Tambahkan pesan error jika file gagal diupload atau tidak valid.
                    } else {
                        $errors[] = "$name gagal diupload: File terlalu besar atau tipe tidak valid.";
                    }
                } else {
                    $errors[] = "$name gagal diupload: Error kode $error.";
                }
            }
        }

        // Jika tidak ada error, tampilkan pesan sukses dan redirect ke dashboard.
        if (empty($errors)) {
            $success = "Item berhasil ditambahkan."; 
            header("Location: dashboard.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Tambah Item Baru</h2>
                </div>
                <div class="card-body p-4">
                    
                    <div class="mb-3 ">
                    <a href="dashboard.php" class="btn btn-secondary mb-4">← Kembali ke Dashboard</a>
                    </div>

                    <!-- Menampilkan error jika ada -->
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error) echo "<div>$error</div>"; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Menampilkan pesan sukses jika ada -->
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <p><?= $success ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Form kirim ke halaman ini sendiri. enctype penting agar bisa upload file. -->
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="5" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Gambar / Dokumen</label>
                            <!-- Input file dengan fitur multi-upload. Saat file dipilih, fungsi previewFiles() dipanggil. -->
                            <input type="file" name="files[]" class="form-control" multiple onchange="previewFiles()">  
                            <div class="form-text">Format: JPG, PNG, GIF, PDF, DOC, DOCX | Maks 2MB/file</div>
                        </div>

                        <div id="file-preview" class="row g-2 mt-3">
                            <!-- Preview files tampil di sini -->
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg">Upload Item</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function previewFiles() {
        const filePreviewContainer = document.getElementById('file-preview'); //Mengambil elemen HTML dengan ID file-preview. Elemen ini digunakan untuk menampilkan pratinjau file.
        filePreviewContainer.innerHTML = ''; // Bersihkan preview sebelumnya
        
        // Mendapatkan daftar file yang dipilih di input file (elemen <input type="file">). Properti .files memberikan array objek file yang dipilih oleh pengguna.
        const files = document.querySelector('input[type="file"]').files;
        
        // Mengubah objek FileList (yang diperoleh dari .files) menjadi array sehingga kita bisa menggunakan .forEach() untuk iterasi pada setiap file.
        Array.from(files).forEach(file => {
            const reader = new FileReader();

            // Jika file adalah gambar
            if (file.type.startsWith('image/')) {
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '200px';
                    img.style.marginRight = '10px';
                    filePreviewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
                
            } else {
                // Jika bukan gambar, tampilkan nama file
                const fileName = document.createElement('div');
                fileName.textContent = `File: ${file.name}`;
                filePreviewContainer.appendChild(fileName);
            }
        });
    }
</script>

</body>
</html>
