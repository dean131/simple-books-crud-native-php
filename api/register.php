<?php

// Include the configuration file from the parent directory
require_once '../config.php';

// Only allow POST method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Method not allowed.']);
    exit();
}

// Get JSON data from the request body
$data = json_decode(file_get_contents("php://input"));

// Validate input data
if (empty($data->name) || empty($data->username) || empty($data->password)) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Incomplete data.']);
    exit();
}

// Sanitize user input
$name = mysqli_real_escape_string($connection, $data->name);
$username = mysqli_real_escape_string($connection, $data->username);
$password = password_hash($data->password, PASSWORD_BCRYPT); // Hash the password

// Create the query to insert new data
$query = "INSERT INTO admins (name, username, password) VALUES ('$name', '$username', '$password')";

// Execute the query
if (mysqli_query($connection, $query)) {
    http_response_code(201); // Created
    echo json_encode(['message' => 'Admin registration successful.']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['message' => 'Admin registration failed. The username might already exist.']);
}

// Close the connection
mysqli_close($connection);
