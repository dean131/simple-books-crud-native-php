<?php

require_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Metode tidak diizinkan.']);
    exit();
}

$id = (int) ($_GET['id'] ?? 0);
$data = json_decode(file_get_contents("php://input"));

if ($id == 0 || empty($data->title)) {
    http_response_code(400);
    echo json_encode(['message' => 'ID atau data untuk update tidak valid.']);
    exit();
}

$title = mysqli_real_escape_string($koneksi, $data->title);
$author = mysqli_real_escape_string($koneksi, $data->author);
$publisher = mysqli_real_escape_string($koneksi, $data->publisher ?? '');
$isbn = mysqli_real_escape_string($koneksi, $data->isbn ?? '');
$year = (int) ($data->year ?? 0);
$picture = mysqli_real_escape_string($koneksi, $data->picture ?? '');
$category = mysqli_real_escape_string($koneksi, $data->category);
$description = mysqli_real_escape_string($koneksi, $data->description ?? '');

$query = "UPDATE books SET title='$title', author='$author', publisher='$publisher', isbn='$isbn', year=$year, picture='$picture', category='$category', description='$description' WHERE id=$id";

if (mysqli_query($koneksi, $query)) {
    http_response_code(200);
    echo json_encode(['message' => 'Data buku berhasil diperbarui.']);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Gagal memperbarui data buku.']);
}

mysqli_close($koneksi);
