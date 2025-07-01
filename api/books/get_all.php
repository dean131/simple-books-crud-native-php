<?php

require_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    echo json_encode(['message' => 'Metode tidak diizinkan.']);
    exit();
}

$query = "SELECT * FROM books ORDER BY created_at DESC";
$result = mysqli_query($koneksi, $query);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

http_response_code(200);
echo json_encode(['data' => $books]);

mysqli_close($koneksi);
