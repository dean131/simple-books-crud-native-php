<?php
// api/register.php

// Memanggil file konfigurasi dari folder induk
require_once '../config.php';

// Hanya izinkan metode POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Metode tidak diizinkan.']);
    exit();
}

// Mengambil data JSON dari body request
$data = json_decode(file_get_contents("php://input"));

// Validasi data input
if (empty($data->name) || empty($data->username) || empty($data->password)) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Data tidak lengkap.']);
    exit();
}

// Amankan input dari user
$name = mysqli_real_escape_string($conn, $data->name);
$username = mysqli_real_escape_string($conn, $data->username);
$password = password_hash($data->password, PASSWORD_BCRYPT); // Hash password

// Buat query untuk memasukkan data baru
$query = "INSERT INTO admins (name, username, password) VALUES ('$name', '$username', '$password')";

// Eksekusi query
if (mysqli_query($conn, $query)) {
    http_response_code(201); // Created
    echo json_encode(['message' => 'Registrasi admin berhasil.']);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['message' => 'Registrasi admin gagal. Mungkin username sudah ada.']);
}

// Tutup koneksi
mysqli_close($conn);
