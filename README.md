# Guest Book System

![Guest Book System Logo](https://via.placeholder.com/800x200/007bff/ffffff?text=Guest+Book+System)

## 📋 Deskripsi

Guest Book System adalah aplikasi manajemen tamu terintegrasi berbasis web yang dibangun dengan framework CodeIgniter 3. Aplikasi ini dirancang untuk mempermudah pengelolaan kunjungan tamu, pendaftaran acara, dan sistem kehadiran dengan fitur QR code check-in, pembuatan ID card, dan laporan kehadiran.

## ✨ Fitur Utama

- 📅 **Manajemen Acara**
  - Membuat, mengedit, dan menghapus acara
  - Upload poster acara
  - Pengaturan kapasitas dan informasi acara

- 👥 **Manajemen Tamu**
  - Pendaftaran tamu dengan data lengkap dan foto
  - Kategorisasi tamu (VIP, Pembicara, Panitia, Media, dll)
  - Pendataan informasi kontak dan asal institusi

- 🎫 **ID Card Generation**
  - Pembuatan ID card tamu dengan format lanyard modern
  - QR code unik untuk setiap tamu
  - Desain ID card yang dapat diubah sesuai kebutuhan

- 📱 **Check-in System**
  - Check-in tamu menggunakan QR code
  - Pemindaian QR code melalui kamera
  - Status kehadiran real-time

- 📊 **Laporan & Statistik**
  - Laporan kehadiran per acara
  - Statistik tamu berdasarkan kategori
  - Data kehadiran yang dapat diexport ke Excel

- 👮 **Manajemen Pengguna**
  - Multi-level user (Admin, Petugas)
  - Pengaturan hak akses

- 📝 **Buku Tamu Digital**
  - Pendataan tamu dengan foto
  - Registrasi kartu RFID/NFC untuk visitor
  - Pencatatan tujuan kunjungan dan keperluan

## 🖥️ Tampilan Aplikasi

### Light Mode Modern UI
Aplikasi menggunakan tema light mode modern dengan tampilan yang clean dan profesional, serta transisi yang smooth.

## 🔧 Teknologi

- **Framework**: CodeIgniter 3
- **Database**: MySQL
- **Frontend**: 
  - Bootstrap 3
  - jQuery
  - AdminLTE (Light Mode Theme)
  - Select2
  - DataTables
- **Fitur Khusus**:
  - WebcamJS untuk pengambilan foto
  - QR Code Generator
  - QR Code Scanner
  - RFID/NFC Integration

## 📋 Prasyarat

- PHP >= 5.6 (direkomendasikan PHP 7.3+)
- MySQL 5.6+ atau MariaDB 10.0+
- Web Server (Apache/Nginx)
- Ekstensi PHP: GD, Mysqli, Session, FileInfo

## ⚙️ Instalasi

1. **Clone repositori**
   ```bash
   git clone https://github.com/username/guest-book-system.git
   cd guest-book-system
   ```

2. **Setup database**
   - Buat database baru di MySQL/MariaDB
   - Import file SQL dari folder `database/guest_book.sql`

3. **Konfigurasi aplikasi**
   - Sesuaikan file konfigurasi database `application/config/database.php` dengan lingkungan Anda
   ```php
   $db['default'] = array(
       'dsn'   => '',
       'hostname' => 'localhost',
       'username' => 'your_username',
       'password' => 'your_password',
       'database' => 'db_guest_book',
       'dbdriver' => 'mysqli',
       ...
   );
   ```

4. **Konfigurasi base URL**
   - Edit file `application/config/config.php`
   ```php
   $config['base_url'] = 'http://localhost/guest-book-system/';
   ```

5. **Atur folder upload**
   - Pastikan folder `assets/images/foto_peserta`, `assets/images/foto_tamu` dan `assets/images/poster_acara` memiliki permission yang benar (chmod 755)

6. **Login ke aplikasi**
   - URL: `http://localhost/guest-book-system/`
   - Username: `admin`
   - Password: `admin123`

## 🚀 Penggunaan

### Pendaftaran Tamu
1. Masuk ke menu "Data Tamu"
2. Klik tombol "Tambah Tamu" untuk mendaftarkan tamu baru
3. Isi data tamu, ambil foto, dan masukkan kartu RFID jika ada
4. Klik "Simpan" untuk menyimpan data tamu

### Manajemen Acara
1. Masuk ke menu "Daftar Acara"
2. Klik tombol "Tambah Acara" untuk membuat acara baru
3. Isi formulir dengan informasi acara dan upload poster
4. Klik "Simpan" untuk menyimpan acara

### Manajemen Tamu
1. Dari daftar acara, pilih acara dan klik "Tamu"
2. Klik "Tambah Tamu" untuk mendaftarkan tamu baru
3. Isi data tamu, ambil foto, dan pilih kategori
4. Klik "Simpan" untuk menyimpan data tamu

### Cetak ID Card
1. Dari daftar tamu, pilih tamu yang akan dicetak ID card-nya
2. Klik "Cetak ID Card"
3. ID card akan ditampilkan dalam format siap cetak (depan & belakang)

### Check-in Tamu
1. Masuk ke menu "Check-in Tamu"
2. Gunakan kamera untuk memindai QR code pada ID card tamu
3. Sistem akan otomatis menampilkan data tamu dan mengupdate status kehadiran

### Laporan Kehadiran
1. Masuk ke menu "Laporan Kehadiran"
2. Pilih acara yang ingin dilihat laporannya
3. Lihat statistik dan detail kehadiran tamu
4. Klik "Export Excel" untuk mengunduh data dalam format Excel

## 👨‍💻 Pengembangan

Proyek ini mengikuti struktur standar CodeIgniter 3 dengan beberapa tambahan:

```
guest-book-system/
├── application/              # Direktori aplikasi CodeIgniter
│   ├── controllers/          # Controller aplikasi
│   ├── models/               # Model aplikasi
│   ├── views/                # View aplikasi
│   │   ├── include/          # Komponen view (header, footer, sidebar)
│   │   ├── v_login.php       # Halaman login
│   │   └── ...               # View lainnya
│   └── ...                   # File konfigurasi CI lainnya
├── assets/                   # Aset frontend
│   ├── bootstrap/            # File Bootstrap
│   ├── dist/                 # File tema AdminLTE
│   ├── font-awesome/         # Font Awesome icons
│   ├── images/               # Gambar aplikasi
│   │   ├── foto_peserta/     # Foto peserta yang diupload
│   │   ├── foto_tamu/        # Foto tamu yang diupload
│   │   └── poster_acara/     # Poster acara yang diupload
│   ├── plugins/              # Plugin JS (Webcam, DataTables, dll)
│   └── webcamjs/             # Library WebcamJS
└── database/                 # File SQL untuk setup database
```

## 📸 Gallery
Berikut adalah beberapa screenshot dari aplikasi Guest Book System:
