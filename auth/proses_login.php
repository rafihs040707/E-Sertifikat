<?php
session_start();

require_once __DIR__ . '/../bootstrap.php';
require_once BASE_PATH . '/config/config.php';

// ======================
// AMBIL INPUT
// ======================
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// ======================
// VALIDASI DASAR
// ======================
if ($email === '' || $password === '') {
    header("location:" . BASE_URL . "index.php?pesan=gagal");
    exit;
}

// ======================
// AMBIL USER BERDASARKAN EMAIL
// ======================
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$data   = $result->fetch_assoc();

// ======================
// VERIFIKASI LOGIN
// ======================
if ($data && password_verify($password, $data['password'])) {

    // ======================
    // LOGIN SUKSES
    // ======================
    session_regenerate_id(true); // ⭐ anti session fixation

    $_SESSION['user_id'] = $data['id'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['role']  = $data['role'];
    $_SESSION['last_activity'] = time();

    // redirect berdasarkan role
    if ($data['role'] === "admin") {
        header("Location:" . BASE_URL . "admin/dashboard.php");
        exit;
    } elseif ($data['role'] === "lo") {
        header("Location:" . BASE_URL . "lo/dashboard.php");
        exit;
    } elseif ($data['role'] === "direktur") {
        header("Location:" . BASE_URL . "direktur/dashboard.php");
        exit;
    }

} else {
    header("Location:" . BASE_URL . "index.php?pesan=gagal");
    exit;
}