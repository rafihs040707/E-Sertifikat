<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_POST['submit'])) {
    die("Akses dilarang...");
}

// ======================
// AMBIL + SANITIZE
// ======================
$id           = (int)($_POST['id'] ?? 0);
$nama         = trim($_POST['nama'] ?? '');
$pelatihan    = (int)($_POST['pelatihan'] ?? 0);
$periode_awal = trim($_POST['periode_awal'] ?? '');
$periode_akhir= trim($_POST['periode_akhir'] ?? '');
$issued_date  = trim($_POST['issued_date'] ?? '');
$status       = (int)($_POST['status'] ?? 0);
$template_id  = (int)($_POST['template_id'] ?? 0);

// ======================
// VALIDASI WAJIB
// ======================
if (
    !$id ||
    $nama === '' ||
    !$pelatihan ||
    $periode_awal === '' ||
    $periode_akhir === '' ||
    $issued_date === '' ||
    !$template_id
) {
    $_SESSION['error'] = "Semua field wajib diisi.";
    header("Location: " . BASE_URL . "admin/sertifikat/index.php");
    exit;
}

// validasi tanggal
if ($periode_akhir < $periode_awal) {
    $_SESSION['error'] = "Periode akhir tidak boleh lebih kecil dari periode awal.";
    header("Location: " . BASE_URL . "admin/sertifikat/index.php");
    exit;
}

// ======================
// PREPARE UPDATE
// ======================
$stmt = $conn->prepare("
    UPDATE sertifikat 
    SET nama = ?, 
        pelatihan_id = ?, 
        periode_awal = ?, 
        periode_akhir = ?, 
        issued_date = ?,
        template_id = ?
    WHERE id = ?
");

if (!$stmt) {
    $_SESSION['error'] = "Prepare statement gagal.";
    header("Location: " . BASE_URL . "admin/sertifikat/index.php");
    exit;
}

$stmt->bind_param(
    "sisssii",
    $nama,
    $pelatihan,
    $periode_awal,
    $periode_akhir,
    $issued_date,
    $template_id,
    $id
);

// ======================
// EKSEKUSI
// ======================
if ($stmt->execute()) {
    $_SESSION['success'] = "Data berhasil diperbarui.";
} else {
    $_SESSION['error'] = "Data gagal diperbarui.";
}

header("Location: " . BASE_URL . "admin/sertifikat/index.php");
exit;