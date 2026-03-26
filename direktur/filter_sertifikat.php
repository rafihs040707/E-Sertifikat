<?php
$allowed_roles = ["direktur"];
require_once __DIR__ . '/../bootstrap.php';
require_once BASE_PATH . '/auth/cek_login.php';
require_once BASE_PATH . '/config/config.php';

$status = $_GET['status'] ?? '';
$bulan = $_GET['bulan'] ?? '';
$halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;

$batas = 5;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// ================= QUERY DINAMIS =================
$where = "WHERE 1=1";

if ($status != '') {
    $status_safe = mysqli_real_escape_string($conn, $status);
    $where .= " AND s.status = '$status_safe'";
}

if ($bulan != '') {
    $bulan_safe = mysqli_real_escape_string($conn, $bulan);
    $start = $bulan_safe . "-01";
    $end = date('Y-m-d', strtotime("$start +1 month"));
    $where .= " AND s.issued_date >= '$start' AND s.issued_date < '$end'";
}

// total data
$countQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total
     FROM sertifikat s
     $where"
);
$total_data = mysqli_fetch_assoc($countQuery)['total'];
$total_halaman = ceil($total_data / $batas);

// ================= DATA =================
$query = mysqli_query(
    $conn,
    "SELECT s.*, t.nama_template, p.nama_pelatihan
     FROM sertifikat s
     JOIN template t ON s.template_id = t.id
     LEFT JOIN pelatihan p ON s.pelatihan_id = p.id
     $where
     LIMIT $batas OFFSET $halaman_awal"
);

$nomor = $halaman_awal + 1;
?>

<div class="table-responsive d-none d-md-block">
    <form method="POST" action="bulk_approve.php">
        <button type="submit" class="btn btn-sm btn-success mb-3 ms-3">
            Validasi
        </button>
        <table class="table table-sm table-bordered border-primary table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="checkAll" class="form-check-input">
                    </th>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Pelatihan</th>
                    <th>Periode</th>
                    <th>Issued Date</th>
                    <th>Nomor Sertifikat</th>
                    <th>Template Used</th>
                    <th>Validasi</th>
                </tr>
            </thead>
            <tbody>

                <?php while ($sertifikat = mysqli_fetch_array($query)):

                    $awal = strtotime($sertifikat['periode_awal']);
                    $akhir = strtotime($sertifikat['periode_akhir']);

                    if (date('F Y', $awal) == date('F Y', $akhir)) {
                        $periode = date('F d', $awal) . " - " . date('d, Y', $akhir);
                    } else {
                        $periode = date('F d', $awal) . " - " . date('F d, Y', $akhir);
                    }

                    $terbit = !empty($sertifikat['issued_date'])
                        ? date('F d, Y', strtotime($sertifikat['issued_date']))
                        : '-';
                    ?>

                    <tr>
                        <td>
                            <?php if ($sertifikat['status'] === 'pending'): ?>
                                <!-- Checkbox hanya muncul jika statusnya pending -->
                                <input type="checkbox" name="ids[]" value="<?= $sertifikat['id'] ?>"
                                    class="form-check-input row-check">
                            <?php endif; ?>
                        </td>
                        <td><?= $nomor++; ?></td>
                        <td><?= $sertifikat['nama']; ?></td>
                        <td><?= $sertifikat['nama_pelatihan']; ?></td>
                        <td><?= $periode; ?></td>
                        <td><?= $terbit; ?></td>
                        <td>
                            <?php if (empty($sertifikat['nomor_sertifikat'])): ?>
                                <span class="badge bg-warning text-dark">Belum Generate</span>
                            <?php else: ?>
                                <?= $sertifikat['nomor_sertifikat']; ?>
                            <?php endif; ?>
                        </td>
                        <td><?= $sertifikat['nama_template']; ?></td>
                        <td>
                            <?php if ($sertifikat['status'] == 'pending'): ?>
                                <a href="validasi.php?id=<?= $sertifikat['id'] ?>" class="btn btn-success">Approve</a>
                            <?php else: ?>
                                <span class="badge bg-success">Sudah di-Approve</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
</div>


<!-- MOBILE -->
<div class="container-fluid d-block d-md-none">

    <?php
    mysqli_data_seek($query, 0);
    $nomor = $halaman_awal + 1;
    while ($sertifikat = mysqli_fetch_array($query)):
        $awal = strtotime($sertifikat['periode_awal']);
        $akhir = strtotime($sertifikat['periode_akhir']);
        if (date('F Y', $awal) == date('F Y', $akhir)) {
            $periode = date('F d', $awal) . " - " . date('d, Y', $akhir);
        } else {
            $periode = date('F d', $awal) . " - " . date('F d, Y', $akhir);
        }
        $terbit = !empty($sertifikat['issued_date'])
            ? date('F d, Y', strtotime($sertifikat['issued_date']))
            : '-';
        ?>
        <div class="card mb-2 border-primary shadow-sm">
            <div class="card-body p-2">
                <div class="fw-bold">
                    <?= $nomor++; ?>. <?= $sertifikat['nama']; ?>
                </div>
                <div class="text-muted small">
                    Pelatihan: <?= $sertifikat['nama_pelatihan']; ?>
                </div>
                <hr class="my-2">
                <div class="small">
                    <div><strong>Periode:</strong> <?= $periode; ?></div>
                    <div><strong>Issued Date:</strong> <?= $terbit; ?></div>
                    <div><strong>No Sertifikat:</strong>
                        <?php if (empty($sertifikat['nomor_sertifikat'])): ?>
                            <span class="badge bg-warning text-dark">
                                Belum Generate
                            </span>
                        <?php else: ?>
                            <?= $sertifikat['nomor_sertifikat']; ?>
                        <?php endif; ?>
                    </div>
                    <div><strong>Template:</strong>
                        <?= $sertifikat['nama_template']; ?>
                    </div>
                </div>
                <div class="mt-2">
                    <?php if ($sertifikat['status'] == 'pending'): ?>
                        <a href="validasi.php?id=<?= $sertifikat['id'] ?>" class="btn btn-success w-100 btn-sm">
                            Approve
                        </a>
                    <?php else: ?>
                        <span class="badge bg-success w-100">
                            Sudah di-Approve
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
</form>
</div>

<?php
$previous = $halaman - 1;
$next = $halaman + 1;
?>

<nav>
    <ul class="pagination justify-content-end">

        <li class="page-item <?= ($halaman <= 1 ? 'disabled' : '') ?>">
            <a class="page-link page-ajax" href="#" data-page="<?= $previous ?>">Previous</a>
        </li>

        <?php for ($x = 1; $x <= $total_halaman; $x++): ?>
            <li class="page-item <?= ($x == $halaman ? 'active' : '') ?>">
                <a class="page-link page-ajax" href="#" data-page="<?= $x ?>"><?= $x ?></a>
            </li>
        <?php endfor; ?>

        <li class="page-item <?= ($halaman >= $total_halaman ? 'disabled' : '') ?>">
            <a class="page-link page-ajax" href="#" data-page="<?= $next ?>">Next</a>
        </li>

    </ul>
</nav>