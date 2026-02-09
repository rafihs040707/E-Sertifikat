<?php include 'header_admin.php';
include 'config.php';

$id = $_GET['id'];
$data_sertifikat = mysqli_query($conn, "SELECT * FROM sertifikat WHERE id='$id'");
$sertifikat = mysqli_fetch_assoc($data_sertifikat);
?>

<head>
    <title>Edit Data Sertifikat</title>
</head>

<h2 class="ms-5 my-4">Edit Data Sertifikat</h2>

<form action="proses_edit_sertifikat.php" method="POST" class="mx-4">

    <input type="hidden" name="id" value="<?= $template['id']; ?>">
    <input type="hidden" name="periode_awal_lama" value="<?= $template['periode_awal']; ?>">
    <input type="hidden" name="periode_akhir_lama" value="<?= $template['periode_akhir']; ?>">


    <div class="mb-4">
        <label for="nama" class="form-label ms-3">Nama: </label>
        <input type="text" name="nama" value="<?= $sertifikat['nama']; ?>" class="form-control" maxlength="64">
    </div>

    <div class="mb-4">
        <label for="pelatihan" class="form-label ms-3">Pelatihan: </label>
        <input type="text" name="pelatihan" value="<?= $sertifikat['pelatihan']; ?>" class="form-control"
            maxlength="64">
    </div>

    <div class="mb-4">
        <label for="periode_awal" class="form-label ms-3">Periode Awal: </label>
        <input type="date" name="periode_awal" class="form-control" onfocus="this.showPicker()">
    </div>

    <div class="mb-4">
        <label for="periode_akhir" class="form-label ms-3">Periode Akhir: </label>
        <input type="date" name="periode_akhir" class="form-control" onfocus="this.showPicker()">
    </div>


    <div class="mb-4">
        <label for="issued_date" class="form-label ms-3">Issued Date: </label>
        <input type="date" name="issued_date" class="form-control" onfocus="this.showPicker()">
    </div>

    <div class="d-grid gap-2 d-flex justify-content-center mt-3 pb-5">
        <button type="submit" name="submit" class="btn btn-primary ms-2 col-3">Submit</button>
        <a href="./data_sertifikat.php" style="background-color: #6C7301;"
            class="btn text-decoration-none text-white">Kembali Ke Halaman
            Sertifikat</a>
    </div>
</form>





<script src="./vendor/bs.bundle.min.js"></script>
</body>

</html>