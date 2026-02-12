<?php
session_start();
session_unset();
session_destroy();
require_once __DIR__ . '/../bootstrap.php';
header("Location:" . BASE_URL . "index.php?logout=berhasil");
echo "<script>alert('Anda telah berhasil keluar.'); window.location = 'index.html'</script>";
exit;
?>

