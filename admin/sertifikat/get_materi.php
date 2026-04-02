<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once BASE_PATH . '/config/config.php';

$keyword = $_GET['q'] ?? '';

$data = [];

if ($keyword !== '') {

    $stmt = $conn->prepare("
        SELECT nama_materi 
        FROM materi_master 
        WHERE nama_materi LIKE CONCAT('%', ?, '%') 
        ORDER BY nama_materi ASC 
        LIMIT 10
    ");

    $stmt->bind_param("s", $keyword);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row['nama_materi'];
    }
}

header('Content-Type: application/json');
echo json_encode($data);