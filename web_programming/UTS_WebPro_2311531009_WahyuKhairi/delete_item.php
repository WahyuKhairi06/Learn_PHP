<?php
session_start();
require_once 'db_connection.php';

// Cek apakah user sudah login
if (!isset($_SESSION["loggedin_user"])) {
    header("Location: login.php");
    exit;
}

//  Cek apakah ada parameter ID yang dikirimkan di URL:
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

// Mendapatkan ID item dari URL:
$itemId = (int)$_GET['id'];

// Ambil semua file terkait dengan item yang ingin dihapus:
$fileStmt = $conn->prepare("SELECT filepath FROM files WHERE item_id = :item_id"); //Membuat query SQL untuk memilih kolom filepath dari tabel files berdasarkan item_id. :item_id adalah placeholder yang akan digantikan dengan nilai $itemId.
$fileStmt->execute(['item_id' => $itemId]);
$files = $fileStmt->fetchAll(PDO::FETCH_ASSOC);

// Hapus semua file dari server
foreach ($files as $file) {
    if (!empty($file['filepath']) && file_exists($file['filepath'])) {
        unlink($file['filepath']);
    }
}

// Hapus semua data file dari tabel files
$deleteFilesStmt = $conn->prepare("DELETE FROM files WHERE item_id = :item_id");
$deleteFilesStmt->execute(['item_id' => $itemId]);

// Hapus data item dari tabel items
$deleteItemStmt = $conn->prepare("DELETE FROM items WHERE id = :id");
$deleteItemStmt->execute(['id' => $itemId]);

// Setelah delete, redirect balik ke dashboard
header("Location: dashboard.php");
exit;
?>
