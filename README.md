# Mini To-Do — Aplikasi To-Do List Sederhana

Aplikasi manajemen tugas (To-Do List) sederhana yang dibangun menggunakan **Laravel**, **Vue.js**, dan **Inertia.js**. Aplikasi ini memungkinkan pengguna untuk mendaftar, masuk, dan mengelola daftar tugas pribadi mereka secara aman.

## 🚀 Teknologi yang Digunakan

| Kategori       | Teknologi                                           |
| -------------- | --------------------------------------------------- |
| **Frontend**   | Vue.js 3 (diintegrasikan via Inertia.js + Breeze)   |
| **Backend**    | Laravel 13                                          |
| **Database**   | MySQL (dijalankan melalui Laragon)                  |
| **Autentikasi**| Session (bawaan Laravel Breeze)                     |
| **Build Tool** | Vite                                                |
| **Styling**    | Tailwind CSS                                        |

## ✨ Fitur Utama

### 1. Registrasi Pengguna
- Registrasi menggunakan **nama lengkap**, **username**, dan **password**.
- Username bersifat unik (tidak bisa duplikat).
- Password disimpan dengan aman menggunakan hashing bcrypt.

### 2. Login & Logout
- Login menggunakan **username** dan **password**.
- Fitur "Ingat Saya" (Remember Me) tersedia.
- Session-based authentication yang aman dari serangan XSS.

### 3. Manajemen Tugas (CRUD)
- ➕ **Tambah** tugas baru dengan judul dan deskripsi (opsional).
- ✏️ **Edit** judul dan deskripsi tugas yang sudah ada.
- ✅ **Tandai** tugas sebagai selesai / belum selesai (toggle).
- 🗑️ **Hapus** tugas dengan konfirmasi dialog.

### 4. Privasi Data
- Setiap pengguna **hanya dapat melihat dan mengelola tugas miliknya sendiri**.
- Proteksi di sisi backend memastikan pengguna tidak bisa mengakses tugas milik orang lain.

## 📦 Cara Instalasi & Menjalankan

### Prasyarat
- PHP >= 8.3
- Composer
- Node.js & NPM
- MySQL (bisa menggunakan Laragon, XAMPP, atau sejenisnya)

### Langkah-langkah

1. **Clone repository**
   ```bash
   git clone <url-repository> mini-todo
   cd mini-todo
   ```

2. **Install dependensi PHP**
   ```bash
   composer install
   ```

3. **Install dependensi JavaScript**
   ```bash
   npm install
   ```

4. **Konfigurasi environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Setup database**
   - Buat database MySQL dengan nama `mini_todo`
   - Sesuaikan konfigurasi database di file `.env`:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=mini_todo
     DB_USERNAME=root
     DB_PASSWORD=
     ```

6. **Jalankan migrasi database**
   ```bash
   php artisan migrate
   ```

7. **Jalankan aplikasi**
   ```bash
   # Terminal 1: Laravel server
   php artisan serve

   # Terminal 2: Vite dev server
   npm run dev
   ```

8. **Buka di browser**
   ```
   http://localhost:8000
   ```

## 📁 Struktur Proyek (Utama)

```
mini-todo/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Controller autentikasi (Login, Register)
│   │   │   ├── ProfileController.php    # Profil pengguna
│   │   │   └── TaskController.php       # CRUD tugas (inti aplikasi)
│   │   └── Requests/
│   │       └── Auth/
│   │           └── LoginRequest.php     # Validasi login (username-based)
│   └── Models/
│       ├── User.php                     # Model pengguna
│       └── Task.php                     # Model tugas
├── database/
│   └── migrations/                      # Migrasi tabel users & tasks
├── resources/
│   └── js/
│       ├── Components/                  # Komponen Vue reusable
│       ├── Layouts/                     # Layout Authenticated & Guest
│       └── Pages/
│           ├── Auth/                    # Halaman Login & Register
│           ├── Dashboard.vue            # Halaman utama (manajemen tugas)
│           ├── Profile/                 # Halaman profil
│           └── Welcome.vue              # Landing page
└── routes/
    ├── web.php                          # Route utama + task routes
    └── auth.php                         # Route autentikasi
```

## 🔒 Keamanan

- **Session Authentication**: Menggunakan sistem autentikasi session bawaan Laravel yang aman dari serangan XSS.
- **CSRF Protection**: Setiap form request dilindungi oleh token CSRF.
- **Password Hashing**: Semua password di-hash menggunakan bcrypt.
- **Authorization**: Setiap operasi CRUD pada tugas memverifikasi kepemilikan (`user_id`) sebelum dieksekusi.
- **Rate Limiting**: Login endpoint memiliki proteksi rate limiting untuk mencegah brute force.
- **Input Validation**: Semua input divalidasi di sisi server.

## 📄 Lisensi

Proyek ini dibuat untuk keperluan seleksi magang.
