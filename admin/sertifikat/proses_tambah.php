<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

if (isset($_POST['submit'])) {

    // ambil + trim
    $nama = preg_replace('/\s+/', ' ', trim($_POST['nama'] ?? ''));
    $pelatihan_id = trim($_POST['pelatihan'] ?? '');
    $periode_awal = trim($_POST['periode_awal'] ?? '');
    $periode_akhir = trim($_POST['periode_akhir'] ?? '');
    $issued_date = trim($_POST['issued_date'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $template_id = trim($_POST['template_id'] ?? '');

    // ======================
    // VALIDASI WAJIB (WAJIB ADA)
    // ======================
    if (
        $nama === '' ||
        $pelatihan_id === '' ||
        $periode_awal === '' ||
        $periode_akhir === '' ||
        $issued_date === '' ||
        $status === '' ||
        $template_id === ''
    ) {
        $_SESSION['error'] = "Semua field wajib diisi!";
        header("Location:" . BASE_URL . "admin/sertifikat/index.php");
        exit;
    }

    // ======================
    // VALIDASI TAMBAHAN (opsional tapi bagus)
    // ======================
    if ($periode_akhir < $periode_awal) {
        $_SESSION['error'] = "Periode akhir tidak boleh lebih kecil dari periode awal!";
        header("Location:" . BASE_URL . "admin/sertifikat/index.php");
        exit;
    }

    // ======================
    // INSERT DATABASE
    // ======================
    $stmt = $conn->prepare("
        INSERT INTO sertifikat 
        (nama, pelatihan_id, periode_awal, periode_akhir, issued_date, status, template_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sisssii",
        $nama,
        $pelatihan_id,
        $periode_awal,
        $periode_akhir,
        $issued_date,
        $status,
        $template_id
    );

    if ($stmt->execute()) {
        $last_id = $conn->insert_id;

        $_SESSION['success'] = "Data sertifikat berhasil ditambahkan dan tersimpan!";
        header("Location:" . BASE_URL . "admin/sertifikat/index.php?id=$last_id");
        exit;
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat menyimpan data. Silakan ulangi kembali!";
        header("Location:" . BASE_URL . "admin/sertifikat/index.php");
        exit;
    }
}