<?php

require_once '../../config_en.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed.']);
    exit();
}

$id = (int) ($_GET['id'] ?? 0);

if ($id == 0) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid book ID.']);
    exit();
}

$query = "SELECT * FROM books WHERE id = $id";
$result = mysqli_query($connection, $query);
$book = mysqli_fetch_assoc($result);

if ($book) {
    http_response_code(200);
    echo json_encode(['data' => $book]);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Book not found.']);
}

mysqli_close($connection);
