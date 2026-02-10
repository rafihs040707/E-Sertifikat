<?php
include "config.php";

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

    if ($stmt->execute()) {
        $last_id = $conn->insert_id;

        header("Location: data_sertifikat_lo.php?id=$last_id");
        exit;
    } else {
        echo "Gagal menyimpan data: " . $stmt->error;
    }
}
