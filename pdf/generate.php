<?php
ob_start();

$allowed_roles = ["admin", "lo"];

require_once __DIR__ . '/../bootstrap.php';
require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\ErrorCorrectionLevel;

ini_set('display_errors', 1);
error_reporting(E_ALL);

$id = $_GET['id'] ?? null;
$mode = $_GET['mode'] ?? 'generate';
$isPreview = ($mode === 'preview');

if (!$id) {
    die("ID tidak ditemukan");
}

function randomLetters($length, $chars)
{
    $result = '';
    $max = strlen($chars) - 1;
    $bytes = random_bytes($length);

    for ($i = 0; $i < $length; $i++) {
        $result .= $chars[ord($bytes[$i]) % ($max + 1)];
    }
    return $result;
}

function formatPeriode($awal, $akhir)
{
    if (date('F Y', $awal) == date('F Y', $akhir)) {
        return date('F d', $awal) . " - " . date('d, Y', $akhir);
    }
    return date('F d', $awal) . " - " . date('F d, Y', $akhir);
}

$q = mysqli_query($conn, "
SELECT 
    s.*, 
    t.tampak_depan,
    p.nama_pelatihan
FROM sertifikat s
JOIN template t ON s.template_id = t.id
LEFT JOIN pelatihan p ON s.pelatihan_id = p.id
WHERE s.id = '$id'
");

$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Data tidak ditemukan");
}

$approved = ($data['status'] === 'approved');

if (!$isPreview && !$approved) {
    die("Sertifikat belum divalidasi direktur.");
}

