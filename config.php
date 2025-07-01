<?php

// --- Database Settings ---
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_mini_workshop'; // Adjust to your database name

// --- Create Connection ---
$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// --- Check Connection ---
if (!$connection) {
    // If the connection fails, stop the script and show an error message
    die("Database connection failed: " . mysqli_connect_error());
}

// --- API Header Settings ---
// These headers are required so the API can be accessed from various platforms
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
