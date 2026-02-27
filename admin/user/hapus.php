<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['error'] = "ID pelatihan tidak ditemukan.";
    header("Location:" . BASE_URL . "admin/user/index.php");
    exit;
}

$delete = mysqli_query($conn, "DELETE FROM users WHERE id='$id'");

if ($delete) {
    $_SESSION['success'] = "Data user berhasil dihapus.";
} else {
    $_SESSION['error'] = "Data user gagal dihapus.";
}

header("Location:" . BASE_URL . "admin/user/index.php");
exit;
