<?php
$allowed_roles = ["admin"]; // superadmin otomatis lolos
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/auth/permission.php';
require_once BASE_PATH . '/config/config.php';


if (!can('user.delete')) {
    die("Akses ditolak");
}

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['error'] = "ID tidak ditemukan.";
    header("Location: ../../admin/user/index.php");
    exit;
}

// Ambil target
$data_target = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT role FROM users WHERE id='$id'")
);

// Admin tidak boleh hapus superadmin
if ($_SESSION['role'] === 'admin' && $data_target['role'] === 'superadmin') {
    die('Tidak boleh menghapus superadmin');
}

$delete = mysqli_query($conn, "DELETE FROM users WHERE id='$id'");

if ($delete) {
    $_SESSION['success'] = "Data berhasil dihapus.";
} else {
    $_SESSION['error'] = "Data gagal dihapus.";
}

header("Location: ../../admin/user/index.php");
exit;
