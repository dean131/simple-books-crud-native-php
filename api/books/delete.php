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

$query = "DELETE FROM books WHERE id=$id";

if (mysqli_query($koneksi, $query) && mysqli_affected_rows($koneksi) > 0) {
    http_response_code(200);
    echo json_encode(['message' => 'Buku berhasil dihapus.']);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Gagal menghapus atau buku tidak ditemukan.']);
}

mysqli_close($koneksi);
