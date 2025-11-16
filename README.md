# Sistem Manajemen Kontak (KontakKuy!)

Ini adalah aplikasi web CRUD sederhana untuk mengelola daftar kontak. Proyek ini dibuat menggunakan **PHP native**, **MySQL**, dan **Tailwind CSS**, serta dilengkapi dengan sistem otentikasi pengguna yang aman.

---

## ✨ Fitur Utama

- **Otentikasi Pengguna:** Sistem Login & Registrasi yang aman menggunakan `password_hash()` dan `password_verify()` PHP.
- **Manajemen Session:** Proteksi halaman yang mewajibkan login untuk mengakses data kontak, serta _flash message_ untuk notifikasi.
- **Manajemen Kontak (CRUD):**
  - **Create:** Menambah kontak baru melalui formulir dengan validasi.
  - **Read:** Menampilkan semua kontak dalam tabel yang terstruktur.
  - **Update:** Mengedit kontak yang sudah ada.
  - **Delete:** Menghapus kontak dari database.
- **Desain Responsif:**
  - Navigasi bar yang adaptif dengan menu _hamburger_ di perangkat _mobile_.
  - Tabel data yang dapat di-_scroll_ secara horizontal di layar kecil.
  - Formulir yang terpusat dan rapi di semua ukuran layar.

---

## 💻 Teknologi yang Digunakan

- **Backend:** PHP
- **Database:** MySQL
- **Frontend:** HTML dan Tailwind CSS (via CDN)

---

## 🚀 Panduan Instalasi & Penggunaan

Ikuti langkah-langkah ini untuk menjalankan proyek di server lokal Anda (XAMPP/WAMP/MAMP).

### 1. Dapatkan Kode

- **Download ZIP:** Unduh file ZIP proyek ini dan ekstrak ke folder server Anda.
- **ATAU Git Clone:**
  ```bash
  git clone [https://github.com/inthemiddleof/tugas-akhir-ppw-4.git](https://github.com/inthemiddleof/tugas-akhir-ppw-4.git)
  ```
- Pindahkan folder proyek ke dalam direktori(bebas) atau diretori `htdocs` (untuk XAMPP).

### 2. Buat Database

1.  Buka `phpMyAdmin` (`http://localhost/phpmyadmin`).
2.  Buat database baru. Beri nama `kontak`.
3.  Pilih database `kontak`, lalu klik tab **SQL**.
4.  Salin dan jalankan kueri SQL di bawah ini untuk membuat tabel `users` dan `contacts`.

### 3. Struktur Database (SQL)

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
