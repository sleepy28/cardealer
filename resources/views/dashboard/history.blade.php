@extends('layouts.app')

@section('title', 'Riwayat Duty | Car dealer')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark m-0">Riwayat Duty</h2>
            <p class="text-muted">Lihat data kehadiran berdasarkan rentang tanggal.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white p-4 rounded shadow-sm border mb-4">
        <form action="{{ route('duty.history') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="start_date" class="form-label fw-bold small text-muted">DARI TANGGAL</label>
                <input type="date" class="form-control" id="start_date" name="start_date" 
                       value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label fw-bold small text-muted">SAMPAI TANGGAL</label>
                <input type="date" class="form-control" id="end_date" name="end_date" 
                       value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-bold w-100">
                        <i class="fa-solid fa-filter me-2"></i> Tampilkan
                    </button>
                    <a href="{{ route('duty.history') }}" class="btn btn-outline-secondary w-auto" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white p-4 rounded shadow-sm border">
        
        <div class="mb-3">
            <span class="badge bg-info text-dark border">
                Menampilkan data: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light text-secondary small">
                    <tr>
                        <th class="py-3 ps-3">TANGGAL</th>
                        <th class="py-3">HARI</th>
                        <th class="py-3">SHIFT</th>
                        <th class="py-3">MULAI (ON)</th>
                        <th class="py-3">SELESAI (OFF)</th>
                        <th class="py-3">DURASI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $session)
                    <tr>
                        <td class="ps-3 fw-bold">{{ \Carbon\Carbon::parse($session->start_time)->format('d/m/Y') }}</td>
                        <td class="text-muted">{{ \Carbon\Carbon::parse($session->start_time)->isoFormat('dddd') }}</td>
                        <td>
                            @php
                                $h = \Carbon\Carbon::parse($session->start_time)->hour;
                                $sh = ($h >= 6 && $h < 18) ? 'Siang' : 'Malam';
                                $cl = ($sh == 'Siang') ? 'warning text-dark' : 'dark text-white';
                            @endphp
                            <span class="badge bg-{{ $cl }} rounded-pill px-3">{{ $sh }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}</td>
                        <td>{{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '-' }}</td>
                        <td class="fw-bold text-primary">
                            {{ $session->duration_hours ? number_format($session->duration_hours, 2) . ' Jam' : 'Sedang Duty' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-regular fa-calendar-xmark fa-2x mb-3 d-block"></i>
                            Tidak ada data duty pada rentang tanggal ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection