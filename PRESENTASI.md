# 📋 Dokumentasi & Presentasi Project UTS
## MatcaSpace — Aplikasi Manajemen Tugas Berbasis Laravel MVC

> **Mata Kuliah:** Pemrograman Web  
> **Teknologi:** Laravel · PHP · Blade Engine · Font Awesome v5 · Google Fonts (Inter)  
> **Tema Desain:** Minimalism — Color Palette Matcha Green

---

## 📁 BAGIAN 1 — Gambaran Umum Project

### Apa itu MatcaSpace / Dexornit?

MatcaSpace (branding: **Dexornit**) adalah aplikasi web manajemen tugas sederhana yang dibangun menggunakan framework Laravel dengan pola arsitektur **MVC (Model–View–Controller)**. Aplikasi ini memungkinkan pengguna untuk:

1. **Login** menggunakan username (disimpan ke Session)
2. Melihat **Dashboard** berisi statistik dan aktivitas terbaru
3. Melihat **Pengelolaan Tugas** berupa tabel daftar tugas
4. Melihat halaman **Profil** berisi informasi dan keahlian pengguna
5. **Logout** yang menghapus session

> Tidak ada database / CRUD — semua data disimulasikan menggunakan **array PHP** di dalam Controller, sesuai ketentuan UTS.

---

## 🗂️ BAGIAN 2 — Struktur File Project

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

**Total: 9 file utama** — memenuhi syarat minimal yang ditetapkan.

---

## 🏗️ BAGIAN 3 — Arsitektur MVC

### Penjelasan Pola MVC

MVC memisahkan tanggung jawab aplikasi menjadi tiga lapisan:

| Layer | File | Tanggung Jawab |
|---|---|---|
| **Model** | *(array di Controller)* | Menyimpan & menyiapkan data — di project ini tidak pakai DB, data berupa array PHP |
| **View** | `*.blade.php` | Menampilkan data ke pengguna dalam bentuk HTML — tidak ada logika bisnis |
| **Controller** | `PageController.php` | Jembatan antara data dan tampilan — menerima request, proses logika, kirim data ke View |

### Aturan MVC yang Diterapkan

- ✅ View **tidak boleh** mengakses data langsung — semua data dilempar dari Controller
- ✅ Controller **tidak boleh** menampilkan HTML — hanya `return view(...)`
- ✅ Route **hanya** menunjuk ke method Controller — tidak ada logika di `web.php`

---

## 🔀 BAGIAN 4 — Routing (web.php)

File `routes/web.php` berfungsi sebagai **peta jalan** aplikasi. Setiap URL yang diakses browser akan dicocokkan di sini, lalu diteruskan ke method Controller yang sesuai.

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// Root redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Halaman Login — tampilkan form (GET) & proses submit (POST)
Route::get('/login',          [PageController::class, 'login'])->name('login');
Route::post('/login/proses',  [PageController::class, 'prosesLogin'])->name('login.proses');

// Halaman-halaman utama setelah login
Route::get('/dashboard',      [PageController::class, 'dashboard'])->name('dashboard');
Route::get('/pengelolaan',    [PageController::class, 'pengelolaan'])->name('pengelolaan');
Route::get('/profile',        [PageController::class, 'profile'])->name('profile');

