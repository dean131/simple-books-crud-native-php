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

$query = "DELETE FROM books WHERE id=$id";

if (mysqli_query($connection, $query) && mysqli_affected_rows($connection) > 0) {
    http_response_code(200);
    echo json_encode(['message' => 'Book deleted successfully.']);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Failed to delete or book not found.']);
}

mysqli_close($connection);
