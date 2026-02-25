<?php 
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/admin/header.php';
?>

<head>
    <title>Tambah Data Pelatihan</title>
</head>

<h2 class="ms-5 my-4">Tambah Data pelatihan</h2>

<form action="<?= BASE_URL ?>admin/pelatihan/proses_tambah.php" method="POST" class="mx-4" enctype="multipart/form-data">

    <div class="mb-2">
        <label for="nama_pelatihan" class="form-label ms-3">Nama Pelatihan: </label>
        <input type="text" name="nama_pelatihan" placeholder="Example: Front-End" class="form-control"
            maxlength="255" required><br>
    </div>

    <div class="mb-2">
        <label for="deskripsi" class="form-label ms-3">Deskripsi: </label>
        <input type="text" name="deskripsi" placeholder="Example: Belajar membuat tampilan menarik" class="form-control"
            maxlength="255"><br>
    </div>

    <div class="mb-4">
        <label for="status" class="form-label ms-3">Status: </label>
        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="status" required>
            <option selected disabled>Pilih Status</option>
            <option value="1">Aktif</option>
            <option value="0">Nonaktif</option>
        </select>
    </div>

    <div class="d-grid gap-2 d-flex justify-content-center mt-3">
        <button type="submit" name="submit" class="btn btn-primary ms-2 col-3">Submit</button>
        <button type="reset" class="btn btn-warning ms-2 col-3">Reset Form</button>
        <a href="<?= BASE_URL ?>admin/pelatihan/index.php" style="background-color: #6C7301;"
            class="btn text-decoration-none text-white">Kembali Ke Halaman
            Pelatihan</a>
    </div>
</form>





</div>
</div>
</div>

<script src="<?= BASE_URL ?>vendor/bs.bundle.min.js"></script>
<script src="<?= BASE_URL ?>vendor/sidebar.js"></script>

</body>

</html>