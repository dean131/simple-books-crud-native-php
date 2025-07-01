<?php

require_once '../../config_en.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed.']);
    exit();
}

$data = json_decode(file_get_contents("php://input"));
if (empty($data->title) || empty($data->author)) {
    http_response_code(400);
    echo json_encode(['message' => 'Incomplete book data.']);
    exit();
}

$title = mysqli_real_escape_string($connection, $data->title);
$author = mysqli_real_escape_string($connection, $data->author);
$publisher = mysqli_real_escape_string($connection, $data->publisher ?? '');
$isbn = mysqli_real_escape_string($connection, $data->isbn ?? '');
$year = (int) ($data->year ?? 0);
$picture = mysqli_real_escape_string($connection, $data->picture ?? '');
$category = mysqli_real_escape_string($connection, $data->category);
$description = mysqli_real_escape_string($connection, $data->description ?? '');

$query = "INSERT INTO books (title, author, publisher, isbn, year, picture, category, description) 
          VALUES ('$title', '$author', '$publisher', '$isbn', $year, '$picture', '$category', '$description')";

if (mysqli_query($connection, $query)) {
    http_response_code(201);
    echo json_encode(['message' => 'Book added successfully.']);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to add book.']);
}

mysqli_close($connection);
