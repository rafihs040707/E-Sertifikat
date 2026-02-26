<?php
$allowed_roles = ["admin"]; // superadmin otomatis lolos
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

if (isset($_POST['submit'])) {

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
    // VALIDASI ROLE BERDASARKAN LOGIN
    // ======================
    $login_role = $_SESSION['role'];

    if ($login_role === 'admin') {
        if ($role !== 'lo') {
            die("Akses ditolak. Admin hanya boleh membuat LO.");
        }
    }

    if ($login_role === 'superadmin') {
        $allowed_create = ['admin', 'lo', 'superadmin'];
        if (!in_array($role, $allowed_create)) {
            die("Role tidak valid.");
        }
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
        INSERT INTO users (nama, email, password, role, status)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("ssssi", $nama, $email, $password_hash, $role, $status);

    if ($stmt->execute()) {
        $_SESSION['success'] = "User berhasil ditambahkan!";
    } else {
        $_SESSION['error'] = "Gagal menyimpan data.";
    }

    header("Location:" . BASE_URL . "admin/user/index.php");
    exit;
}

die("Akses tidak valid.");