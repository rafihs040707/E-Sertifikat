<?php
require_once __DIR__ . '/../bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ======================
// HAPUS SEMUA DATA SESSION
// ======================
$_SESSION = [];

// ======================
// HAPUS COOKIE SESSION
// ======================
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// ======================
// DESTROY SESSION
// ======================
session_destroy();

// ======================
// REDIRECT
// ======================
header("Location: " . BASE_URL . "index.php?logout=berhasil");
exit;