<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

if (isset($_POST['submit'])) {

    // ================================
    // AMBIL DATA DARI FORM + TRIM
    // ================================

    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = trim($_POST['role'] ?? '');

    // ======================
    // VALIDASI WAJIB
    // ======================
    if ($nama === '' || $email === '' || $password === '' || $role === '') {
        $_SESSION['error'] = "Semua field wajib diisi!";
        header("Location:" . BASE_URL . "admin/user/index.php");
        exit;
    }

    // ======================
    // VALIDASI EMAIL
    // ======================
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid!";
        header("Location:" . BASE_URL . "admin/user/index.php");
        exit;
    }

    // ======================
    // HASH PASSWORD
    // ======================
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // ======================
    // CEK EMAIL DUPLIKAT
    // ======================
    $cek = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $_SESSION['error'] = "Email sudah terdaftar!";
        header("Location:" . BASE_URL . "admin/user/index.php");
        exit;
    }

    // ======================
    // INSERT
    // ======================
    $stmt = $conn->prepare("
        INSERT INTO users (nama, email, password, role)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("ssss", $nama, $email, $password_hash, $role);

    if ($stmt->execute()) {
        $_SESSION['success'] = "User berhasil ditambahkan!";
    } else {
        $_SESSION['error'] = "Gagal menyimpan data.";
    }

    header("Location:" . BASE_URL . "admin/user/index.php");
    exit;
}

die("Akses tidak valid.");