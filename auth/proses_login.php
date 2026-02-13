<?php
session_start();

require_once __DIR__ . '/../bootstrap.php';
require_once BASE_PATH . '/config/config.php';

// menangkap data yang dikirim dari form login
$email = $_POST['email'];
$password = md5($_POST['password']);


// menyeleksi data user dengan email dan password yang sesuai
$login = mysqli_query($conn, "select * from users where email='$email' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// cek apakah email dan password di temukan pada database
if ($cek > 0) {

    $data = mysqli_fetch_assoc($login);

    // cek jika user login sebagai admin
    if ($data['role'] == "admin") {

        // buat session login dan email
        $_SESSION['email'] = $email;
        $_SESSION['role'] = "admin";
        // alihkan ke halaman dashboard admin
        header("location:" . BASE_URL . "admin/dashboard.php");

        // cek jika user login sebagai lo
    } else if ($data['role'] == "lo") {
        // buat session login dan email
        $_SESSION['email'] = $email;
        $_SESSION['role'] = "lo";
        // alihkan ke halaman dashboard lo
        header("location:" . BASE_URL . "lo/dashboard.php");
        exit;

    }else {
        // alihkan ke halaman login kembali
        header("location:" . BASE_URL . "index.php?pesan=gagal");
        exit;
    }
} else {
    header("location:" . BASE_URL . "index.php?pesan=gagal");
    exit;
}
