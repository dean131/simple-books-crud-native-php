<?php

require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed.']);
    exit();
}

$data = json_decode(file_get_contents("php://input"));

if (empty($data->username) || empty($data->password)) {
    http_response_code(400);
    echo json_encode(['message' => 'Username or password cannot be empty.']);
    exit();
}

$username = mysqli_real_escape_string($connection, $data->username);
$password = $data->password;

$query = "SELECT * FROM admins WHERE username = '$username'";
$result = mysqli_query($connection, $query);
$admin = mysqli_fetch_assoc($result);

if ($admin && password_verify($password, $admin['password'])) {
    // Generate a new random token
    $token = bin2hex(random_bytes(30));
    $admin_id = $admin['id'];
    
    // Save the new token to the database
    $update_query = "UPDATE admins SET api_token = '$token' WHERE id = $admin_id";
    mysqli_query($connection, $update_query);

    // Remove sensitive data from the response
    unset($admin['password']);
    unset($admin['api_token']);
    
    http_response_code(200);
    echo json_encode([
        'message' => 'Login successful.',
        'data' => $admin,
        'token' => $token // Send the new token to the user
    ]);
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Incorrect username or password.']);
}

mysqli_close($connection);
