<?php 
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/admin/header_admin.php';
?>

<head>
    <title>Tambah Data Template</title>
</head>

<h2 class="ms-5 my-4">Tambah Data Template</h2>

<form action="<?= BASE_URL ?>admin/template/template_store.php" method="POST" class="mx-4" enctype="multipart/form-data">

    <div class="mb-2">
        <label for="nama_template" class="form-label ms-3">Nama Template: </label>
        <input type="text" name="nama_template" placeholder="Example: Untuk Cyber Security" class="form-control"
            maxlength="64" required><br>
    </div>

    <div class="mb-2">
        <label for="penyelenggara" class="form-label ms-3">Penyelenggara: </label>
        <input type="text" name="penyelenggara" placeholder="Example: PT ABC" class="form-control"
            maxlength="64" required><br>
    </div>

    <div class="mb-2">
        <label for="tampak_depan" class="form-label ms-3">Tampak Depan: </label>
        <input type="file" name="tampak_depan" class="form-control" required accept="image/*"><br>
    </div>

    <div class="d-grid gap-2 d-flex justify-content-center mt-3">
        <button type="submit" name="submit" class="btn btn-primary ms-2 col-3">Submit</button>
        <button type="reset" class="btn btn-warning ms-2 col-3">Reset Form</button>
        <a href="<?= BASE_URL ?>admin/template/data_template.php" style="background-color: #6C7301;"
            class="btn text-decoration-none text-white">Kembali Ke Halaman
            Template</a>
    </div>
</form>





<script src="<?= BASE_URL ?>vendor/bs.bundle.min.js"></script>
</body>

</html>