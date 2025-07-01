# Dokumentasi API - Aplikasi Manajemen Buku

Dokumen ini menjelaskan setiap endpoint yang tersedia di backend aplikasi manajemen buku.

**Base URL:** `http://localhost/workshop-backend`

---

## 1. Otentikasi Admin

Endpoint yang berhubungan dengan proses registrasi dan login admin.

### **1.1 Registrasi Admin Baru**

- **Fitur:** Mendaftarkan seorang admin baru ke dalam sistem.
- **Method:** `POST`
- **Endpoint:** `/api/register.php`
- **Body Request:** `application/json`

```json
{
    "name": "Nama Lengkap Admin",
    "username": "usernamebaru",
    "password": "passwordrahasia"
}
```

- **Contoh Sukses (Code 201 Created)**

```json
{
    "pesan": "Registrasi admin berhasil."
}
```

- **Contoh Gagal (Code 400 Bad Request)**

```json
{
    "pesan": "Data tidak lengkap."
}
```

- **Contoh Gagal (Code 500 Internal Server Error)**
  *(Terjadi jika username sudah terdaftar)*

```json
{
    "pesan": "Registrasi admin gagal. Mungkin username sudah ada."
}
```

---

### **1.2 Login Admin**

- **Fitur:** Memverifikasi kredensial admin untuk login.
- **Method:** `POST`
- **Endpoint:** `/api/login.php`
- **Body Request:** `application/json`

```json
{
    "username": "usernamebaru",
    "password": "passwordrahasia"
}
```

- **Contoh Sukses (Code 200 OK)**

```json
{
    "pesan": "Login berhasil.",
    "data": {
        "id": 1,
        "name": "Nama Lengkap Admin",
        "username": "usernamebaru",
        "created_at": "2025-07-01 14:30:00",
        "updated_at": "2025-07-01 14:30:00"
    }
}
```

- **Contoh Gagal (Code 401 Unauthorized)**

```json
{
    "pesan": "Username atau password salah."
}
```

---

## 2. Manajemen Buku (CRUD)

Endpoint untuk semua operasi yang berkaitan dengan data buku.

### **2.1 Melihat Semua Buku**

- **Fitur:** Mendapatkan daftar semua buku yang ada di database.
- **Method:** `GET`
- **Endpoint:** `/api/books/get_all.php`
- **Contoh Sukses (Code 200 OK)**

```json
{
    "data": [
        {
            "id": 1,
            "title": "Belajar PHP Native",
            "author": "Andika Pratama",
            "publisher": "Informatika",
            "isbn": "1234567890",
            "year": 2023,
            "picture": null,
            "category": "Teknologi",
            "description": "Buku panduan untuk pemula.",
            "created_at": "2025-07-01 14:35:00",
            "updated_at": "2025-07-01 14:35:00"
        },
        {
            "id": 2,
            "title": "Fiksi Ilmiah Terbaik",
            "author": "Dewi Ayu",
            "publisher": "Gramedia",
            "isbn": "0987654321",
            "year": 2024,
            "picture": null,
            "category": "Fiksi",
            "description": "Kumpulan cerita fiksi.",
            "created_at": "2025-07-01 14:40:00",
            "updated_at": "2025-07-01 14:40:00"
        }
    ]
}
```

---

### **2.2 Melihat Detail Buku Berdasarkan ID**

- **Fitur:** Mendapatkan detail satu buku spesifik.
- **Method:** `GET`
- **Endpoint:** `/api/books/get_by_id.php`
- **URL Params:** `id` (wajib)
  - Contoh: `/api/books/get_by_id.php?id=1`
- **Contoh Sukses (Code 200 OK)**

```json
{
    "data": {
        "id": 1,
        "title": "Belajar PHP Native",
        "author": "Andika Pratama",
        "publisher": "Informatika",
        "isbn": "1234567890",
        "year": 2023,
        "picture": null,
        "category": "Teknologi",
        "description": "Buku panduan untuk pemula.",
        "created_at": "2025-07-01 14:35:00",
        "updated_at": "2025-07-01 14:35:00"
    }
}
```

- **Contoh Gagal (Code 404 Not Found)**

```json
{
    "pesan": "Buku tidak ditemukan."
}
```

---

### **2.3 Mencari Buku**

- **Fitur:** Mencari buku berdasarkan kata kunci pada judul atau penulis.
- **Method:** `GET`
- **Endpoint:** `/api/books/search.php`
- **URL Params:** `q` (wajib)
  - Contoh: `/api/books/search.php?q=php`
- **Contoh Sukses (Code 200 OK)**
  *(Sama seperti response "Melihat Semua Buku", tetapi hanya berisi hasil pencarian)*

---

### **2.4 Menambah Buku Baru**

- **Fitur:** Menambahkan satu data buku baru ke database.
- **Method:** `POST`
- **Endpoint:** `/api/books/add.php`
- **Body Request:** `application/json`

```json
{
    "title": "Dasar-Dasar Express.js",
    "author": "Budi Santoso",
    "publisher": "Elex Media",
    "isbn": "1122334455",
    "year": 2025,
    "picture": "[https://example.com/cover.jpg](https://example.com/cover.jpg)",
    "category": "Teknologi",
    "description": "Pengenalan framework Express.js untuk backend."
}
```

- **Contoh Sukses (Code 201 Created)**

```json
{
    "pesan": "Buku berhasil ditambahkan."
}
```

---

### **2.5 Memperbarui Data Buku**

- **Fitur:** Mengubah data buku yang sudah ada berdasarkan ID.
- **Method:** `POST`
- **Endpoint:** `/api/books/update.php`
- **URL Params:** `id` (wajib)
  - Contoh: `/api/books/update.php?id=3`
- **Body Request:** `application/json`
  *(Kirim semua field, termasuk yang tidak diubah)*

```json
{
    "title": "Dasar-Dasar Express.js Edisi Revisi",
    "author": "Budi Santoso",
    "publisher": "Elex Media Komputindo",
    "isbn": "1122334455",
    "year": 2025,
    "picture": "[https://example.com/cover.jpg](https://example.com/cover.jpg)",
    "category": "Teknologi",
    "description": "Pengenalan framework Express.js untuk backend - Edisi terbaru."
}
```

- **Contoh Sukses (Code 200 OK)**

```json
{
    "pesan": "Data buku berhasil diperbarui."
}
```

---

### **2.6 Menghapus Buku**

- **Fitur:** Menghapus data buku dari database berdasarkan ID.
- **Method:** `GET`
- **Endpoint:** `/api/books/delete.php`
- **URL Params:** `id` (wajib)
  - Contoh: `/api/books/delete.php?id=3`
- **Contoh Sukses (Code 200 OK)**

```json
{
    "pesan": "Buku berhasil dihapus."
}
```

- **Contoh Gagal (Code 404 Not Found)**

```json
{
    "pesan": "Gagal menghapus atau buku tidak ditemukan."
}
