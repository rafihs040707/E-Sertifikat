<?php include 'header_lo.php'; ?>

<head>
    <title>Data Sertifikat</title>
</head>

<div class="container">
    <h2 class="my-2 ms-3">Data Sertifikat</h2>
    <form action="#" method="GET" class="col-sm-3 mb-3 ms-4 mt-4">
        <label for="cari" class="ms-3">Masukkan Kata Kunci:</label>
        <div class="d-inline-flex ms-2">
            <input class="form-control form-control-ms" type="text" id="cari" name="cari" placeholder="Cari"
                required>
            <button type="submit" class="btn btn-secondary ms-3">Cari</button>
        </div>
    </form>
    <a href="./tambah_sertifikat_lo.php" class="btn btn-primary btn-sm text-decoration-none text-white ms-4 mt-2 mb-4">Tambah Data Sertifikat</a>
</div>

<div class="container">

    <!-- TABEL (DESKTOP & TABLET) -->
    <div class="table-responsive d-none d-md-block">
        <table class="table table-sm table-bordered border-primary table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Pelatihan</th>
                    <th>Periode</th>
                    <th>Issued Date</th>
                    <th>No Sertifikat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>1</th>
                    <td>Arkan Beckham</td>
                    <td>Cyber Security</td>
                    <td>March 12 - 20, 2025</td>
                    <td>March 20, 2025</td>
                    <td>CERT-2025-00123</td>
                    <td><span class="badge bg-success">Valid</span></td>
                    <td>
                        <a href="edit_sertifikat_lo.php" class="btn btn-sm btn-info text-white">Edit</a>
                        <a href="#" class="btn btn-sm btn-secondary text-white">Preview</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    <!-- CARD (MOBILE) -->
    <div class="d-block d-md-none">
        <div class="card mb-2 border-primary shadow-sm">
            <div class="card-body p-2">

                <!-- Header -->
                <div class="d-flex justify-content-between">
                    <div class="fw-bold">Arkan Beckham</div>
                    <span class="badge bg-success">Valid</span>
                </div>

                <div class="text-muted small">Pelatihan: Cyber Security</div>
                <hr class="my-2">

                <!-- Detail -->
                <div class="small">
                    <div><strong>Periode:</strong> March 12 - 20, 2025</div>
                    <div><strong>Issued Date:</strong> March 20, 2025</div>
                    <div><strong>No Sertifikat:</strong> CERT-2025-00123</div>
                </div>

                <!-- Action -->
                <div class="d-flex gap-1 mt-2">
                    <a href="edit_sertifikat_lo.php" class="btn btn-sm btn-info text-white w-100">Edit</a>
                    <a href="#" class="btn btn-sm btn-secondary text-white w-100">Preview</a>
                </div>
            </div>
        </div>
    </div>
</div>





<script src="./vendor/bs.bundle.min.js"></script>
</body>

</html>