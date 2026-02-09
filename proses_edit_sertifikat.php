<?php

include("config.php");

// cek apakah tombol submit sudah diklik atau blum?
if(isset($_POST['submit'])){

    // ambil data dari formulir
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $pelatihan = $_POST['pelatihan'];
    $periode_awal = $_POST['periode_awal'];
    $periode_akhir = $_POST['periode_akhir'];
    $issued_date = $_POST['issued_date'];

    // buat query update
    $sql = "UPDATE sertifikat SET nama = '$nama', pelatihan = '$pelatihan', periode_awal = '$periode_awal', 'periode_akhir' = '$periode_akhir', 'issued_date' = '$issued_date' WHERE id=$id";
    $query = mysqli_query($conn, $sql);

    // apakah query update berhasil?
    if( $query ) {
        // kalau berhasil alihkan ke halaman data_sertifikat.php
        header('Location: data_sertifikat.php');
    } else {
        // kalau gagal tampilkan pesan
        die("Gagal menyimpan perubahan...");
    }


} else {
    die("Akses dilarang...");
}

?>