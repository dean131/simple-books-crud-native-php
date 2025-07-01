<?php

require_once '../../config_en.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed.']);
    exit();
}

$id = (int) ($_GET['id'] ?? 0);
$data = json_decode(file_get_contents("php://input"));

if ($id == 0 || empty($data->title)) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid ID or incomplete data for update.']);
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

$query = "UPDATE books SET title='$title', author='$author', publisher='$publisher', isbn='$isbn', year=$year, picture='$picture', category='$category', description='$description' WHERE id=$id";

if (mysqli_query($connection, $query)) {
    http_response_code(200);
    echo json_encode(['message' => 'Book data updated successfully.']);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to update book data.']);
}

mysqli_close($connection);