// Logout
Route::post('/logout',        [PageController::class, 'logout'])->name('logout');
```

**Penjelasan penting:**
- `Route::get()` → untuk menampilkan halaman (HTTP GET)
- `Route::post()` → untuk menerima data dari form (HTTP POST)
- `->name('...')` → memberi nama route, sehingga View bisa memanggil `route('nama')` alih-alih nulis URL manual
- `@csrf` di form → perlindungan keamanan Laravel dari serangan CSRF

---

## 🧠 BAGIAN 5 — Controller (PageController.php)

`PageController` adalah **otak** dari aplikasi. Semua logika diproses di sini.

### Method-method yang ada:

---

### `login()` — Tampilkan Form Login
```php
public function login(): View
{
    return view('login');
}
```
Paling sederhana — hanya render halaman login tanpa kirim data apapun.

---

### `prosesLogin()` — Proses Submit Form
```php
public function prosesLogin(Request $request): RedirectResponse
{
    $username = $request->input('username');  // Ambil dari form POST

    if (!$username) {
        return back()->with('error', 'Username tidak boleh kosong.');
    }

    $request->session()->put('username', $username);  // Simpan ke Session

    return redirect('/dashboard');  // Redirect ke dashboard
}
```
**Alur:**
1. Ambil `username` dari payload form menggunakan `$request->input()`
2. Validasi — kalau kosong, kembalikan ke halaman sebelumnya dengan pesan error
3. Simpan username ke **Session** server menggunakan `session()->put()`
4. Redirect browser ke `/dashboard`

---

### `dashboard()` — Tampilkan Dashboard
```php
public function dashboard(Request $request): View
{
    $username = $request->session()->get('username', 'Pengguna');

    $statistik = [
        ['label' => 'Total Tugas',   'nilai' => 12, 'ikon' => '📋'],
        ['label' => 'Selesai',       'nilai' => 8,  'ikon' => '✅'],
        ['label' => 'Dalam Proses',  'nilai' => 3,  'ikon' => '🔄'],
        ['label' => 'Tertunda',      'nilai' => 1,  'ikon' => '⏳'],
    ];

    $aktivitas = [
        ['aksi' => 'Tugas "Laporan Akhir" ditambahkan', 'waktu' => '2 jam lalu'],
        // ...
    ];

    return view('dashboard', [
        'username'  => $username,
        'statistik' => $statistik,
        'aktivitas' => $aktivitas,
    ]);
}
```
**Yang terjadi:**
1. Baca `username` dari Session (dengan nilai default `'Pengguna'` jika kosong)
2. Siapkan dua array: `$statistik` dan `$aktivitas`
3. Lempar semua data ke View melalui parameter array di `view()`

---

### `pengelolaan()` — Tampilkan Daftar Tugas
```php
public function pengelolaan(Request $request): View
{
    $username = $request->session()->get('username', 'Pengguna');

    $daftarTugas = [
        ['id'=>1, 'nama'=>'Laporan Akhir Semester', 'prioritas'=>'Tinggi',  'status'=>'Dalam Proses', 'deadline'=>'30 Apr 2026'],
        ['id'=>2, 'nama'=>'Desain Antarmuka Web',   'prioritas'=>'Tinggi',  'status'=>'Selesai',      'deadline'=>'25 Apr 2026'],
        // ... 4 item lainnya
    ];

    return view('pengelolaan', [
        'username'    => $username,
        'daftarTugas' => $daftarTugas,
    ]);
}
```

---

### `profile()` — Tampilkan Halaman Profil
```php
public function profile(Request $request): View
{
    $username = $request->session()->get('username', 'Pengguna');

    $infoProfile = [
        ['label' => 'Username', 'nilai' => $username],  // ← Data dari Session!
        ['label' => 'Role',     'nilai' => 'Mahasiswa'],
        // ...
    ];

    $keahlian = [
        ['nama' => 'HTML & CSS',    'level' => 90],
        ['nama' => 'JavaScript',    'level' => 75],
        ['nama' => 'PHP & Laravel', 'level' => 65],
        ['nama' => 'Git',           'level' => 80],
    ];

    return view('profile', [
        'username'    => $username,
        'infoProfile' => $infoProfile,
        'keahlian'    => $keahlian,
    ]);
}
```

---

### `logout()` — Hapus Session & Redirect
```php
public function logout(Request $request): RedirectResponse
{
    $request->session()->forget('username');  // Hapus key 'username' dari Session
    return redirect('/');
}
```

---

## 🖼️ BAGIAN 6 — Layout & Blade Directives

### Master Layout (`layouts/app.blade.php`)

Layout utama adalah **kerangka HTML** yang dipakai bersama oleh semua halaman (kecuali Login yang punya desain sendiri).

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title', 'App') — Dexornit</title>
    <!-- Font, FA Icons, CSS Variables -->
    @yield('styles')    <!-- ← Slot untuk CSS tambahan per halaman -->
</head>
<body>

    <x-navbar />        <!-- ← Sisipkan Anonymous Component Navbar -->

    <main>
        <div class="container">
            @yield('content')   <!-- ← Slot utama konten halaman -->
        </div>
    </main>

    <x-footer />        <!-- ← Sisipkan Anonymous Component Footer -->

</body>
</html>
```

**Blade Directives yang digunakan:**

