# Dokumentasi API Lengkap - Aplikasi Manajemen Buku

Dokumen ini menjelaskan secara rinci setiap endpoint yang tersedia di backend aplikasi manajemen buku.

**Base URL:** `http://localhost/workshop-backend`

---

## Konsep Otentikasi

API ini menggunakan sistem otentikasi berbasis token untuk melindungi beberapa endpoint (Tambah, Ubah, Hapus Buku).

**Alur Kerja Token:**

1.  Admin melakukan **Login** menggunakan username dan password.
2.  Jika berhasil, API akan memberikan sebuah **API Token** acak.
3.  Untuk mengakses endpoint yang dilindungi, **sertakan token tersebut** di dalam *header* permintaan dengan nama `Authorization`.

**Contoh Header Permintaan (di Postman):**

-   **Key:** `Authorization`
-   **Value:** `a1b2c3d4e5f6a1b2c3d4e5f6...` (token yang didapat saat login)

---

## 1. Otentikasi & Manajemen Admin

Endpoint yang berhubungan dengan proses registrasi dan login admin.

### **1.1 Registrasi Admin Baru**

-   **Fitur:** Mendaftarkan seorang admin baru ke dalam sistem. Endpoint ini bersifat publik.
-   **Method:** `POST`
-   **Endpoint:** `/api/register.php`
-   **Body Request:** `application/json`

```json
{
    "name": "Admin Full Name",
    "username": "newadmin",
    "password": "verysecretpassword"
}
```

-   **Contoh Sukses (Code 201 Created)**

```json
{
    "message": "Admin registration successful."
}
```

-   **Contoh Gagal (Code 400 Bad Request)**

```json
{
    "message": "Incomplete data."
}
```

---

### **1.2 Login Admin & Mendapatkan Token**

-   **Fitur:** Memverifikasi kredensial admin dan menghasilkan API Token untuk sesi tersebut.
-   **Method:** `POST`
-   **Endpoint:** `/api/login.php`
-   **Body Request:** `application/json`

```json
{
    "username": "newadmin",
    "password": "verysecretpassword"
}
```

-   **Contoh Sukses (Code 200 OK)**
    *(Simpan nilai `token` ini untuk digunakan pada endpoint yang dilindungi)*

```json
{
    "message": "Login successful.",
    "data": {
        "id": 1,
        "name": "Admin Full Name",
        "username": "newadmin",
        "created_at": "2025-07-02 09:50:00",
        "updated_at": "2025-07-02 09:50:00"
    },
    "token": "a1b2c3d4e5f6a1b2c3d4e5f6a1b2c3d4e5f6a1b2c3d4e5f6a1b2c3d4e5f6"
}
```

-   **Contoh Gagal (Code 401 Unauthorized)**

```json
{
    "message": "Incorrect username or password."
}
```

---

## 2. Manajemen Buku (CRUD)

Semua endpoint di bawah ini menggunakan file tunggal `/api/book.php`. Aksi ditentukan oleh Metode HTTP yang digunakan.

### **2.1 Melihat Semua Buku (Publik)**

-   **Fitur:** Mendapatkan daftar semua buku. Tidak memerlukan otentikasi.
-   **Method:** `GET`
-   **Endpoint:** `/api/book.php`

-   **Contoh Sukses (Code 200 OK)**

```json
{
    "data": [
        {
            "id": 1,
            "title": "Learning Native PHP",
            "author": "Andika Pratama",
            "publisher": "Informatika",
            "isbn": "1234567890",
            "year": 2023,
            "picture": null,
            "category": "Technology",
            "description": "A guide for beginners.",
            "created_at": "2025-07-02 09:55:00",
            "updated_at": "2025-07-02 09:55:00"
        }
    ]
}
```

---

### **2.2 Melihat Detail Buku (Publik)**

-   **Fitur:** Mendapatkan detail satu buku spesifik. Tidak memerlukan otentikasi.
-   **Method:** `GET`
-   **Endpoint:** `/api/book.php?id=1`

-   **Contoh Gagal (Buku Tidak Ditemukan - Code 404 Not Found)**

```json
{
    "message": "Book not found."
}
```

---

### **2.3 Menambah Buku Baru (Dilindungi)**

-   **Fitur:** Menambahkan satu data buku baru. Memerlukan otentikasi token.
-   **Method:** `POST`
-   **Endpoint:** `/api/book.php`
-   **Headers:** `Authorization: <token>` (Wajib)
-   **Body Request:** `application/json`

```json
{
    "title": "Express.js Fundamentals",
    "author": "Budi Santoso",
    "category": "Technology",
    "description": "An introduction to the Express.js framework."
}
```

-   **Contoh Sukses (Code 201 Created)**

```json
{
    "message": "Book added successfully."
}
```

-   **Contoh Gagal (Token Tidak Valid - Code 401 Unauthorized)**

```json
{
    "message": "Invalid authorization token."
}
```

---

### **2.4 Memperbarui Data Buku (Dilindungi)**

-   **Fitur:** Mengubah data buku yang sudah ada. Memerlukan otentikasi token.
-   **Method:** `PUT`
-   **Endpoint:** `/api/book.php?id=1`
-   **Headers:** `Authorization: <token>` (Wajib)
-   **Body Request:** `application/json` (Kirim semua field)

```json
{
    "title": "Express.js Fundamentals Revised Edition",
    "author": "Budi Santoso",
    "category": "Technology",
    "description": "The latest edition."
}
```

-   **Contoh Sukses (Code 200 OK)**

```json
{
    "message": "Book data updated successfully."
}
```

---

### **2.5 Menghapus Buku (Dilindungi)**

-   **Fitur:** Menghapus data buku dari database. Memerlukan otentikasi token.
-   **Method:** `DELETE`
-   **Endpoint:** `/api/book.php?id=1`
-   **Headers:** `Authorization: <token>` (Wajib)

-   **Contoh Sukses (Code 200 OK)**

```json
{
    "message": "Book deleted successfully."
}
