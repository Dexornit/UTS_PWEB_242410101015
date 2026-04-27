# 📋 Dokumentasi & Presentasi Project UTS
## MatcaSpace — Aplikasi Manajemen Tugas Berbasis Laravel MVC

> **Mata Kuliah:** Pemrograman Web  
> **Teknologi:** Laravel · PHP · Blade Engine · Font Awesome v5 · Google Fonts (Inter)  
> **Tema Desain:** Minimalism — Color Palette Matcha Green

---

## 📁 BAGIAN Gambaran Umum Project

###
Aplikasi web manajemen tugas sederhana yang dibangun menggunakan framework Laravel dengan pola arsitektur **MVC (Model–View–Controller)**. Aplikasi ini memungkinkan pengguna untuk:

1. **Login** menggunakan username (disimpan ke Session)
2. Melihat **Dashboard** berisi statistik dan aktivitas terbaru
3. Melihat **Pengelolaan Tugas** berupa tabel daftar tugas
4. Melihat halaman **Profil** berisi informasi dan keahlian pengguna
5. **Logout** yang menghapus session

> Tidak ada database / CRUD — semua data disimulasikan menggunakan **array PHP** di dalam Controller, sesuai ketentuan UTS.

---

## 🗂️ BAGIAN Struktur File Project

```
UTSB/                                   ← Root project Laravel
│
├── routes/
│   └── web.php                         ← [1] Semua definisi URL & routing
│
├── app/Http/Controllers/
│   └── PageController.php              ← [2] Satu-satunya Controller (semua logika)
│
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php               ← [3] Master Layout (kerangka HTML utama)
│   │
│   ├── login.blade.php                 ← [4] View: Halaman Login
│   ├── dashboard.blade.php             ← [5] View: Halaman Dashboard
│   ├── pengelolaan.blade.php           ← [6] View: Halaman Pengelolaan
│   ├── profile.blade.php               ← [7] View: Halaman Profil
│   │
│   └── components/
│       ├── navbar.blade.php            ← [8] Blade Component: Navigasi
│       └── footer.blade.php            ← [9] Blade Component: Footer
│
└── public/
    └── images/
        └── LogoD.png                   ← Aset logo brand Dexornit
```

### Skenario 1 — User Membuka Halaman Login

```
Browser          Router           PageController      Blade View
  |                 |                   |                  |
  |── GET /login ──>|                   |                  |
  |                 |── @login ────────>|                  |
  |                 |                   |── view('login') >|
  |                 |                   |                  |── Kompilasi HTML
  |                 |                   |<── HTML ─────────|
  |<── HTTP 200 ────|─────────────────────────────────────|
```

### Skenario 2 — User Submit Form Login

```
Browser              Router           PageController         Session
  |                     |                   |                   |
  |── POST /login/proses|                   |                   |
  |   (username=Danu) ─>|                   |                   |
  |                     |── @prosesLogin ──>|                   |
  |                     |                   |── session->put() >|
  |                     |                   |<── tersimpan ─────|
  |<── HTTP 302 Redirect /dashboard ────────|
```

### Skenario 3 — User Membuka Dashboard

```
Browser         Router        PageController      Session        Blade View
  |                |                |                |               |
  |── GET /dashboard ──────────────>|                |               |
  |                |── @dashboard ─>|                |               |
  |                |                |── get('username') ────────────>|
  |                |                |<── 'Danu' ─────|               |
  |                |                |── Siapkan array $statistik     |
  |                |                |── Siapkan array $aktivitas     |
  |                |                |── view('dashboard', data) ────>|
  |                |                |                |   Kompilasi   |
  |                |                |                |   @foreach    |
  |<── HTTP 200 + HTML ─────────────────────────────────────────────|
```

### Skenario 4 — User Membuka Pengelolaan

```
Browser         Router        PageController      Session        Blade View
  |                |                |                |               |
  |── GET /pengelolaan ────────────>|                |               |
  |                |── @pengelolaan>|                |               |
  |                |                |── get('username') ────────────>|
  |                |                |<── 'Danu' ─────|               |
  |                |                |── Siapkan array $daftarTugas   |
  |                |                |── view('pengelolaan', data) ──>|
  |                |                |                |   @foreach    |
  |<── HTTP 200 + HTML tabel tugas ─────────────────────────────────|
```

### Skenario 5 — User Membuka Profil

```
Browser         Router        PageController      Session        Blade View
  |                |                |                |               |
  |── GET /profile ────────────────>|                |               |
  |                |── @profile ───>|                |               |
  |                |                |── get('username') ────────────>|
  |                |                |<── 'Danu' ─────|               |
  |                |                |── Siapkan $infoProfile         |
  |                |                |── Siapkan $keahlian            |
  |                |                |── view('profile', data) ──────>|
  |                |                |                | @foreach x2   |
  |<── HTTP 200 + HTML profil ──────────────────────────────────────|
```

### Skenario 6 — User Logout

```
Browser         Router        PageController      Session
  |                |                |                |
  |── POST /logout ────────────────>|                |
  |                |── @logout ────>|                |
  |                |                |── session->forget('username') >|
  |                |                |<── terhapus ───|
  |<── HTTP 302 Redirect /login ────|
```

---

### Alur Penggunaan

```
[Buka Browser] → /login
    ↓ Masukkan username (bebas) → klik "Masuk"
[Dashboard] → lihat statistik & aktivitas
    ↓ Klik "Pengelolaan" di navbar
[Pengelolaan] → lihat tabel daftar tugas
    ↓ Klik "Profil" di navbar
[Profil] → lihat info & skill bar
    ↓ Klik "Keluar"
[Kembali ke Login]
```