| Directive | Digunakan di | Fungsi |
|---|---|---|
| `@yield('title')` | `layouts/app.blade.php` | Slot untuk judul halaman |
| `@yield('styles')` | `layouts/app.blade.php` | Slot untuk CSS spesifik halaman |
| `@yield('content')` | `layouts/app.blade.php` | Slot untuk konten utama |
| `@extends('layouts.app')` | Setiap View | Memberitahu Laravel bahwa view ini memakai layout induk |
| `@section('title', '...')` | Setiap View | Mengisi slot `@yield('title')` |
| `@section('content')` | Setiap View | Mengisi slot konten utama |
| `@endsection` | Setiap View | Menutup blok `@section` |
| `@foreach($data as $item)` | Dashboard, Pengelolaan, Profile | Perulangan untuk render array dari Controller |
| `@endforeach` | Setiap View | Menutup blok `@foreach` |
| `@if / @else / @endif` | Pengelolaan, Login | Kondisional untuk badge status/error |
| `@csrf` | Form Login, Logout | Token keamanan di setiap form POST |
| `<x-navbar />` | Layout | Memanggil Anonymous Component navbar |
| `<x-footer />` | Layout | Memanggil Anonymous Component footer |

---

### Contoh View: Dashboard (`dashboard.blade.php`)

```blade
@extends('layouts.app')           {{-- Pakai layout induk --}}

@section('title', 'Dashboard')    {{-- Isi slot judul --}}

@section('styles')
<style>
    /* CSS khusus halaman dashboard */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); ... }
</style>
@endsection

@section('content')               {{-- Konten utama --}}

    <div class="welcome-bar">
        Selamat datang, {{ $username }}!    {{-- Data dari Controller via Session --}}
    </div>

    <div class="stats-grid">
        @foreach($statistik as $s)          {{-- Loop array $statistik dari Controller --}}
            <div class="stat-card">
                <span>{{ $s['nilai'] }}</span>
                <span>{{ $s['label'] }}</span>
            </div>
        @endforeach
    </div>

    <div class="activity-list">
        @foreach($aktivitas as $item)       {{-- Loop array $aktivitas dari Controller --}}
            <div>{{ $item['aksi'] }} — {{ $item['waktu'] }}</div>
        @endforeach
    </div>

@endsection
```

---

## 🔄 BAGIAN 7 — Alur Data (Sequence Diagram per Skenario)

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

## 🧩 BAGIAN 8 — Komponen Blade (Navbar & Footer)

### Cara Kerja Anonymous Component

Anonymous Component adalah file `.blade.php` di dalam folder `resources/views/components/` yang **bisa dipanggil langsung** menggunakan tag `<x-namafile />` tanpa perlu membuat class PHP terpisah.

**Membuat component:**
```bash
php artisan make:component navbar --view
php artisan make:component footer --view
```

**Memanggil di layout:**
```html
<x-navbar />    ← Laravel otomatis cari: resources/views/components/navbar.blade.php
<x-footer />    ← Laravel otomatis cari: resources/views/components/footer.blade.php
```

### Navbar (`components/navbar.blade.php`)

Fitur navbar:
- Logo Dexornit (LogoD.png) dengan background hijau matcha
- Link navigasi: Dashboard, Pengelolaan, Profil
- **Active state** — link yang aktif di-highlight hijau menggunakan `request()->routeIs('...')`
- **Tombol Keluar** — submit form POST ke `/logout`
- **Hamburger menu** — muncul di layar mobile (< 640px), toggle buka/tutup dengan JavaScript

```html
<!-- Contoh active state di navbar -->
<a href="{{ route('dashboard') }}"
   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <i class="fas fa-th-large"></i> Dashboard
</a>
```

### Footer (`components/footer.blade.php`)

```html
<footer>
    <i class="far fa-copyright"></i>
    {{ date('Y') }} <strong>Dexornit</strong>. All rights reserved.
</footer>
```

---

## 📱 BAGIAN 9 — Responsivitas (Mobile & Desktop)

Aplikasi ini sepenuhnya responsif tanpa framework CSS eksternal — murni **Vanilla CSS** dengan media query.

| Breakpoint | Perubahan yang Terjadi |
|---|---|
| `> 640px` (Desktop) | Navbar penuh, tabel pengelolaan tampil normal, grid 4-kolom |
| `< 640px` (Mobile) | Navbar menjadi hamburger menu, stats grid 2-kolom |
| `< 720px` (Mobile) | Profile layout berubah dari 2-kolom menjadi 1-kolom, avatar horizontal |
| `< 640px` (Mobile) | Tabel pengelolaan disembunyikan, diganti card list per tugas |

**Contoh CSS media query:**
```css
/* Desktop: 4 kolom */
.stats-grid {
    grid-template-columns: repeat(4, 1fr);
}

/* Mobile: 2 kolom */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
```

---

## 🎨 BAGIAN 10 — Desain & Tema

### Color Palette — Matcha Green

