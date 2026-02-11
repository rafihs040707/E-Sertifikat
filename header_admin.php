<?php
$allowed_roles = ["admin"];
include "cek_login.php";?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./vendor/bs.min.css">
    <link rel="stylesheet" href="./vendor/bs-icon.css">
    <link rel="stylesheet" href="./vendor/style.css">
    <link rel="icon" type="image/png" href="./image/logo.png">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0D492D;">
        <div class="container-fluid">
            <a class="navbar-brand" href="./dashboard_admin.php"><img src="./image/logo.png"
                    style="width: 40px; height: auto;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white active" aria-current="page" href="./dashboard_admin.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./data_sertifikat.php">Data Sertifikat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./data_template.php">Data Template</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white active" aria-current="page" name="logout" href="logout.php" onclick="return confirm('Apakah anda akan keluar?');">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>