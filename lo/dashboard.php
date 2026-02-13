<?php 
$allowed_roles = ["lo"];
require_once __DIR__ . '/../bootstrap.php';
require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/lo/header.php';
require_once BASE_PATH . '/auth/cek_login.php';

$data_sertifikat = mysqli_query($conn, "SELECT * FROM sertifikat");
$jumlah_sertifikat = mysqli_num_rows($data_sertifikat);

?>

<head>
    <title>Dashboard Liaison Officer</title>
</head>

<div class="container mt-3">
    <div class="jumbotron">
        <h1 class="text-center">Selamat, Anda Berhasil Login.! <br> Sebagai <?php $p = $_SESSION['role'];
                                                                    echo $p; ?></h1>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-3 mt-4">
                    <div class="card">
                        <div class="card-body text-center" style="background-color: #F5CF24;">
                            <img src="<?= BASE_URL ?>image/iconmedali.png" class="ukuran my-3">
                            <h3 class="my-2"><?php echo $jumlah_sertifikat ?></h3>
                            <h5 class="my-3">Sertifikat</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?= BASE_URL ?>vendor/bs.bundle.min.js"></script>
</body>

</html>