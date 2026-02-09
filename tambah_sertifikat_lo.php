<?php include 'header_lo.php'; ?>

<head>
    <title>Tambah Data Sertifikat</title>
</head>

<h2 class="ms-5 my-4">Tambah Data Sertifikat</h2>

<form action="#" method="POST" class="mx-4">

    <div class="mb-4">
        <label for="nama" class="form-label ms-3">Nama: </label>
        <input type="text" name="nama" placeholder="Example: Arkan Beckham" class="form-control" maxlength="64"
            required>
    </div>

    <div class="mb-4">
        <label for="pelatihan" class="form-label ms-3">Pelatihan: </label>
        <input type="text" name="pelatihan" placeholder="Example: Cyber Security" class="form-control"
            maxlength="64" required>
    </div>

    <div class="mb-4">
        <label for="periode_akhir" class="form-label ms-3">Periode Akhir: </label>
        <input type="date" name="periode_akhir" class="form-control" required onfocus="this.showPicker()">
    </div>

    <div class="mb-4">
        <label for="issued_date" class="form-label ms-3">Issued Date: </label>
        <input type="date" name="issued_date" class="form-control" required onfocus="this.showPicker()">
    </div>

    <div class="mb-4">
        <label for="issued_date" class="form-label ms-3">Issued Date: </label>
        <input type="date" name="issued_date" class="form-control" required onfocus="this.showPicker()">
    </div>

    <div class="mb-4">
        <label for="template" class="form-label ms-3">Template: </label>
        <select for="template" name="template" class="form-select form-select-md"
            aria-label=".form-select-md example" required>
            <option value="" disabled selected>Pilih Template</option>
            <option value="Template 1">Template 1</option>
            <option value="Template 2">Template 2</option>
        </select>
    </div>

    <div class="mb-4">
        <label for="status" class="form-label ms-3">Status: </label>
        <select for="status" name="status" class="form-select form-select-md"
            aria-label=".form-select-md example" required>
            <option value="" disabled selected>Pilih Status</option>
            <option value="Valid">Valid</option>
            <option value="Tidak Valid">Tidak Valid</option>
        </select>
    </div>

    <div class="d-grid gap-2 d-flex justify-content-center mt-3 pb-5">
        <button type="submit" name="submit" class="btn btn-primary ms-2 col-3">Submit</button>
        <button type="reset" class="btn btn-warning ms-2 col-3">Reset Form</button>
        <a href="./data_sertifikat_lo.php" style="background-color: #6C7301;"
            class="btn text-decoration-none text-white">Kembali Ke Halaman
            Sertifikat</a>
    </div>
</form>





<script src="./vendor/bs.bundle.min.js"></script>
</body>

</html>