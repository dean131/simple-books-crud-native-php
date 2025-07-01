<?php

require_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    echo json_encode(['message' => 'Metode tidak diizinkan.']);
    exit();
}

$keyword = $_GET['q'] ?? '';
if (empty($keyword)) {
    http_response_code(400);
    echo json_encode(['message' => 'Keyword pencarian kosong.']);
    exit();
}

$search_term = mysqli_real_escape_string($conn, $keyword);
$query = "SELECT * FROM books WHERE title LIKE '%$search_term%' OR author LIKE '%$search_term%'";

$result = mysqli_query($conn, $query);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

http_response_code(200);
echo json_encode(['data' => $books]);

mysqli_close($conn);
