<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian</title>
    <link rel="stylesheet" href="./vendor/bs.min.css">
</head>
<body>

<a href="data_sertifikat.php" class="btn btn-secondary text-decoration-none text-white m-4">Kembali Ke Data
    Sertifikat</a>

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
                        <a href="edit_sertifikat.php" class="btn btn-sm btn-info text-white">Edit</a>
                        <a href="#" class="btn btn-sm btn-danger text-white">Hapus</a>
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
                    <a href="edit_sertifikat.php" class="btn btn-sm btn-info text-white w-100">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger text-white w-100">Hapus</a>
                    <a href="#" class="btn btn-sm btn-secondary text-white w-100">Preview</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="./vendor/bs.bundle.min.js"></script>
</body>
</html>