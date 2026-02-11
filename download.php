<?php
$allowed_roles = ["admin", "lo"];
include "cek_login.php";
include "config.php";

$id = $_GET['id'] ?? null;
if (!$id) die("ID tidak ditemukan");

// ambil data sertifikat
$q = mysqli_query($conn, "SELECT * FROM sertifikat WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

if (!$data) die("Data sertifikat tidak ditemukan");
if (empty($data['file_sertifikat'])) die("File sertifikat belum dibuat");

// lokasi file pdf
$filePath = "uploads/sertifikat/" . $data['file_sertifikat'];

if (!file_exists($filePath)) {
    die("File PDF tidak ditemukan di folder uploads/sertifikat/");
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
