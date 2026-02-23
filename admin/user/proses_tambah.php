<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

if (isset($_POST['submit'])) {

    // ================================
    // AMBIL DATA DARI FORM + TRIM
    // ================================
    $nama     = trim($_POST['nama'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = trim($_POST['role'] ?? '');
    $status   = trim($_POST['status'] ?? '');

    // ======================
    // VALIDASI WAJIB
    // ======================
    if ($nama === '' || $email === '' || $password === '' || $role === '' || $status === '') {
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
    // HASH PASSWORD (WAJIB)
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
        INSERT INTO users 
        (nama, email, password, role, status)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("ssssi", $nama, $email, $password_hash, $role, $status);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Data user berhasil ditambahkan!";
        header("Location:" . BASE_URL . "admin/user/index.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal menyimpan data user.";
        header("Location:" . BASE_URL . "admin/user/index.php");
        exit;
    }
}