<?php
include 'header_admin.php';
include 'config.php';
?>

<head>
    <title>Data Sertifikat</title>
</head>

<div class="container">
    <h2 class="my-2 ms-3">Data Sertifikat</h2>
    <form action="#" method="GET" class="col-sm-3 mb-3 ms-4 mt-4">
        <label for="cari" class="ms-3">Masukkan Kata Kunci:</label>
        <div class="d-inline-flex ms-2">
            <input class="form-control form-control-ms" type="text" id="cari" name="cari" placeholder="Cari">
            <button type="submit" class="btn btn-secondary ms-3">Cari</button>
        </div>
    </form>
    <a href="./tambah_sertifikat.php" class="btn btn-primary btn-sm text-decoration-none text-white ms-4 mt-2 mb-4">Tambah Data Sertifikat</a>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $batas = 5;
                $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

                $previous = $halaman - 1;
                $next = $halaman + 1;

                $data = mysqli_query($conn, "select * from sertifikat");
                $jumlah_data = mysqli_num_rows($data);
                $total_halaman = ceil($jumlah_data / $batas);

                $data_sertifikat = mysqli_query($conn, "select * from sertifikat limit $batas OFFSET $halaman_awal");
                $nomor = $halaman_awal + 1;
                while ($sertifikat = mysqli_fetch_array($data_sertifikat)) {
                ?>
                    <tr>
                        <th><?php echo $nomor++; ?></th>
                        <td><?php echo $sertifikat['nama']; ?></td>
                        <td><?php echo $sertifikat['pelatihan']; ?></td>
                        <td><?php echo $sertifikat['periode']; ?></td>
                        <td><?php echo $sertifikat['issued_date']; ?></td>
                        <td>
                            <a href="edit_sertifikat.php?id=<?= $sertifikat['id']; ?>" class="btn btn-sm btn-info text-white">Edit</a>
                            <a href="hapus_sertifikat.php?id=<?= $sertifikat['id']; ?>" class="btn btn-sm btn-danger text-white" onclick="return confirm('Apakah yakin data sertifikat ini akan dihapus?');">Hapus</a>
                            <a href="#" class="btn btn-sm btn-secondary text-white">Preview</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>


    <!-- CARD (MOBILE) -->
    <?php $data_sertifikat = mysqli_query($conn, "select * from sertifikat");
    while ($sertifikat = mysqli_fetch_array($data_sertifikat)) { ?>
        <div class="d-block d-md-none">
            <div class="card mb-2 border-primary shadow-sm">
                <div class="card-body p-2">

                    <!-- Header -->
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold"><?php echo $sertifikat['nama']; ?></div>
                    </div>

                    <div class="text-muted small">Pelatihan: <?php echo $sertifikat['pelatihan']; ?></div>
                    <hr class="my-2">

                    <!-- Detail -->
                    <div class="small">
                        <div><strong>Periode:</strong> <?php echo $sertifikat['periode']; ?></div>
                        <div><strong>Issued Date:</strong> <?php echo $sertifikat['issued_date']; ?></div>
                    </div>

                    <!-- Action -->
                    <div class="d-flex gap-1 mt-2">
                        <a href="edit_sertifikat.php?id=<?= $sertifikat['id']; ?>" class="btn btn-sm btn-info text-white w-100">Edit</a>
                        <a href="hapus_sertifikat.php?id=<?= $sertifikat['id']; ?>" class="btn btn-sm btn-danger text-white w-100" onclick="return confirm('Apakah yakin data template ini akan dihapus?');">Hapus</a>
                        <a href="#" class="btn btn-sm btn-secondary text-white w-100">Preview</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>





<script src="./vendor/bs.bundle.min.js"></script>
</body>

</html>