<?php
// config.php

// --- Pengaturan Database ---
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_mini_workshop'; // Sesuaikan dengan nama database Anda

// --- Membuat Koneksi ---
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// --- Cek Koneksi ---
if (!$koneksi) {
    // Jika koneksi gagal, hentikan skrip dan tampilkan pesan error
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// --- Pengaturan Header API ---
// Header ini wajib ada agar API bisa diakses dari berbagai platform
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


