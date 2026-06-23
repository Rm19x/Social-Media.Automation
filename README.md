#  Social Media Automation Panel 

[![Author](https://img.shields.io/badge/Author-Mr.Rm19-blue.svg)](https://github.com/Rm19x)
[![Platform](https://img.shields.io/badge/Platform-Linux%20%7C%20WSL-orange.svg)]()
[![Language](https://img.shields.io/badge/Language-PHP%20%3E%3D%208.0-777bb4.svg)]()

Aplikasi *Control Panel Console* (CLI) berbasis PHP PSR-4 untuk otomatisasi interaksi massal, scraping data, manajemen relasi, dan pengelolaan akun secara instan pada 4 platform media sosial besar: **Facebook**, **X (Twitter)**, **Instagram**, dan **TikTok**.

---

##  Fitur Utama (Total 92 Fitur Operasional)

###  1. Facebook Automation Engine (23 Fitur)
* **Grup & Komunitas:** Auto Post Massal ke Grup, Keluar Grup Massal, Gabung Grup via ID, Auto Komen Postingan Grup, Auto Like Postingan Grup.
* **Pertemanan & Relasi:** Terima Permintaan Pertemanan, Tolak Permintaan Pertemanan, Batalkan Permintaan Keluar, Unfriend Massal, Add Friend Massal, Colek (Poke) Teman Massal.
* **Interaksi & Timeline:** Auto Post Status, Auto Like Postingan Target, Auto Comment Postingan Target, Delete Postingan Sendiri, Blokir Pengguna Massal, Unblock Pengguna Massal.
* **Halaman, Pesan & Scrape:** Auto Like Fanspage, Auto Unlike Fanspage, Kirim Pesan Inbox (PM), Scrape Info Profil Target, Mass Report Akun, Auto Share Postingan Target.

###  2. X / Twitter Automation Engine (23 Fitur)
* **Manajemen Tweet:** Buat Tweet/Post Baru, Auto Like Tweet, Auto Unlike Tweet, Auto Retweet, Auto Undo Retweet, Auto Comment/Reply Tweet Target, Hapus Tweet Sendiri Massal.
* **Relasi Akun:** Mass Follow Pengguna, Mass Unfollow Pengguna, Mass Block Pengguna, Mass Unblock Pengguna, Mute User Massal, Unmute User Massal.
* **Pesan & List:** Kirim Direct Message (DM), Buat List Kustom Baru, Tambah Anggota ke List, Hapus Anggota dari List.
* **Profil & Scrape Data:** Update Nama Profil, Update Deskripsi Bio, Report Tweet Target, Report Akun Spam, Scrape ID Numerik via Username, Scrape Search Timeline via Kata Kunci.

###  3. Instagram Automation Engine (23 Fitur)
* **Follower & Blokir:** Mass Follow User, Mass Unfollow User, Scrape Followers Target, Scrape Following Target, Mass Block Akun, Mass Unblock Akun.
* **Interaksi Media:** Auto Comment Postingan, Auto Delete Komentar Sendiri, Auto Like Media, Auto Unlike Media, Save Postingan ke Bookmark, Unsave Postingan dari Bookmark, Hapus Foto/Video Sendiri.
* **Direct Message & Stories:** Kirim DM Teks, Kirim DM Link/Tautan Massal, Kirim Reaksi Emoji ke Story, Tonton Story Target (Mark as Seen).
* **Profil & Keamanan:** Update Nama Lengkap Profil, Update Teks Bio, Set Akun ke Privat, Set Akun ke Publik, Scrape ID Numerik via Username, Mass Report Akun Pelanggaran.

### 4. TikTok Automation Engine (23 Fitur)
* **Interaksi VT & Komentar:** Auto Comment VT, Auto Like VT, Auto Unlike VT, Simpan VT ke Favorit, Hapus VT dari Favorit, Hapus Komentar Sendiri di VT, Sembunyikan Video ke Privat.
* **Hubungan Akun:** Mass Follow Pengguna, Mass Unfollow Pengguna, Mass Block Akun, Mass Unblock Akun, Hapus Pengikut Sendiri (Depak Follower), Hapus Video Sendiri Massal.
* **Pesan & Notifikasi:** Kirim Pesan Inbox (DM), Clear Notifikasi Terbaca, Terima Permintaan Pengikut (Akun Privat), Tolak Permintaan Pengikut.
* **Profil & Ekstraksi:** Update Nickname Akun, Update Signature Bio, Mass Report Target (VT/User), Scrape Data Daftar Followers, Scrape Data Daftar Following, Scrape UID Numerik via Username.

---

##   Sistem

Sebelum menjalankan aplikasi, pastikan komputer/server Anda telah menginstal komponen berikut:
* **PHP >= 8.0** (Lengkap dengan ekstensi `php-curl`, `php-json`, dan `php-mbstring`)
* **Composer** (Untuk mengaktifkan autoloader PSR-4)

---

## Pastikan konfigurasi composer.json Anda seperti di bawah ini:


Jalankan Instalasi Autoloader:
composer install

Jika folder vendor belum ter-generate sempurna, jalankan:
composer dump-autoload

## Cara Penggunaan Aplikasi
Langkah 1: Jalankan Panel Utama
Eksekusi perintah utama melalui terminal Anda:
php index.php

## Langkah 2: Set Sesi & Login
Pilih menu Manajemen Sesi / Set Cookie.

Masukkan data cookie atau token otentikasi akun media sosial Anda.

Data akan disimpan secara aman dan terenkripsi secara lokal di dalam folder config/sessions.json.

## Langkah 3: Eksekusi Fitur Utama
Masuk ke menu platform pilihan Anda (Contoh: [1] Facebook Panel).

Pilih sub-fitur dari 23 opsi yang disediakan.

Masukkan argumen target (seperti ID Grup, Username, ID Video, atau Isi Pesan) sesuai petunjuk di layar terminal.

Aplikasi akan otomatis memproses request langsung ke server platform menggunakan manajemen header bawaan.

# (Disclaimer)
[!]
Aplikasi ini dibuat murni untuk tujuan pembelajaran, riset keamanan, dan otomatisasi pengelolaan akun pribadi. Penulis (Mr.Rm19) tidak bertanggung jawab atas segala bentuk penyalahgunaan aplikasi ini yang melanggar ketentuan layanan (Terms of Service) dari masing-masing platform (Facebook, X, Instagram, TikTok), termasuk risiko pembatasan akun (rate limit) atau pemblokiran (banned). Gunakan jeda waktu (sleep delay) yang bijak saat menjalankan fitur massal!





































<IMG SRC="https://raw.githubusercontent.com/Rm19x/Social-Media.Automation/refs/heads/main/sosmed.png">
