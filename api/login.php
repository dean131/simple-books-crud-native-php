<?php

// Include the configuration file from the parent directory
require_once '../config_en.php';

// Only allow POST method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Method not allowed.']);
    exit();
}

// Get JSON data from the request body
$data = json_decode(file_get_contents("php://input"));

// Validate input data
if (empty($data->username) || empty($data->password)) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Username or password cannot be empty.']);
    exit();
}

// Sanitize input
$username = mysqli_real_escape_string($connection, $data->username);
$password = $data->password;

// Find the admin by username
$query = "SELECT * FROM admins WHERE username = '$username'";
$result = mysqli_query($connection, $query);
$admin = mysqli_fetch_assoc($result);

// If admin is found AND the password matches
if ($admin && password_verify($password, $admin['password'])) {
    // Remove the password field so it's not sent in the response
    unset($admin['password']); 
    
    http_response_code(200); // OK
    echo json_encode([
        'message' => 'Login successful.',
        'data' => $admin
    ]);
} else {
    http_response_code(401); // Unauthorized
    echo json_encode(['message' => 'Incorrect username or password.']);
}

// Close the connection
mysqli_close($connection);
