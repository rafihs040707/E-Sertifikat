<?php
$allowed_roles = ["admin", "lo"];
require_once __DIR__ . '/../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

$id = $_GET['id'] ?? null;

if (!$id || !ctype_digit($id)) {
    die("ID tidak valid");
}

// ambil data sertifikat (AMAN)
$stmt = mysqli_prepare($conn, "SELECT * FROM sertifikat WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data sertifikat tidak ditemukan");
}

if (empty($data['file_sertifikat'])) {
    die("Sertifikat belum digenerate");
}

// lokasi file pdf (AMAN)
$baseDir  = realpath(BASE_PATH . "/uploads/sertifikat/");
$filePath = realpath($baseDir . "/" . $data['file_sertifikat']);
if (!file_exists($filePath)) {
    die("File tidak ditemukan");
}
if (!$filePath || strpos($filePath, $baseDir) !== 0 || !file_exists($filePath)) {
    die("File PDF tidak ditemukan di folder uploads/sertifikat/");
}

// bersihkan buffer (PENTING)
if (ob_get_length()) {
    ob_end_clean();
}

// paksa download
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
header("Content-Length: " . filesize($filePath));
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

readfile($filePath);
exit;
?>