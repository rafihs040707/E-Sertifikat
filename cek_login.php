<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// batas waktu idle (10 menit = 600 detik)
$timeout = 1800;

// cek apakah sudah login
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}

// cek timeout session
if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > $timeout) {
        session_unset();
        session_destroy();
        header("Location: index.php?pesan=timeout");
        exit;
    }
}

// update waktu aktivitas terakhir
$_SESSION['last_activity'] = time();

// role check
if (isset($allowed_roles) && is_array($allowed_roles)) {
    if (!in_array($_SESSION['role'], $allowed_roles)) {
        header("Location: index.php?pesan=akses_ditolak");
        exit;
    }
}
?>
