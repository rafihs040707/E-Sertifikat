<?php
session_start();
session_destroy();
header("Location:index.php?logout=berhasil");
echo "<script>alert('Anda telah berhasil keluar.'); window.location = 'index.html'</script>";
exit;
?>

