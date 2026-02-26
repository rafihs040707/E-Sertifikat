<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>vendor/bs.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>vendor/style.css">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>image/logo.png">
</head>

<body>

    <nav>
        <div class="layout-wrapper">
            <div id="sidebarOverlay" class="sidebar-overlay">

                <!-- ============ SIDEBAR ============ -->
                <div id="sidebar" class="sidebar d-flex flex-column p-3 text-white">
                    <div class="sidebar-header">
                        <a href="<?= BASE_URL ?>admin/dashboard.php" class="d-flex align-items-center text-white text-decoration-none">
                            <img src="<?= BASE_URL ?>image/logo.png" width="40">
                            <span class="fs-4 ms-2 brand-text">Rekhatama</span>
                        </a>
                        <span id="closeSidebar" class="sidebar-close d-md-none" aria-label="Close">✕</span>
                    </div>

                    <hr>

                    <ul class="nav nav-pills flex-column mb-auto">

                        <!-- BERANDA -->
                        <li class="nav-item">
                            <a href="<?= BASE_URL ?>admin/dashboard.php"
                                class="nav-link text-white d-flex align-items-center <?= $current == 'index.php' ? 'active' : '' ?>"
                                data-bs-toggle="tooltip" data-bs-placement="right" title="Beranda">
                                <img src="<?= BASE_URL ?>image/home.png" width="20px" class="me-2">
                                <span class="menu-text">Beranda</span>
                            </a>
                        </li>

                        <!-- SERTIFIKAT -->
                        <li>
                            <a href="<?= BASE_URL ?>admin/sertifikat/index.php"
                                class="nav-link text-white d-flex align-items-center <?= $current == 'admin/sertifikat/index.php' ? 'active' : '' ?>"
                                data-bs-toggle="tooltip" data-bs-placement="right" title="Sertifikat">
                                <img src="<?= BASE_URL ?>image/certificate.png" width="20px" class="me-2">
                                <span class="menu-text">Sertifikat</span>
                            </a>
                        </li>

                        <!-- PELATIHAN -->
                        <li>
                            <a href="<?= BASE_URL ?>admin/pelatihan/index.php"
                                class="nav-link text-white d-flex align-items-center <?= $current == 'admin/pelatihan/index.php' ? 'active' : '' ?>"
                                data-bs-toggle="tooltip" data-bs-placement="right" title="Pelatihan">
                                <img src="<?= BASE_URL ?>image/pelatihan.png" width="20px" class="me-2">
                                <span class="menu-text">Pelatihan</span>
                            </a>
                        </li>

                        <!-- TEMPLATE -->
                        <li>
                            <a href="<?= BASE_URL ?>admin/template/index.php"
                                class="nav-link text-white d-flex align-items-center <?= $current == 'admin/template/index.php' ? 'active' : '' ?>"
                                data-bs-toggle="tooltip" data-bs-placement="right" title="Template">
                                <img src="<?= BASE_URL ?>image/template.png" width="20px" class="me-2">
                                <span class="menu-text">Template</span>
                            </a>
                        </li>

                        <!-- MANAJEMEN USER -->
                        <li>
                            <a href="<?= BASE_URL ?>admin/user/index.php"
                                class="nav-link text-white d-flex align-items-center <?= $current == 'admin/user/index.php' ? 'active' : '' ?>"
                                data-bs-toggle="tooltip" data-bs-placement="right" title="Manajemen User">
                                <img src="<?= BASE_URL ?>image/user.png" width="20px" class="me-2">
                                <span class="menu-text">Manajemen User</span>
                            </a>
                        </li>

                    </ul>

                    <hr>

                    <a class="nav-link text-white" href="<?= BASE_URL ?>auth/logout.php"
                        onclick="return confirm('Apakah anda akan keluar?');" data-bs-toggle="tooltip" title="Logout">
                        <img src="<?= BASE_URL ?>image/logout.png" width="20px" class="me-2">
                        <span class="menu-text">Logout</span>
                    </a>

                </div>
                <!-- ============ END SIDEBAR ============ -->
    </nav>



    <!-- ============ MAIN OPEN ============ -->
    <div id="mainContent" class="main-content">

        <button id="toggleSidebar" class="btn btn-success mb-3 d-block d-md-none">☰ Menu</button>