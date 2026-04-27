# 📋 Project UTS
## Aplikasi Manajemen Tugas Berbasis Laravel MVC

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

```mermaid
sequenceDiagram
    participant B as Browser (Client)
    participant R as Router (web.php)
    participant C as PageController
    participant V as Blade View

    B->>R: HTTP GET /login
    R->>C: Cocokkan route, panggil PageController@login
    C->>V: return view('login')
    V-->>C: Kompilasi login.blade.php → HTML
    C-->>B: HTTP 200 Response + HTML form login
```

### Skenario 2 — User Submit Form Login

```mermaid
sequenceDiagram
    participant B as Browser (Client)
    participant R as Router (web.php)
    participant C as PageController
    participant S as Session

    B->>R: HTTP POST /login/proses (payload: username=Danu)
    R->>C: Panggil PageController@prosesLogin(Request)
    C->>C: $request->input('username') → validasi kosong?
    C->>S: $request->session()->put('username', 'Danu')
    S-->>C: Session tersimpan (key: 'username')
    C-->>B: HTTP 302 Redirect → /dashboard
```

### Skenario 3 — User Membuka Dashboard

```mermaid
sequenceDiagram
    participant B as Browser (Client)
    participant R as Router (web.php)
    participant C as PageController
    participant S as Session
    participant V as Blade View

    B->>R: HTTP GET /dashboard (bawa Session Cookie)
    R->>C: Panggil PageController@dashboard(Request)
    C->>S: $request->session()->get('username', 'Pengguna')
    S-->>C: Return 'Danu'
    C->>C: Siapkan array $statistik dan $aktivitas
    C->>V: return view('dashboard', [username, statistik, aktivitas])
    V-->>C: Kompilasi dashboard.blade.php + @extends layout + @foreach data
    C-->>B: HTTP 200 Response + HTML utuh
```

### Skenario 4 — User Membuka Pengelolaan

```mermaid
sequenceDiagram
    participant B as Browser (Client)
    participant R as Router (web.php)
    participant C as PageController
    participant S as Session
    participant V as Blade View

    B->>R: HTTP GET /pengelolaan
    R->>C: Panggil PageController@pengelolaan(Request)
    C->>S: $request->session()->get('username')
    S-->>C: Return 'Danu'
    C->>C: Siapkan array $daftarTugas (6 item)
    C->>V: return view('pengelolaan', [username, daftarTugas])
    V-->>C: Kompilasi pengelolaan.blade.php + @foreach $daftarTugas
    C-->>B: HTTP 200 Response + HTML tabel tugas
```

### Skenario 5 — User Membuka Profil

```mermaid
sequenceDiagram
    participant B as Browser (Client)
    participant R as Router (web.php)
    participant C as PageController
    participant S as Session
    participant V as Blade View

    B->>R: HTTP GET /profile
    R->>C: Panggil PageController@profile(Request)
    C->>S: $request->session()->get('username')
    S-->>C: Return 'Danu'
    C->>C: Siapkan array $infoProfile dan $keahlian
    C->>V: return view('profile', [username, infoProfile, keahlian])
    V-->>C: Kompilasi profile.blade.php + @foreach $infoProfile + @foreach $keahlian
    C-->>B: HTTP 200 Response + HTML halaman profil
```

### Skenario 6 — User Logout

```mermaid
sequenceDiagram
    participant B as Browser (Client)
    participant R as Router (web.php)
    participant C as PageController
    participant S as Session

    B->>R: HTTP POST /logout
    R->>C: Panggil PageController@logout(Request)
    C->>S: $request->session()->forget('username')
    S-->>C: Session 'username' dihapus
    C-->>B: HTTP 302 Redirect → /login
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

### Tampilan Login
<img width="1919" height="909" alt="image" src="https://github.com/user-attachments/assets/c4382e0e-bdf7-49d7-97ae-d59fc42faaaa" />

### Tampilan Dashboard
<img width="1919" height="910" alt="image" src="https://github.com/user-attachments/assets/a3f7646a-23a2-419d-9829-faf6c8eb6033" />

### Tampilan Pengelolaan
<img width="1919" height="910" alt="image" src="https://github.com/user-attachments/assets/737120b9-8ac0-4729-a951-9751e5828824" />

### Tampilan Profile
<img width="1919" height="911" alt="image" src="https://github.com/user-attachments/assets/804e3a08-a881-4b86-8f61-4a36b3fc661f" />
