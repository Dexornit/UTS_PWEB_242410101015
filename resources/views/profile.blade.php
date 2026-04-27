@extends('layouts.app')

@section('title', 'Profil')

@section('styles')
<style>
    /* ── Profile Grid ── */
    .profile-grid {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 18px;
        align-items: start;
    }

    /* ── Avatar Card ── */
    .avatar-card {
        background: #fff;
        border: 1px solid #dde8de;
        border-radius: 14px;
        padding: 28px 18px;
        text-align: center;
    }

    .avatar-circle {
        width: 70px; height: 70px;
        background: linear-gradient(135deg, #4a9058, #9bcba3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin: 0 auto 14px;
        color: #fff;
    }

    .avatar-name {
        font-size: 1rem;
        font-weight: 700;
        color: #2c3e2d;
    }

    .avatar-role {
        font-size: 0.78rem;
        color: #6b7f6c;
        margin-top: 4px;
    }

    .avatar-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #e3f1e5;
        color: #2f5c39;
        font-size: 0.74rem;
        font-weight: 600;
        padding: 4px 11px;
        border-radius: 99px;
        margin-top: 12px;
    }

    /* ── Info Cards ── */
    .info-card {
        background: #fff;
        border: 1px solid #dde8de;
        border-radius: 14px;
        padding: 22px;
        margin-bottom: 16px;
    }

    .info-card:last-child { margin-bottom: 0; }

    .info-card-title {
        font-size: 0.855rem;
        font-weight: 600;
        color: #2c3e2d;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f4f9f4;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .info-card-title i { color: #9bcba3; }

    .info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 9px 0;
        border-bottom: 1px solid #f4f9f4;
        font-size: 0.855rem;
        gap: 12px;
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        color: #6b7f6c;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    .info-label i { color: #c5e2ca; font-size: 0.8rem; }

    .info-value {
        font-weight: 500;
        color: #2c3e2d;
        text-align: right;
    }

    /* ── Skill Bars ── */
    .skill-item { margin-bottom: 14px; }
    .skill-item:last-child { margin-bottom: 0; }

    .skill-header {
        display: flex;
        justify-content: space-between;
        font-size: 0.82rem;
        color: #2c3e2d;
        margin-bottom: 6px;
    }

    .skill-name { display: flex; align-items: center; gap: 6px; }
    .skill-name i { color: #9bcba3; font-size: 0.78rem; }
    .skill-pct { color: #6b7f6c; font-size: 0.78rem; }

    .skill-bar-bg {
        background: #e3f1e5;
        border-radius: 99px;
        height: 7px;
        overflow: hidden;
    }

    .skill-bar-fill {
        background: linear-gradient(90deg, #4a9058, #9bcba3);
        height: 100%;
        border-radius: 99px;
    }

    /* ── Responsive ── */
    @media (max-width: 720px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }

        .avatar-card {
            display: flex;
            align-items: center;
            gap: 16px;
            text-align: left;
            padding: 18px;
        }

        .avatar-circle {
            width: 56px; height: 56px;
            font-size: 1.4rem;
            margin: 0;
            flex-shrink: 0;
        }

        .avatar-badge { display: inline-flex; }
    }

    @media (max-width: 480px) {
        .info-card { padding: 16px; }
        .avatar-card { gap: 12px; }
    }
</style>
@endsection

@section('content')

    <div class="profile-grid">

        {{-- Kiri: Avatar Card --}}
        <div class="avatar-card">
            <div class="avatar-circle">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <div class="avatar-name">{{ $username }}</div>
                <div class="avatar-role">Mahasiswa Informatika</div>
                <div class="avatar-badge">
                    <i class="fas fa-circle" style="font-size:0.5rem;"></i> Aktif
                </div>
            </div>
        </div>

        {{-- Kanan: Info & Skill --}}
        <div>

            {{-- Informasi Profil --}}
            <div class="info-card">
                <div class="info-card-title">
                    <i class="fas fa-id-card"></i> Informasi Profil
                </div>
                @foreach($infoProfile as $info)
                    <div class="info-row">
                        <span class="info-label">
                            @if($info['label'] === 'Username')    <i class="fas fa-user"></i>
                            @elseif($info['label'] === 'Role')    <i class="fas fa-tag"></i>
                            @elseif($info['label'] === 'Jurusan') <i class="fas fa-graduation-cap"></i>
                            @elseif($info['label'] === 'Semester')<i class="fas fa-book-open"></i>
                            @else                                  <i class="fas fa-info-circle"></i>
                            @endif
                            {{ $info['label'] }}
                        </span>
                        <span class="info-value">{{ $info['nilai'] }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Keahlian --}}
            <div class="info-card">
                <div class="info-card-title">
                    <i class="fas fa-code"></i> Keahlian
                </div>
                @foreach($keahlian as $skill)
                    <div class="skill-item">
                        <div class="skill-header">
                            <span class="skill-name">
                                <i class="fas fa-chevron-right"></i>
                                {{ $skill['nama'] }}
                            </span>
                            <span class="skill-pct">{{ $skill['level'] }}%</span>
                        </div>
                        <div class="skill-bar-bg">
                            <div class="skill-bar-fill" style="width: {{ $skill['level'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

@endsection
