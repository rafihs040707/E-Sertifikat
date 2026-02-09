<?php
include "config.php";

if (isset($_POST['submit'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $targetDir = "uploads/template/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    function uploadFile($fieldName, $targetDir)
    {
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] != 0) {
            return null;
        }

        $file = $_FILES[$fieldName];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png'];
        if (!in_array($ext, $allowed)) {
            die("Format file tidak valid! (jpg, jpeg, png)");
        }

        $hashName = md5(uniqid()) . '.' . $ext;
        $targetFile = $targetDir . $hashName;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $hashName;
        }
        return null;
    }

    $tampak_depan = uploadFile('tampak_depan', $targetDir);
    $tampak_belakang = uploadFile('tampak_belakang', $targetDir);

    if (!$tampak_depan || !$tampak_belakang) {
        die("Gambar depan dan belakang wajib diupload!");
    }

    $stmt = $conn->prepare("INSERT INTO template (nama, tampak_depan, tampak_belakang) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $tampak_depan, $tampak_belakang);
    $query = $stmt->execute();

    if ($query) {
        header('Location: data_template.php?status=sukses');
    } else {
        header('Location: data_template.php?status=gagal');
    }
} else {
    die("Akses dilarang...");
}
