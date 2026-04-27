@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* ── Welcome Bar ── */
    .welcome-bar {
        background: linear-gradient(135deg, #e3f1e5 0%, #c5e2ca 100%);
        border: 1px solid #c5e2ca;
        border-radius: 14px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .welcome-bar .avatar {
        width: 44px; height: 44px;
        background: #4a9058;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
        color: #fff;
    }

    .welcome-bar h2 {
        font-size: 1rem;
        font-weight: 600;
        color: #2c3e2d;
    }

    .welcome-bar p {
        font-size: 0.8rem;
        color: #6b7f6c;
        margin-top: 2px;
    }

    /* ── Section title ── */
    .section-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #2c3e2d;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .section-title i { color: #9bcba3; }

    /* ── Stats Grid ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #dde8de;
        border-radius: 12px;
        padding: 18px 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .stat-card:hover {
        box-shadow: 0 4px 16px rgba(44,62,45,0.10);
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 36px; height: 36px;
        background: #e3f1e5;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #3a7347;
    }

    .stat-nilai {
        font-size: 1.9rem;
        font-weight: 700;
        color: #2c3e2d;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.76rem;
        color: #6b7f6c;
        font-weight: 500;
    }

    /* ── Activity List ── */
    .activity-list {
        background: #fff;
        border: 1px solid #dde8de;
        border-radius: 12px;
        overflow: hidden;
    }

    .activity-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 18px;
        border-bottom: 1px solid #f4f9f4;
        gap: 12px;
        flex-wrap: wrap;
    }

    .activity-item:last-child { border-bottom: none; }

    .activity-text {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.855rem;
        color: #2c3e2d;
        flex: 1;
        min-width: 0;
    }

    .activity-text i { color: #9bcba3; font-size: 0.75rem; flex-shrink: 0; }

    .activity-time {
        font-size: 0.75rem;
        color: #9bcba3;
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .stat-nilai  { font-size: 1.6rem; }
        .welcome-bar { padding: 14px 16px; gap: 10px; }
        .welcome-bar .avatar { width: 38px; height: 38px; }
        .activity-item { padding: 11px 14px; }
    }
</style>
@endsection

@section('content')

    {{-- Welcome Bar --}}
    <div class="welcome-bar">
        <div class="avatar">
            <i class="fas fa-hand-wave" style="font-size:1rem;"></i>
            👋
        </div>
        <div>
            <h2>Selamat datang, {{ $username }}!</h2>
            <p>Semoga hari ini produktif. Berikut ringkasan aktivitas Anda.</p>
        </div>
    </div>

    {{-- Statistik --}}
    <p class="section-title"><i class="fas fa-chart-bar"></i> Ringkasan</p>
    <div class="stats-grid">
        @foreach($statistik as $s)
            <div class="stat-card">
                <div class="stat-icon">
                    @if($s['label'] === 'Total Tugas')      <i class="fas fa-clipboard-list"></i>
                    @elseif($s['label'] === 'Selesai')       <i class="fas fa-check-circle"></i>
                    @elseif($s['label'] === 'Dalam Proses')  <i class="fas fa-sync-alt"></i>
                    @else                                     <i class="fas fa-clock"></i>
                    @endif
                </div>
                <span class="stat-nilai">{{ $s['nilai'] }}</span>
                <span class="stat-label">{{ $s['label'] }}</span>
            </div>
        @endforeach
    </div>

    {{-- Aktivitas Terbaru --}}
    <p class="section-title"><i class="fas fa-history"></i> Aktivitas Terbaru</p>
    <div class="activity-list">
        @foreach($aktivitas as $item)
            <div class="activity-item">
                <div class="activity-text">
                    <i class="fas fa-circle"></i>
                    {{ $item['aksi'] }}
                </div>
                <span class="activity-time">
                    <i class="far fa-clock"></i> {{ $item['waktu'] }}
                </span>
            </div>
        @endforeach
    </div>

@endsection