| Nama | Hex | Digunakan untuk |
|---|---|---|
| `--matcha-500` | `#4a9058` | Warna utama (button, icon, aksen) |
| `--matcha-600` | `#3a7347` | Hover state button & teks brand |
| `--matcha-100` | `#e3f1e5` | Background welcome bar, badge |
| `--matcha-200` | `#c5e2ca` | Border & surface sekunder |
| `--matcha-300` | `#9bcba3` | Ikon & teks muted |
| `--bg`         | `#f7faf7` | Background halaman |
| `--surface`    | `#ffffff` | Background card & navbar |

### Tipografi
- **Font:** Inter (Google Fonts) — modern, bersih, mudah dibaca
- **Weight:** 300 (thin) · 400 (regular) · 500 (medium) · 600 (semibold) · 700 (bold)

### Ikon
- **Font Awesome v5** — dipasang via CDN
- Digunakan di: navbar, form input, stat cards, tabel, skill bars, footer

---

## ✅ BAGIAN 11 — Checklist Pemenuhan Ketentuan UTS

### A. Kelengkapan File (20 Poin)

| File | Status |
|---|---|
| `routes/web.php` | ✅ Ada |
| `app/Http/Controllers/PageController.php` | ✅ Ada |
| `resources/views/layouts/app.blade.php` | ✅ Ada |
| `resources/views/login.blade.php` | ✅ Ada |
| `resources/views/dashboard.blade.php` | ✅ Ada |
| `resources/views/pengelolaan.blade.php` | ✅ Ada |
| `resources/views/profile.blade.php` | ✅ Ada |
| `resources/views/components/navbar.blade.php` | ✅ Ada |
| `resources/views/components/footer.blade.php` | ✅ Ada |

### B. Implementasi MVC (20 Poin)

| Kriteria | Status | Bukti |
|---|---|---|
| View dipanggil melalui Controller | ✅ | `return view('...')` di setiap method |
| View memanfaatkan Layout | ✅ | `@extends('layouts.app')` di semua view |
| Data dikirim via Controller | ✅ | `view('...', ['key' => $value])` |

### C. Blade Directives (15 Poin)

| Directive | Status | Lokasi |
|---|---|---|
| `@extends` | ✅ | dashboard, pengelolaan, profile |
| `@section` & `@endsection` | ✅ | Semua view |
| `@yield` | ✅ | `layouts/app.blade.php` (title, styles, content) |
| `@include` / `<x-component>` | ✅ | `<x-navbar />` dan `<x-footer />` di layout |

### D. Request Handling (10 Poin)

| Kriteria | Status | Bukti |
|---|---|---|
| Username dikirim ke Dashboard | ✅ | Session → `$username` → `view('dashboard', ...)` |
| Username dikirim ke Profile | ✅ | Session → `$username` → `view('profile', ...)` |

### E. Array Rendering (10 Poin)

| Halaman | Array | Status |
|---|---|---|
| Dashboard | `$statistik` (4 item), `$aktivitas` (4 item) | ✅ `@foreach` |
| Pengelolaan | `$daftarTugas` (6 item) | ✅ `@foreach` |
| Profile | `$infoProfile` (5 item), `$keahlian` (4 item) | ✅ `@foreach` x2 |

### F. Kreativitas & UI (15 Poin)

| Aspek | Implementasi |
|---|---|
| Layout rapi | Grid CSS, card system, spacing konsisten |
| Responsif | Media query untuk mobile, tablet, desktop |
| Visual menarik | Matcha palette, Font Awesome icons, gradient skill bar |
| 0 Lorem Ipsum | Semua teks bermakna dan relevan |
| Fitur tambahan | Hamburger menu, active nav state, badge status berwarna |

---

## 🚀 BAGIAN 12 — Cara Menjalankan Project

### Prasyarat
- PHP >= 8.1
- Composer
- Laravel >= 10

### Langkah-langkah

```bash
# 1. Masuk ke direktori project
cd "e:\Kuliah\Semester 4\PWEB\UTSB"

# 2. Install dependencies (jika belum)
composer install

# 3. Copy file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Jalankan development server
php artisan serve
```

### Akses Aplikasi

Buka browser dan akses: **http://127.0.0.1:8000**

Browser akan otomatis diarahkan ke halaman Login.

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

---

*Dokumentasi ini dibuat untuk keperluan presentasi UTS Pemrograman Web.*  
*Semua kode ditulis mengikuti standar Laravel MVC dan ketentuan yang ditetapkan.*