if (!$isPreview && empty($data['nomor_sertifikat'])) {

    $tahun = date('Y');
    $bulan = date('m');
    $kategori = str_pad($data['pelatihan_id'] ?? '00', 2, '0', STR_PAD_LEFT);

    $namaLengkap = trim($data['nama'] ?? '');

    if ($namaLengkap === '') {
        $inisialBelakang = 'NA';
    } else {
        $parts = preg_split('/\s+/u', $namaLengkap);
        $namaBelakang = end($parts);
        $namaBelakang = strtoupper(preg_replace('/[^A-Z]/i', '', $namaBelakang));

        if ($namaBelakang === '') {
            $inisialBelakang = 'NA';
        } else {
            $inisialBelakang = substr($namaBelakang, -2);
            $inisialBelakang = str_pad($inisialBelakang, 2, 'X', STR_PAD_LEFT);
        }
    }

    mysqli_begin_transaction($conn);

    try {

        $prefix = "$tahun$kategori$bulan";

        $q2 = mysqli_query($conn, "
        SELECT MAX(
            CAST(SUBSTRING(nomor_sertifikat,9,4) AS UNSIGNED)
        ) AS last_no
        FROM sertifikat
        WHERE nomor_sertifikat LIKE '$prefix%'
        FOR UPDATE
        ");

        $row = mysqli_fetch_assoc($q2);

        $urut = ($row['last_no'] ?? 0) + 1;
        $nomorUrut = str_pad($urut, 4, '0', STR_PAD_LEFT);

        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $unique6 =
            randomLetters(2, $lower) .
            randomLetters(2, $upper) .
            randomLetters(2, $lower);

        $nomor_sertifikat = "{$tahun}{$kategori}{$bulan}{$nomorUrut}/{$unique6}{$inisialBelakang}";

        mysqli_query($conn, "
        UPDATE sertifikat 
        SET nomor_sertifikat='$nomor_sertifikat'
        WHERE id='$id'
        ");

        mysqli_commit($conn);

        $data['nomor_sertifikat'] = $nomor_sertifikat;

    } catch (Exception $e) {

        mysqli_rollback($conn);
        die("Terjadi kesalahan saat generate nomor sertifikat.");

    }
}

$periode = formatPeriode(
    strtotime($data['periode_awal']),
    strtotime($data['periode_akhir'])
);

$issued = !empty($data['issued_date'])
    ? date('F d, Y', strtotime($data['issued_date']))
    : '-';

$nomorFull = $data['nomor_sertifikat'] ?? '';
$pos = strpos($nomorFull, '/');
$nomor_tampil = ($pos !== false) ? substr($nomorFull, 0, $pos) : $nomorFull;

$kode_unik = $data['nomor_sertifikat'] ?? '';
$qrText = BASE_URL . "verify/verify.php?kode=" . $kode_unik;

$qrFolder = BASE_PATH . "/uploads/qrcode/";

if (!is_dir($qrFolder)) {
    mkdir($qrFolder, 0777, true);
}

$safeKode = preg_replace('/[^A-Za-z0-9]/', '_', $kode_unik);
$qrFilename = "qr_" . $safeKode . ".png";
$qrPath = $qrFolder . $qrFilename;
$qrUrlPath = BASE_URL . "uploads/qrcode/" . $qrFilename;

if (!$isPreview && !file_exists($qrPath)) {

    $qrCode = new QrCode(
        data: $qrText,
        size: 400,
        margin: 10,
        errorCorrectionLevel: ErrorCorrectionLevel::High
    );

    $logo = new Logo(
        path: BASE_PATH . '/image/logo_putih.png',
        resizeToWidth: 150
    );

    $writer = new PngWriter();
    $result = $writer->write($qrCode, $logo);

    file_put_contents($qrPath, $result->getString());
}

$ttdDirektur = '';
$ttdPath = BASE_URL . '/image/ttd.png';

if ($approved) {
    $ttdDirektur = "<img src='{$ttdPath}' width='200'>";
}

$templatePath = BASE_URL . "uploads/template/" . $data['tampak_depan'];

$html = "
<!DOCTYPE html>
<html>
<head>
<style>

@page { margin:0; }

body{
margin:0;
padding:0;
font-family:'Times New Roman',serif;
}

.bg{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
z-index:-1;
}

.nama{
position:absolute;
top:300px;
left:53px;
width:100%;
text-align:center;
font-size:45px;
font-weight:bold;
color:#cfa34a;
}

.pelatihan{
position:absolute;
top:445px;
left:60px;
width:100%;
text-align:center;
font-size:26px;
font-weight:bold;
color:#cfa34a;
}

.periode{
position:absolute;
top:505px;
left:50px;
width:100%;
text-align:center;
font-size:20px;
color:black;
}

.issued{
position:absolute;
bottom:27px;
left:50px;
font-size:15px;
}

.nama_ceo{
position:absolute;
bottom:55px;
left:50px;
width:100%;
text-align:center;
font-size:18px;
}

.ceo{
position:absolute;
bottom:30px;
left:50px;
width:100%;
text-align:center;
font-size:16px;
}

.ttd_direktur{
position:absolute;
bottom:40px;
left:510px;
width:100%;
}

.nomor{
position:absolute;
bottom:145px;
right:35px;
font-size:15px;
}

.qr{
position:absolute;
bottom:26px;
right:22px;
}

</style>
</head>

<body>

<img class='bg' src='{$templatePath}'>

<div class='nama'>{$data['nama']}</div>
<div class='pelatihan'><b>{$data['nama_pelatihan']}</b></div>
<div class='periode'>Periode: {$periode}</div>

<div class='issued'>Issued Date: {$issued}</div>
<div class='nama_ceo'><u>Endra Prasetya Rudiyanto</u></div>
<div class='ceo'>Chief Executive Officer</div>
<div class='ttd_direktur'>{$ttdDirektur}</div>

<div class='nomor'>{$nomor_tampil}</div>

<div class='qr'>
<img src='{$qrUrlPath}' width='120'>
</div>

</body>
</html>
";

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

if ($isPreview) {

    header("Content-Type: application/pdf");
    echo $dompdf->output();
    exit;

}

$pdfFolder = BASE_PATH . "/uploads/sertifikat/";

if (!is_dir($pdfFolder)) {
    mkdir($pdfFolder, 0777, true);
}

$filename = $nomor_tampil . ".pdf";
$pdfPath = $pdfFolder . $filename;

if (file_exists($pdfPath)) {
    unlink($pdfPath);
}

file_put_contents($pdfPath, $dompdf->output());

mysqli_query($conn, "
UPDATE sertifikat
SET 
qr_code='$qrText',
qr_image='$qrFilename',
file_sertifikat='$filename'
WHERE id='$id'
");

$role = $_SESSION['role'] ?? '';

$redirect = BASE_URL;

if ($role === 'admin') {
    $redirect .= "admin/sertifikat/index.php";
} elseif ($role === 'lo') {
    $redirect .= "lo/sertifikat/index.php";
}

header("Location: $redirect");
exit;