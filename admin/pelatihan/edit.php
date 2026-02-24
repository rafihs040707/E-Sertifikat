<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/admin/header.php';
require_once BASE_PATH . '/config/config.php';

$id = $_GET['id'];
$data_pelatihan = mysqli_query($conn, "SELECT * FROM pelatihan WHERE id='$id'");
$pelatihan = mysqli_fetch_assoc($data_pelatihan);
?>

<h2 class="ms-5 my-4">Edit Data Pelatihan</h2>

<form action="<?= BASE_URL ?>admin/pelatihan/proses_edit.php" method="POST" class="mx-4" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $pelatihan['id']; ?>">

    <div class="mb-2">
        <label class="form-label ms-3">Nama pelatihan:</label>
        <input type="text" name="nama_pelatihan" value="<?= $pelatihan['nama_pelatihan']; ?>" class="form-control" required>
    </div>

    <div class="mb-2">
        <label class="form-label ms-3">Deskripsi:</label>
        <input type="text" name="deskripsi" value="<?= $pelatihan['deskripsi']; ?>" class="form-control" required>
    </div>

    <div class="mb-4">
        <label class="form-label ms-3">Status:</label>
        <select class="form-select form-select-sm" name="status" required>
            <option disabled>Pilih Status</option>
            <option value="1" <?= ($pelatihan['status'] == 1) ? 'selected' : ''; ?>>Aktif</option>
            <option value="0" <?= ($pelatihan['status'] == 0) ? 'selected' : ''; ?>>Nonaktif</option>
        </select>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <button type="submit" name="update" class="btn btn-primary col-3">Update</button>
        <a href="<?= BASE_URL ?>admin/pelatihan/index.php" class="btn btn-secondary ms-2">Kembali</a>
    </div>
</form>

<script src="<?= BASE_URL ?>vendor/bs.bundle.min.js"></script>
</body>

</html>