<?php

// Absolute path ke root project
define('BASE_PATH', __DIR__);

// Base URL (sesuaikan dengan folder di htdocs kamu)
define('BASE_URL', 'http://localhost/sertifikat/');

// Load config
require_once BASE_PATH . '/config/config.php';

// Autoload composer (kalau pakai)
if (file_exists(BASE_PATH . '/vendor/autoload.php')) {
    require_once BASE_PATH . '/vendor/autoload.php';
}

// Set error reporting (dev mode)
error_reporting(E_ALL);
ini_set('display_errors', 1);
