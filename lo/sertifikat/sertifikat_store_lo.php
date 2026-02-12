<?php
$allowed_roles = ["lo"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/auth/cek_login.php';

if (isset($_POST['submit'])) {

    $nama        = $_POST['nama'];
    $kegiatan    = $_POST['pelatihan'];
    $periode_awal  = $_POST['periode_awal'];  
    $periode_akhir = $_POST['periode_akhir']; 
    $issued_date  = $_POST['issued_date'];    
    $status       = $_POST['status'];
    $template_id  = $_POST['template_id'];

    // simpan ke database (tanpa format periode)
    $stmt = $conn->prepare("
        INSERT INTO sertifikat 
        (nama, pelatihan, periode_awal, periode_akhir, issued_date, status, template_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("ssssssi", $nama, $kegiatan, $periode_awal, $periode_akhir, $issued_date, $status, $template_id);

    session_start();

    if ($stmt->execute()) {
        $last_id = $conn->insert_id;

        $_SESSION['success'] = "Data sertifikat berhasil ditambahkan dan tersimpan!";

        header("Location:" . BASE_URL . "lo/sertifikat/data_sertifikat_lo.php?id=$last_id");
        exit;
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat menyimpan data. Silakan ulangi kembali!";

        header("Location:" . BASE_URL . "lo/sertifikat/data_sertifikat_lo.php");
        exit;
    }
}
