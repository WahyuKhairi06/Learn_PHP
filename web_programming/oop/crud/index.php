<?php
session_start();

include 'function/Alert.php';
include_once './config/Database.php';
include_once './model/Mahasiswa.php';

$database = new Database();
$db = $database->getConnection();
$mahasiswa = new Mahasiswa($db);
$result = $mahasiswa->read();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OOP - CRUD Mahasiswa</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container mt-4">
      <div class="row">
        <div class="col-lg-12">
          <h4 class="text-center">Data Mahasiswa</h4>
          <a class="btn btn-primary btn-sm mb-3" href="create.php">Tambah Mahasiswa</a>

        
          <?php 
           if (isset($_SESSION['flash_message'])) {
            if (isset($_GET['msg']) && $_GET['msg'] == '1') {
                alert($_SESSION['flash_message'], 1);
            } else {
                alert($_SESSION['flash_message'], 0);
            }
            unset($_SESSION['flash_message']);
        }
        
          ?>

          <table class="table table-bordered table-striped">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; while ($row = $result->fetch_assoc()) { ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nim']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['jurusan']) ?></td>
                <td>
                  <a class="btn btn-success btn-sm" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                  <a class="btn btn-danger btn-sm" 
                     href="function/Mahasiswa.php?action=delete&id=<?= $row['id'] ?>" 
                     onclick="return confirm('Yakin ingin menghapus data <?= htmlspecialchars($row['nama']) ?>?');">
                     Hapus
                  </a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
