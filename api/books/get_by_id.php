<?php

require_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    echo json_encode(['message' => 'Metode tidak diizinkan.']);
    exit();
}

$id = (int) ($_GET['id'] ?? 0);

if ($id == 0) {
    http_response_code(400);
    echo json_encode(['message' => 'ID buku tidak valid.']);
    exit();
}

$query = "SELECT * FROM books WHERE id = $id";
$result = mysqli_query($conn, $query);
$book = mysqli_fetch_assoc($result);

if ($book) {
    http_response_code(200);
    echo json_encode(['data' => $book]);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Buku tidak ditemukan.']);
}

mysqli_close($conn);
