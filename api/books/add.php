<?php

require_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Metode tidak diizinkan.']);
    exit();
}

$data = json_decode(file_get_contents("php://input"));
if (empty($data->title) || empty($data->author)) {
    http_response_code(400);
    echo json_encode(['message' => 'Data buku tidak lengkap.']);
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

$query = "INSERT INTO books (title, author, publisher, isbn, year, picture, category, description) 
          VALUES ('$title', '$author', '$publisher', '$isbn', $year, '$picture', '$category', '$description')";

if (mysqli_query($conn, $query)) {
    http_response_code(201);
    echo json_encode(['message' => 'Buku berhasil ditambahkan.']);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Gagal menambahkan buku.']);
}

mysqli_close($conn);
