# Employee Payroll Management System

Sistem manajemen penggajian karyawan berbasis web menggunakan PHP dan MySQL. Aplikasi ini memudahkan pengelolaan data karyawan, gaji, serta pembuatan laporan dalam format PDF.

## Fitur Utama
- **Manajemen Karyawan:** Tambah, edit, hapus, dan cari data karyawan.
- **Manajemen Gaji:** Atur komponen gaji (pokok, lembur, pajak, asuransi) untuk setiap karyawan.
- **Laporan PDF:** Ekspor data karyawan dan gaji ke PDF menggunakan Dompdf.
- **Dashboard:** Statistik jumlah karyawan, total payroll, dan visualisasi data dengan Chart.js.
- **Autentikasi:** Login, register, dan logout user.

## Struktur Database
Terdapat 3 tabel utama:
- `user`: Menyimpan data user aplikasi.
- `karyawan`: Data karyawan (nama, kelamin, tanggal lahir, email, telepon, relasi ke gaji).
- `gaji`: Komponen gaji (pokok, lembur, pajak, asuransi).

Contoh skema lihat di `gaji_db.sql`.

## Instalasi
1. Clone repository ini.
2. Import `gaji_db.sql` ke MySQL.
3. Atur koneksi database di `config.php`.
4. Jalankan di server lokal (XAMPP/Laragon) dan akses via browser.

## Penggunaan
- Login/register untuk masuk.
- Kelola data karyawan dan gaji melalui menu.
- Ekspor laporan PDF dari halaman laporan.

## Dependensi
- PHP >= 7.x
- MySQL
- [Dompdf](https://github.com/dompdf/dompdf) untuk PDF
- Bootstrap 5, FontAwesome, Chart.js (CDN)

## File Penting
- `index.php` : Halaman utama
- `karyawan.php`, `tabel_karyawan.php` : Data karyawan & gaji
- `create_karyawan.php`, `edit_karyawan.php`, `edit_gaji.php` : Form tambah/edit
- `models/export_pdf.php` : Ekspor PDF
- `login.php`, `register.php`, `logout.php` : Autentikasi
- `config.php` : Koneksi database
## Developer
- Arbinand Roffi Ilmi (A12.2023.07051)
- Fairuz Amru Ghani (A12.2023.07057)
- Aditya Fallah Prabawa (A12.2023.07032)
- Ajrun Kabir (A12.2023.07023)
- Fico Aldi Saputro (A12.2023.07058)

## Lisensi
Open source, silakan gunakan dan modifikasi sesuai kebutuhan.
