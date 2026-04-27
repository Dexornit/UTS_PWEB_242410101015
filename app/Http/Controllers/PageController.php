<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PageController extends Controller
{
    // Tampilkan halaman login
    public function login(): View
    {
        return view('login');
    }

    // Proses form login & simpan username ke session
    public function prosesLogin(Request $request): RedirectResponse
    {
        $username = $request->input('username');

        if (!$username) {
            return back()->with('error', 'Username tidak boleh kosong.');
        }

        $request->session()->put('username', $username);

        return redirect('/dashboard');
    }

    // Tampilkan halaman dashboard dengan data dari session
    public function dashboard(Request $request): View
    {
        $username = $request->session()->get('username', 'Pengguna');

        // Data statistik untuk ditampilkan di dashboard
        $statistik = [
            ['label' => 'Total Tugas', 'nilai' => 12, 'ikon' => '📋'],
            ['label' => 'Selesai', 'nilai' => 8, 'ikon' => '✅'],
            ['label' => 'Dalam Proses', 'nilai' => 3, 'ikon' => '🔄'],
            ['label' => 'Tertunda', 'nilai' => 1, 'ikon' => '⏳'],
        ];

        // Aktivitas terbaru
        $aktivitas = [
            ['aksi' => 'Tugas "Laporan Akhir" ditambahkan', 'waktu' => '2 jam lalu'],
            ['aksi' => 'Tugas "Desain UI" diselesaikan', 'waktu' => '5 jam lalu'],
            ['aksi' => 'Tugas "Review Kode" diperbarui', 'waktu' => '1 hari lalu'],
            ['aksi' => 'Tugas "Meeting Tim" selesai', 'waktu' => '2 hari lalu'],
        ];

        return view('dashboard', [
            'username'  => $username,
            'statistik' => $statistik,
            'aktivitas' => $aktivitas,
        ]);
    }

    // Tampilkan halaman pengelolaan dengan daftar tugas
    public function pengelolaan(Request $request): View
    {
        $username = $request->session()->get('username', 'Pengguna');

        $daftarTugas = [
            ['id' => 1, 'nama' => 'Laporan Akhir Semester', 'prioritas' => 'Tinggi',   'status' => 'Dalam Proses', 'deadline' => '30 Apr 2026'],
            ['id' => 2, 'nama' => 'Desain Antarmuka Web',   'prioritas' => 'Tinggi',   'status' => 'Selesai',      'deadline' => '25 Apr 2026'],
            ['id' => 3, 'nama' => 'Review Pull Request',    'prioritas' => 'Sedang',   'status' => 'Tertunda',     'deadline' => '1 Mei 2026'],
            ['id' => 4, 'nama' => 'Dokumentasi API',        'prioritas' => 'Sedang',   'status' => 'Dalam Proses', 'deadline' => '5 Mei 2026'],
            ['id' => 5, 'nama' => 'Testing Unit',           'prioritas' => 'Rendah',   'status' => 'Tertunda',     'deadline' => '10 Mei 2026'],
            ['id' => 6, 'nama' => 'Deploy ke Production',   'prioritas' => 'Tinggi',   'status' => 'Tertunda',     'deadline' => '15 Mei 2026'],
        ];

        return view('pengelolaan', [
            'username'    => $username,
            'daftarTugas' => $daftarTugas,
        ]);
    }

    // Tampilkan halaman profil dengan data user
    public function profile(Request $request): View
    {
        $username = $request->session()->get('username', 'Pengguna');

        $infoProfile = [
            ['label' => 'Username',   'nilai' => $username],
            ['label' => 'Role',       'nilai' => 'Mahasiswa'],
            ['label' => 'Jurusan',    'nilai' => 'Teknik Informatika'],
            ['label' => 'Semester',   'nilai' => '4'],
            ['label' => 'Status',     'nilai' => 'Aktif'],
        ];

        $keahlian = [
            ['nama' => 'HTML & CSS',   'level' => 90],
            ['nama' => 'JavaScript',   'level' => 75],
            ['nama' => 'PHP & Laravel','level' => 65],
            ['nama' => 'Git',          'level' => 80],
        ];

        return view('profile', [
            'username'    => $username,
            'infoProfile' => $infoProfile,
            'keahlian'    => $keahlian,
        ]);
    }

    // Logout - hapus session
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('username');
        return redirect('/');
    }
}
