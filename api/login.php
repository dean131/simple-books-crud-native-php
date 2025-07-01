<?php
// api/login.php

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
if (empty($data->username) || empty($data->password)) {
    http_response_code(400); // Bad Request
    echo json_encode(['message' => 'Username atau password tidak boleh kosong.']);
    exit();
}

// Amankan input
$username = mysqli_real_escape_string($conn, $data->username);
$password = $data->password;

// Cari admin berdasarkan username
$query = "SELECT * FROM admins WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Jika admin ditemukan dan password cocok
if ($admin && password_verify($password, $admin['password'])) {
    // Hapus field password agar tidak ikut terkirim dalam response
    unset($admin['password']); 
    
    http_response_code(200); // OK
    echo json_encode([
        'message' => 'Login berhasil.',
        'data' => $admin
    ]);
} else {
    http_response_code(401); // Unauthorized
    echo json_encode(['message' => 'Username atau password salah.']);
}

// Tutup koneksi
mysqli_close($conn);
