<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

if (isset($_POST['submit'])) {

    $nama_pelatihan        = $_POST['nama_pelatihan'];
    $deskripsi    = $_POST['deskripsi'];
    $status       = $_POST['status'];

    // simpan ke database (tanpa format periode)
    $stmt = $conn->prepare("
        INSERT INTO pelatihan 
        (nama_pelatihan, deskripsi, status)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param("ssi", $nama_pelatihan, $deskripsi, $status);


    if ($stmt->execute()) {
        $last_id = $conn->insert_id;

        $_SESSION['success'] = "Data pelatihan berhasil ditambahkan dan tersimpan!";

        header("Location:" . BASE_URL . "admin/pelatihan/index.php?id=$last_id");
        exit;
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat menyimpan data. Silakan ulangi kembali!";

        header("Location:" . BASE_URL . "admin/pelatihan/index.php");
        exit;
    }
}
