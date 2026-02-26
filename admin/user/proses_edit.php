<?php
$allowed_roles = ["admin"]; // superadmin otomatis lolos
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

if (!isset($_POST['update'])) {
    die("Akses dilarang...");
}

$id     = $_POST['id'] ?? null;
$nama   = $_POST['nama'] ?? '';
$email  = $_POST['email'] ?? '';
$status = $_POST['status'] ?? '';

if (!$id) {
    $_SESSION['error'] = "ID tidak ditemukan.";
    header("Location: " . BASE_URL . "admin/user/index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Ambil Data Lama (WAJIB untuk validasi)
|--------------------------------------------------------------------------
*/
$stmt_old = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt_old->bind_param("i", $id);
$stmt_old->execute();
$result_old = $stmt_old->get_result();
$data_lama = $result_old->fetch_assoc();

if (!$data_lama) {
    $_SESSION['error'] = "Data user tidak ditemukan.";
    header("Location: " . BASE_URL . "admin/user/index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| RULE 1: Admin tidak boleh edit superadmin
|--------------------------------------------------------------------------
*/
if ($_SESSION['role'] === 'admin' && $data_lama['role'] === 'superadmin') {
    die("Admin tidak boleh mengedit superadmin.");
}

/*
|--------------------------------------------------------------------------
| RULE 2: Admin tidak boleh mengubah role
|--------------------------------------------------------------------------
*/
if ($_SESSION['role'] === 'admin') {
    $role = $data_lama['role']; // pakai role lama
} else {
    $role = $_POST['role'] ?? $data_lama['role'];
}

/*
|--------------------------------------------------------------------------
| Update Data
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("
    UPDATE users 
    SET nama = ?, 
        email = ?, 
        role = ?, 
        status = ?
    WHERE id = ?
");

$stmt->bind_param(
    "sssii",
    $nama,
    $email,
    $role,
    $status,
    $id
);

if ($stmt->execute()) {
    $_SESSION['success'] = "Data berhasil diperbarui!";
} else {
    $_SESSION['error'] = "Data gagal diperbarui. Silakan coba lagi!";
}

header("Location: " . BASE_URL . "admin/user/index.php");
exit;