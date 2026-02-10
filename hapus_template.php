<?php
include "config.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID template tidak ditemukan");
}

// ambil data template dulu untuk dapat nama file gambarnya
$query = mysqli_query($conn, "SELECT tampak_depan FROM template WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Template tidak ditemukan");
}

// path file gambar
$filePath = "uploads/template/" . $data['tampak_depan'];

// hapus data dari database
$delete = mysqli_query($conn, "DELETE FROM template WHERE id='$id'");

if ($delete) {

    // hapus file jika ada
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    header("Location: data_template.php?pesan=hapus_berhasil");
    exit;
} else {
    die("Gagal menghapus template");
}
?>
