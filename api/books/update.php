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

$title = mysqli_real_escape_string($conn, $data->title);
$author = mysqli_real_escape_string($conn, $data->author);
$publisher = mysqli_real_escape_string($conn, $data->publisher ?? '');
$isbn = mysqli_real_escape_string($conn, $data->isbn ?? '');
$year = (int) ($data->year ?? 0);
$picture = mysqli_real_escape_string($conn, $data->picture ?? '');
$category = mysqli_real_escape_string($conn, $data->category);
$description = mysqli_real_escape_string($conn, $data->description ?? '');

$query = "UPDATE books SET title='$title', author='$author', publisher='$publisher', isbn='$isbn', year=$year, picture='$picture', category='$category', description='$description' WHERE id=$id";

if (mysqli_query($conn, $query)) {
    http_response_code(200);
    echo json_encode(['message' => 'Data buku berhasil diperbarui.']);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Gagal memperbarui data buku.']);
}

mysqli_close($conn);
