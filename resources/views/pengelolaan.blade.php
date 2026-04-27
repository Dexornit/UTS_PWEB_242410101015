@extends('layouts.app')

@section('title', 'Pengelolaan')

@section('styles')
<style>
    /* ── Page Header ── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 22px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .page-header h1 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c3e2d;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .page-header h1 i { color: #4a9058; }

    .page-header p {
        font-size: 0.82rem;
        color: #6b7f6c;
        margin-top: 3px;
    }

    /* ── Table (desktop) ── */
    .table-wrap {
        background: #fff;
        border: 1px solid #dde8de;
        border-radius: 12px;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.865rem;
    }

    thead th {
        background: #f4f9f4;
        padding: 11px 16px;
        text-align: left;
        font-size: 0.73rem;
        font-weight: 600;
        color: #6b7f6c;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 1px solid #dde8de;
        white-space: nowrap;
    }

    thead th i { margin-right: 5px; color: #9bcba3; }

    tbody tr {
        border-bottom: 1px solid #f4f9f4;
        transition: background 0.15s;
    }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover      { background: #f9fcf9; }

    tbody td { padding: 12px 16px; color: #2c3e2d; }

    .no-col { color: #9bcba3; font-size: 0.78rem; }

    /* ── Badges ── */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.74rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-tinggi   { background: #fdecea; color: #c0392b; }
    .badge-sedang   { background: #fef9e7; color: #a07800; }
    .badge-rendah   { background: #f4f9f4; color: #4a9058; }
    .badge-selesai  { background: #e3f1e5; color: #2f5c39; }
    .badge-proses   { background: #e8f1fd; color: #2455a4; }
    .badge-tertunda { background: #f9f4e3; color: #7d5a00; }

    /* ── Mobile card layout ── */
    .card-list { display: none; }

    .task-card {
        background: #fff;
        border: 1px solid #dde8de;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 10px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .task-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .task-card-name {
        font-weight: 600;
        font-size: 0.875rem;
        color: #2c3e2d;
    }

    .task-card-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .task-deadline {
        font-size: 0.76rem;
        color: #6b7f6c;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ── Responsive switch ── */
    @media (max-width: 640px) {
        .table-wrap { display: none; }
        .card-list  { display: block; }
    }
</style>
@endsection

@section('content')

    <div class="page-header">
        <div>
            <h1><i class="fas fa-tasks"></i> Pengelolaan Tugas</h1>
            <p>Halo <strong>{{ $username }}</strong>, berikut daftar tugas yang perlu dikelola.</p>
        </div>
    </div>

    {{-- Desktop: Table View --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag"></i>#</th>
                    <th><i class="fas fa-file-alt"></i>Nama Tugas</th>
                    <th><i class="fas fa-flag"></i>Prioritas</th>
                    <th><i class="fas fa-info-circle"></i>Status</th>
                    <th><i class="fas fa-calendar-alt"></i>Deadline</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarTugas as $tugas)
                    <tr>
                        <td class="no-col">{{ $tugas['id'] }}</td>
                        <td>{{ $tugas['nama'] }}</td>
                        <td>
                            @php $p = strtolower($tugas['prioritas']); @endphp
                            <span class="badge badge-{{ $p }}">
                                @if($p === 'tinggi') <i class="fas fa-arrow-up"></i>
                                @elseif($p === 'sedang') <i class="fas fa-minus"></i>
                                @else <i class="fas fa-arrow-down"></i>
                                @endif
                                {{ $tugas['prioritas'] }}
                            </span>
                        </td>
                        <td>
                            @php
                                $s = match($tugas['status']) {
                                    'Selesai'      => 'selesai',
                                    'Dalam Proses' => 'proses',
                                    default        => 'tertunda',
                                };
                            @endphp
                            <span class="badge badge-{{ $s }}">
                                @if($s === 'selesai') <i class="fas fa-check"></i>
                                @elseif($s === 'proses') <i class="fas fa-sync-alt"></i>
                                @else <i class="fas fa-pause"></i>
                                @endif
                                {{ $tugas['status'] }}
                            </span>
                        </td>
                        <td style="color:#6b7f6c; font-size:0.84rem;">
                            <i class="far fa-calendar" style="margin-right:5px;color:#9bcba3;"></i>
                            {{ $tugas['deadline'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Mobile: Card View --}}
    <div class="card-list">
        @foreach($daftarTugas as $tugas)
            @php
                $p = strtolower($tugas['prioritas']);
                $s = match($tugas['status']) {
                    'Selesai'      => 'selesai',
                    'Dalam Proses' => 'proses',
                    default        => 'tertunda',
                };
            @endphp
            <div class="task-card">
                <div class="task-card-top">
                    <span class="task-card-name">{{ $tugas['nama'] }}</span>
                    <span class="badge badge-{{ $p }}">{{ $tugas['prioritas'] }}</span>
                </div>
                <div class="task-card-meta">
                    <span class="badge badge-{{ $s }}">{{ $tugas['status'] }}</span>
                    <span class="task-deadline">
                        <i class="far fa-calendar-alt"></i> {{ $tugas['deadline'] }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

@endsection
