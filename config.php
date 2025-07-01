<?php
// config_en.php

// --- Database Settings ---
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_workshop_beginner'; // Adjust to your database name

// --- Create Connection ---
$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// --- Check Connection ---
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// --- API Header Settings ---
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/**
 * Function to check for a valid API token in the request headers.
 * This function will protect our endpoints.
 */
function check_token() {
    global $connection;
    $headers = getallheaders();
    $token = null;

    if (isset($headers['Authorization'])) {
        // The header format is "Bearer <token>"
        $auth_header = $headers['Authorization'];
        $parts = explode(' ', $auth_header);
        if (count($parts) == 2 && $parts[0] == 'Bearer') {
            $token = $parts[1];
        }
    }

    if ($token == null) {
        http_response_code(401); // Unauthorized
        echo json_encode(['message' => 'Authorization token not found.']);
        exit();
    }

    $sanitized_token = mysqli_real_escape_string($connection, $token);
    $query = "SELECT id FROM admins WHERE api_token = '$sanitized_token'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 0) {
        http_response_code(401); // Unauthorized
        echo json_encode(['message' => 'Invalid authorization token.']);
        exit();
    }
}
