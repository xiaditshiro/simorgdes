<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  <h1>Sistem Manajemen Organisasi Desa (SimOrgDes)</h1>
  <p>Aplikasi pengelolaan organisasi desa yang terintegrasi dengan Absensi GPS & QR, Sistem Kas, Approval Proposal, dan Chatbot AI WhatsApp.</p>
</div>

---

## 📑 Dokumen Laporan Proyek
Untuk melihat progres detail, perancangan sistem (ERD, Use Case, Flowchart), serta analisis pengembangan, silakan akses laporan resmi berikut:

👉 **[Buka Laporan Proyek Pengembangan - Progress Report ke-3](Laporan%20Proyek%20Pengembangan%20-%20Progress%20Report%20ke-3.pdf)**

*(Catatan: Klik tautan di atas untuk membaca PDF langsung di dalam fitur penampil PDF bawaan GitHub).*

---

## 🚀 Fitur Utama
- **Autentikasi Multi-Role:** Akses khusus untuk Anggota, Bendahara, Sekretaris, Ketua, Admin Desa, dan Super Admin.
- **Absensi GPS & QR Code:** Memastikan kehadiran peserta tervalidasi secara presisi sesuai radius lokasi geografis acara.
- **Manajemen Kas & Jurnal:** Sistem penagihan iuran otomatis dan pelunasan berbasis konfirmasi Bendahara.
- **E-Proposal:** Pengajuan, *review*, revisi, dan persetujuan surat-menyurat secara digital.
- **AI Chatbot WhatsApp:** Integrasi Webhook dengan *Groq AI* untuk melayani pertanyaan anggota secara otomatis 24/7.

---

## 🔑 Akses Sistem & Uji Coba (Live Testing)

Aplikasi ini telah di-hosting dan dapat diakses secara langsung tanpa perlu melakukan instalasi lokal.

- 🌐 **Tautan URL Sistem:** [https://simorgdes.shirocreation.com/](https://simorgdes.shirocreation.com/)
- 🤖 **Nomor WA Chatbot:** 087861716325

Gunakan daftar akun di bawah ini untuk menguji fungsionalitas aplikasi. Semua akun menggunakan *password* yang sama: **`12345678`**

| Hak Akses (Role) | Alamat Email |
| :--- | :--- |
| **Super Admin** | `superadmin@gmail.com` |
| **Admin Desa** | `admindesa@test.com` |
| **Ketua** | `ketua@gmail.com` |
| **Sekretaris** | `seketaris@gmail.com` |
| **Bendahara** | `bendahara@gmail.com` |
| **Anggota** | `angota@gmail.com` |

---

## 💻 Cara Menjalankan Project (Local Development)

### Langkah-langkah Instalasi
1. *Clone* repositori ini dan masuk ke folder proyek.
2. *Copy* file `.env.example` menjadi `.env` dan atur koneksi *database* Anda.
3. Instal semua dependensi menggunakan terminal:
   ```bash
   composer install
   npm install
   ```
4. *Generate app key* dan jalankan migrasi database:
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```

### 1. Menjalankan Server Lokal (Hanya di Komputer)
Buka 2 terminal terpisah dan jalankan perintah ini:
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

### 2. Menjalankan Server Publik (Untuk Akses HP & Kamera Scanner)
Buka 3 terminal terpisah dan jalankan perintah ini:
```bash
# Terminal 1: Laravel Server
php artisan serve --host=0.0.0.0 --port=8000

# Terminal 2: Vite Server
npm run build

# Terminal 3: Ngrok (Agar aplikasi bisa diakses via HP)
ngrok http 8000
```

---

<div align="center">
  <h2>🎓 Tim Pengembang</h2>
  
  <!-- Gambar Profil GitHub Anda (Otomatis dari Username xiaditshiro) -->
  <img src="https://avatars.githubusercontent.com/xiaditshiro" width="100" style="border-radius: 50%; margin-bottom: 10px;">
  <br>

  **PROGRAM STUDI TEKNOLOGI INFORMASI**<br>
  **INSTITUT TEKNOLOGI DAN BISNIS STIKOM BALI**<br>
  *Tahun Pembelajaran 2026*

  <br>

  | Nama Mahasiswa | NIM |
  | :--- | :---: |
  | **I Gede Aditya Wira Pranata** | `230040097` |
  | **Made Aldi Ruskita Salahin** | `230040070` |

</div>

---

<div align="center">
  Dibuat dengan ❤️ untuk kemajuan Organisasi Desa
</div>
