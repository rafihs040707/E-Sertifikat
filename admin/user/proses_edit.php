<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

if (isset($_POST['update'])) {

    $id           = $_POST['id'];
    $nama         = $_POST['nama'];
    $email        = $_POST['email'];
    $role         = $_POST['role'];
    $status       = $_POST['status'];

    $stmt = $conn->prepare("
        UPDATE users 
        SET nama = ?, 
            email = ?, 
            role = ?, 
            status = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "sssii",
        $nama,
        $email,
        $role,
        $status,
        $id
    );

    if ($stmt->execute()) {
        $_SESSION['success'] = "Data berhasil diperbarui!";
        header("Location: " . BASE_URL . "/admin/user/index.php");
        exit;
    } else {
        $_SESSION['error'] = "Data gagal diperbarui. Silakan coba lagi!";
        header("Location: " . BASE_URL . "/admin/user/index.php");
        exit;
    }
} else {
    die("Akses dilarang...");
}
