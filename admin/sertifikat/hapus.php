<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

// ======================
// VALIDASI ID
// ======================
$id = $_GET['id'] ?? '';

if (!ctype_digit($id)) {
    $_SESSION['error'] = "ID tidak valid.";
    header("Location:" . BASE_URL . "admin/sertifikat/index.php");
    exit;
}

// ======================
// START TRANSACTION
// ======================
$conn->begin_transaction();

try {

    // ======================
    // AMBIL DATA FILE
    // ======================
    $stmt = $conn->prepare("SELECT file_sertifikat, qr_image FROM sertifikat WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        throw new Exception("Data sertifikat tidak ditemukan.");
    }

    // ======================
    // HAPUS FILE PDF
    // ======================
    if (!empty($data['file_sertifikat'])) {
        $pdfPath = BASE_PATH . "/uploads/sertifikat/" . $data['file_sertifikat'];
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }
    }

    // ======================
    // HAPUS FILE QR
    // ======================
    if (!empty($data['qr_image'])) {
        $qrPath = BASE_PATH . "/uploads/qrcode/" . $data['qr_image'];
        if (file_exists($qrPath)) {
            unlink($qrPath);
        }
    }

    // ======================
    // DELETE DATABASE
    // ======================
    $stmtDel = $conn->prepare("DELETE FROM sertifikat WHERE id = ?");
    $stmtDel->bind_param("i", $id);
    $stmtDel->execute();

    if ($stmtDel->affected_rows <= 0) {
        throw new Exception("Gagal menghapus data.");
    }

    // ======================
    // COMMIT
    // ======================
    $conn->commit();

    $_SESSION['success'] = "Data sertifikat berhasil dihapus.";

} catch (Exception $e) {

    $conn->rollback();
    $_SESSION['error'] = $e->getMessage();
}

header("Location:" . BASE_URL . "admin/sertifikat/index.php");
exit;