<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

if (isset($_POST['update'])) {

    $id           = $_POST['id'];
    $nama_pelatihan         = $_POST['nama_pelatihan'];
    $deskripsi    = $_POST['deskripsi'];
    $status       = $_POST['status'];

    $stmt = $conn->prepare("
        UPDATE pelatihan 
        SET nama_pelatihan = ?, 
            deskripsi = ?, 
            status = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssii",
        $nama_pelatihan,
        $deskripsi,
        $status,
        $id
    );

    session_start();

    if ($stmt->execute()) {
        $_SESSION['success'] = "Data berhasil diperbarui!";
        header("Location: " . BASE_URL . "/admin/pelatihan/index.php");
        exit;
    } else {
        $_SESSION['error'] = "Data gagal diperbarui. Silakan coba lagi!";
        header("Location: " . BASE_URL . "/admin/pelatihan/index.php");
        exit;
    }
} else {
    die("Akses dilarang...");
}
