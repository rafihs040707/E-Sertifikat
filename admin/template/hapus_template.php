<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
session_start();
require_once BASE_PATH . '/config/config.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['error'] = "ID template tidak ditemukan.";
    header("Location:" . BASE_URL . "admin/template/data_template.php");
    exit;
}

// ambil data template dulu untuk dapat nama file gambarnya
$query = mysqli_query($conn, "SELECT tampak_depan FROM template WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    $_SESSION['error'] = "Template tidak ditemukan.";
    header("Location:" . BASE_URL . "admin/template/data_template.php");
    exit;
}

// path file gambar
$filePath = BASE_PATH . "/uploads/template/" . $data['tampak_depan'];

// hapus data dari database
$delete = mysqli_query($conn, "DELETE FROM template WHERE id='$id'");

if ($delete) {

    // hapus file jika ada
    if (!empty($data['tampak_depan']) && file_exists($filePath)) {
        unlink($filePath);
    }

    $_SESSION['success'] = "Template berhasil dihapus.";
    header("Location:" . BASE_URL . "admin/template/data_template.php");
    exit;

} else {
    $_SESSION['error'] = "Template gagal dihapus.";
    header("Location:" . BASE_URL . "admin/template/data_template.php");
    exit;
}
?>
