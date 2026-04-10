<?php
$allowed_roles = ["admin"];
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_POST['submit'])) {
    die("Akses dilarang...");
}

// ======================
// HELPER
// ======================
function hasMateri($file_layout) {
    return stripos($file_layout, 'fb') !== false;
}

// ======================
// AMBIL + SANITIZE
// ======================
$id           = (int)($_POST['id'] ?? 0);
$nama         = trim($_POST['nama'] ?? '');
$pelatihan    = (int)($_POST['pelatihan'] ?? 0);
$periode_awal = trim($_POST['periode_awal'] ?? '');
$periode_akhir= trim($_POST['periode_akhir'] ?? '');
$template_id  = (int)($_POST['template_id'] ?? 0);

// ======================
// VALIDASI
// ======================
if (!$id || $nama === '' || !$pelatihan || $periode_awal === '' || $periode_akhir === '' || !$template_id) {
    $_SESSION['error'] = "Semua field wajib diisi.";
    header("Location: " . BASE_URL . "admin/sertifikat/index.php");
    exit;
}

if ($periode_akhir < $periode_awal) {
    $_SESSION['error'] = "Periode akhir tidak boleh lebih kecil dari periode awal.";
    header("Location: " . BASE_URL . "admin/sertifikat/index.php");
    exit;
}

// ======================
// AMBIL TEMPLATE LAMA
// ======================
$q_old = $conn->prepare("
    SELECT t.file_layout 
    FROM sertifikat s
    JOIN template t ON s.template_id = t.id
    WHERE s.id = ?
");
$q_old->bind_param("i", $id);
$q_old->execute();
$old_layout = $q_old->get_result()->fetch_assoc()['file_layout'] ?? '';

// ======================
// AMBIL TEMPLATE BARU
// ======================
$q_new = $conn->prepare("
    SELECT file_layout FROM template WHERE id = ?
");
$q_new->bind_param("i", $template_id);
$q_new->execute();
$new_layout = $q_new->get_result()->fetch_assoc()['file_layout'] ?? '';

// ======================
// FLAG MATERI
// ======================
$old_has_materi = hasMateri($old_layout);
$new_has_materi = hasMateri($new_layout);

// ======================
// PREPARE UPDATE
// ======================
$stmt = $conn->prepare("
    UPDATE sertifikat 
    SET nama = ?, 
        pelatihan_id = ?, 
        periode_awal = ?, 
        periode_akhir = ?, 
        template_id = ?
    WHERE id = ?
");

$stmt->bind_param(
    "sissii",
    $nama,
    $pelatihan,
    $periode_awal,
    $periode_akhir,
    $template_id,
    $id
);

// ======================
// TRANSACTION
// ======================
$conn->begin_transaction();

try {

    // ======================
    // UPDATE SERTIFIKAT
    // ======================
    if (!$stmt->execute()) {
        throw new Exception("Update sertifikat gagal");
    }

    // ======================
    // LOGIC TEMPLATE
    // ======================
    if ($old_has_materi && !$new_has_materi) {

        // 🔥 FB → NON FB = HAPUS SEMUA
        $stmt_delete = $conn->prepare("
            DELETE FROM sertifikat_materi 
            WHERE sertifikat_id = ?
        ");
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();

    } elseif ($new_has_materi) {

        // ======================
        // PARTIAL UPDATE (DIFFING)
        // ======================

        // AMBIL DATA LAMA
        $q_old = $conn->prepare("
            SELECT sm.id, mm.nama_materi, sm.durasi
            FROM sertifikat_materi sm
            JOIN materi_master mm ON sm.materi_id = mm.id
            WHERE sm.sertifikat_id = ?
        ");
        $q_old->bind_param("i", $id);
        $q_old->execute();
        $res_old = $q_old->get_result();

        $old_data = [];
        while ($row = $res_old->fetch_assoc()) {
            $key = strtolower(trim($row['nama_materi']));
            $old_data[$key] = [
                'id' => $row['id'],
                'durasi' => $row['durasi']
            ];
        }

        // DATA FORM
        $materi_list = $_POST['materi'] ?? [];
        $durasi_list = $_POST['durasi'] ?? [];

        $new_data = [];

        foreach ($materi_list as $i => $materi) {
            $materi = trim($materi);
            $durasi = trim($durasi_list[$i] ?? '');

            if ($materi === '' && $durasi === '') continue;

            $key = strtolower($materi);

            $new_data[$key] = [
                'materi' => $materi,
                'durasi' => $durasi,
                'urutan' => $i + 1
            ];
        }

        // PREPARE
        $stmt_cek_materi = $conn->prepare("SELECT id FROM materi_master WHERE nama_materi = ?");
        $stmt_insert_materi = $conn->prepare("INSERT INTO materi_master (nama_materi) VALUES (?)");

        $stmt_insert_relasi = $conn->prepare("
            INSERT INTO sertifikat_materi (sertifikat_id, materi_id, durasi, urutan)
            VALUES (?, ?, ?, ?)
        ");

        $stmt_update_relasi = $conn->prepare("
            UPDATE sertifikat_materi 
            SET durasi = ?, urutan = ?
            WHERE id = ?
        ");

        $stmt_delete_relasi = $conn->prepare("
            DELETE FROM sertifikat_materi WHERE id = ?
        ");

        // DELETE (yang hilang di form)
        foreach ($old_data as $key => $old) {
            if (!isset($new_data[$key])) {
                $stmt_delete_relasi->bind_param("i", $old['id']);
                $stmt_delete_relasi->execute();
            }
        }

        // INSERT & UPDATE
        foreach ($new_data as $key => $new) {

            if (isset($old_data[$key])) {

                $old = $old_data[$key];

                // UPDATE jika berubah
                if ($old['durasi'] !== $new['durasi']) {
                    $stmt_update_relasi->bind_param(
                        "sii",
                        $new['durasi'],
                        $new['urutan'],
                        $old['id']
                    );
                    $stmt_update_relasi->execute();
                }

            } else {

                // INSERT BARU
                $stmt_cek_materi->bind_param("s", $new['materi']);
                $stmt_cek_materi->execute();
                $res = $stmt_cek_materi->get_result();

                if ($res->num_rows > 0) {
                    $row = $res->fetch_assoc();
                    $materi_id = $row['id'];
                } else {
                    $stmt_insert_materi->bind_param("s", $new['materi']);
                    $stmt_insert_materi->execute();
                    $materi_id = $conn->insert_id;
                }

                $stmt_insert_relasi->bind_param(
                    "iisi",
                    $id,
                    $materi_id,
                    $new['durasi'],
                    $new['urutan']
                );
                $stmt_insert_relasi->execute();
            }
        }
    }

    $conn->commit();

    $_SESSION['success'] = "Data berhasil diupdate.";

} catch (Exception $e) {

    $conn->rollback();
    $_SESSION['error'] = "Gagal update: " . $e->getMessage();
}

header("Location: " . BASE_URL . "admin/sertifikat/index.php");
exit;