@extends('layouts.app')

@section('content')


<style>
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    
    .animate-enter {
        opacity: 0;
        animation: fadeInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    
    .table-row-interactive {
        transition: all 0.2s ease-in-out;
        background-color: #fff;
    }
    .table-row-interactive:hover {
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        z-index: 10;
        position: relative;
        background-color: #f8f9fa;
    }

    
    .avatar-modern {
        transition: transform 0.2s;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .table-row-interactive:hover .avatar-modern {
        transform: scale(1.1);
    }

    
    .card-payout {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    
    .card-payout::after {
        content: '';
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background-image: radial-gradient(circle at 90% 10%, rgba(255,255,255,0.1) 0%, transparent 60%);
        pointer-events: none;
    }
</style>

<div class="container-fluid py-4">
    
    
    <div class="d-flex justify-content-between align-items-center mb-4 animate-enter" style="animation-delay: 0.1s">
        <div>
            <h2 class="fw-bold text-dark m-0" style="letter-spacing: -0.5px;">Salary Report</h2>
            <p class="text-secondary small m-0">Laporan penggajian mingguan karyawan.</p>
        </div>
        
        <div class="dropdown">
            <button class="btn btn-white border dropdown-toggle shadow-sm px-4 rounded-pill" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                {{ $weeksAgo == 0 ? 'Minggu Ini' : "$weeksAgo Minggu Lalu" }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                <li><a class="dropdown-item py-2" href="?week=0">Minggu Ini</a></li>
                <li><a class="dropdown-item py-2" href="?week=1">1 Minggu Lalu</a></li>
                <li><a class="dropdown-item py-2" href="?week=2">2 Minggu Lalu</a></li>
            </ul>
        </div>
    </div>

    
    <div class="card card-payout shadow-lg text-white mb-4 animate-enter" style="animation-delay: 0.2s">
        <div class="card-body p-5 d-flex justify-content-between align-items-center position-relative z-1">
            <div>
                <h6 class="text-uppercase text-white-50 mb-2 fw-bold" style="letter-spacing: 1px; font-size: 0.75rem;">Total Estimasi Payout</h6>
                <h1 class="display-4 fw-bold mb-1" style="text-shadow: 0 4px 10px rgba(0,0,0,0.2);">${{ number_format($totalPayout, 0, ',', '.') }}</h1>
                <div class="badge bg-white bg-opacity-10 fw-normal px-3 py-2 mt-2 rounded-pill border border-white border-opacity-25">
                    <i class="far fa-clock me-1"></i> Periode: {{ $startOfWeek->format('d M') }} - {{ $endOfWeek->format('d M Y') }}
                </div>
            </div>
            <div class="bg-white bg-opacity-20 p-4 rounded-circle shadow-inner">
                <i class="fas fa-wallet fa-3x text-white"></i>
            </div>
        </div>
    </div>

    
    <div class="card card-modern animate-enter" style="animation-delay: 0.3s">
        <div class="card-header bg-white py-4 border-bottom border-light">
            <h6 class="mb-0 fw-bold text-dark">
                <span class="bg-primary bg-opacity-10 text-primary rounded p-2 me-2"><i class="fas fa-users"></i></span>
                Employee Details
            </h6>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 30%;">Employee</th>
                        <th class="py-3 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 20%;">Role & Base</th>
                        <th class="py-3 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 15%;">Duty Time</th>
                        <th class="py-3 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" style="width: 20%;">Formula</th>
                        <th class="pe-4 py-3 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end" style="width: 15%;">Final Salary</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($report as $row)
                    
                    <tr class="table-row-interactive animate-enter" style="animation-delay: {{ ($loop->index * 100) + 400 }}ms">
                        <td class="ps-4 py-3 border-bottom-0">
                            <div class="d-flex align-items-center">
                                <img src="{{ !empty($row['user']->avatar) ? asset('storage/' . $row['user']->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($row['user']->name) . '&background=random' }}" 
                                     alt="{{ $row['user']->name }}"
                                     class="rounded-circle me-3 avatar-modern" 
                                     width="45" 
                                     height="45"
                                     style="object-fit: cover;">
                                     
                                <div>
                                    <div class="fw-bold text-dark">{{ $row['user']->name }}</div>
                                    <small class="{{ $row['css_class'] }} d-inline-block px-2 py-0 rounded-pill mt-1" style="font-size: 0.65rem; font-weight: 600;">
                                        {{ $row['status'] }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        <td class="border-bottom-0">
                            <div class="d-flex flex-column">
                                <span class="badge bg-light text-dark border align-self-start mb-1 fw-normal">{{ $row['role'] }}</span>
                                
                                <div style="font-size: 0.75rem;" class="text-secondary mt-1">
                                    Base: <span class="fw-bold text-dark">${{ number_format($row['base_salary']) }}</span>
                                </div>

                                <div style="font-size: 0.75rem;" class="text-secondary">
                                    Rate: 
                                    <span class="fw-bold {{ $row['jam_bulat'] < 12 ? 'text-danger' : 'text-success' }}">
                                        ${{ number_format($row['active_rate']) }}/hr
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="border-bottom-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded p-2 me-2 text-center" style="min-width: 40px;">
                                    <i class="far fa-clock text-muted"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $row['formatted_time'] }}</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Calc: {{ $row['jam_bulat'] }} Jam</small>
                                </div>
                            </div>
                        </td>

                        <td class="text-center border-bottom-0">
                            <code class="text-primary bg-blue-soft border border-primary border-opacity-25 px-3 py-1 rounded-pill" style="font-size: 0.75rem; background-color: #ecf4ff;">
                                {{ $row['rumus'] }}
                            </code>
                        </td>

                        <td class="text-end pe-4 border-bottom-0">
                            <h6 class="fw-bold text-success mb-0" style="font-size: 1.1rem;">${{ number_format($row['salary_final']) }}</h6>
                            <small class="text-muted" style="font-size: 0.7rem;">Net</small>
                        </td>
                    </tr>
                    @empty
                    <tr class="animate-enter" style="animation-delay: 400ms">
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="py-4">
                                <i class="fas fa-inbox fa-3x mb-3 text-light"></i>
                                <p>Belum ada data duty untuk minggu ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white py-3 border-top-0">
            <div class="alert alert-light border mb-0 text-muted small shadow-sm">
                <i class="fas fa-info-circle me-2 text-primary"></i> 
                Data dihitung berdasarkan <strong>total jam (Floor)</strong> x Aturan Gaji Karyawan. Rate $500/hr berlaku jika > 12 Jam.
            </div>
        </div>
    </div>
</div>
@endsection