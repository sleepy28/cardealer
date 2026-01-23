@extends('layouts.app')

@section('content')



<style>
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    
    .fade-in-up {
        opacity: 0; 
        animation: fadeInUp 0.8s ease-out forwards; 
    }

    
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
</style>

<div class="container-fluid py-4">
    
    
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
        <div>
            <h2 class="fw-bold text-dark m-0">Duty Salary Report</h2>
            <p class="text-muted small m-0">Your salary from duty estimate</p>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body py-2 px-3">
                <small class="text-uppercase text-muted fw-bold" style="font-size: 10px;">Periode Saat Ini</small>
                <div class="fw-bold text-dark">{{ $data['start_date'] }} - {{ $data['end_date'] }}</div>
            </div>
        </div>
    </div>

    
    <div class="row g-4 fade-in-up delay-1">
        
        <div class="col-12">
            <div class="card border-0 shadow-lg overflow-hidden text-white" 
                 style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); border-radius: 15px;">
                
                <div style="position: absolute; top: -20px; right: -20px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -40px; left: -20px; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>

                <div class="card-body p-5 position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="text-uppercase text-white-50 mb-2 ls-1" style="letter-spacing: 1px;">Current Week Estimate</h6>
                            <h1 class="display-4 fw-bold mb-2">
                                ${{ number_format($data['gaji_final'], 0, ',', '.') }}
                            </h1>
                            
                            <div class="d-inline-flex align-items-center gap-2 mt-2">
                                @if($data['total_jam_raw'] >= 12)
                                    <span class="badge bg-success bg-opacity-25 border border-success border-opacity-25 text-white px-3 py-2 rounded-pill">
                                        <i class="fas fa-check-circle me-1"></i> Target Tercapai
                                    </span>
                                @else
                                    <span class="badge bg-warning bg-opacity-25 border border-warning border-opacity-25 text-white px-3 py-2 rounded-pill">
                                        <i class="fas fa-exclamation-triangle me-1"></i> Under Target (< 12 hours)
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 text-md-end mt-4 mt-md-0">
                            <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(5px);">
                                <small class="d-block text-white-50 mb-1">Total Hours Calculated</small>
                                <span class="h3 fw-bold m-0">{{ $data['formatted_time'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-7">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-end mb-3">
                        <div>
                            <h5 class="fw-bold text-dark">Progress Target</h5>
                            <p class="text-muted small mb-0">Mandatory target 12 hours per week.</p>
                        </div>
                        <span class="h4 fw-bold {{ $data['total_jam_raw'] >= 12 ? 'text-success' : 'text-primary' }}">
                            {{ round(($data['total_jam_raw'] / 12) * 100) }}%
                        </span>
                    </div>

                    <div class="progress" style="height: 12px; border-radius: 10px; background-color: #e9ecef;">
                        <div class="progress-bar {{ $data['total_jam_raw'] >= 12 ? 'bg-success' : 'bg-primary' }}" 
                             role="progressbar" 
                             style="width: {{ min(($data['total_jam_raw'] / 12) * 100, 100) }}%; border-radius: 10px;">
                        </div>
                    </div>
                    <small class="text-muted mt-3 d-block">
                        <i class="fas fa-info-circle me-1"></i>
                        You have been completed <strong>{{ $data['formatted_time'] }}</strong>.
                    </small>
                </div>
            </div>
        </div>

        
        <div class="col-md-5">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">Details</h5>
                    
                    <div class="row g-0 mb-4 p-2 bg-transparent  border rounded-3">
                        <div class="col-6 border-end px-2">
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 9px;">Role</small>
                            <div class="fw-bold text-dark text-capitalize">
                                <i class="fas fa-user-tag text-primary me-1" style="font-size: 10px;"></i> {{ $data['role'] }}
                            </div>
                        </div>
                        <div class="col-6 px-3">
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 9px;">Base Salary (Pokok)</small>
                            <div class="fw-bold text-dark">
                                <i class="fas fa-money-bill text-success me-1" style="font-size: 10px;"></i> ${{ number_format($data['base_salary'], 0) }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 10px;">Your salary per hours</small>
                            @if($data['total_jam_raw'] < 12)
                                <div class="text-danger small fst-italic mt-1"><i class="fas fa-arrow-down me-1"></i>penalty 50%</div>
                            @endif
                        </div>
                        <div class="text-end">
                            <span class="display-6 fw-bold {{ $data['total_jam_raw'] < 12 ? 'text-danger' : 'text-success' }}">
                                ${{ number_format($data['current_rate'], 0) }}
                            </span>
                            <small class="text-muted fs-6">/ hour</small>
                        </div>
                    </div>

                    <div class="p-3 bg-transparent  rounded-3 mb-3 bg-light border">
                        <small class="text-uppercase text-muted fw-bold" style="font-size: 10px;">Calculation</small>
                        <div class="d-flex align-items-center mt-1">
                            <i class="fas fa-calculator text-primary me-2"></i>
                            <span class="fw-bold text-dark font-monospace">{{ $data['rumus'] }}</span>
                        </div>
                    </div>

                    <div class="alert {{ $data['total_jam_raw'] >= 12 ? 'alert-success' : 'alert-warning' }} border-0 mb-0 d-flex align-items-start" role="alert">
                        <i class="fas {{ $data['total_jam_raw'] >= 12 ? 'fa-check' : 'fa-exclamation-circle' }} mt-1 me-2"></i>
                        <div>
                            <strong>Status:</strong> {{ $data['catatan'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-12 mt-2 fade-in-up delay-2">
        <h5 class="fw-bold text-dark mb-3">Last 4 Weeks History</h5>
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Period</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Hours</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end pe-4">Final Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $log)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center text-secondary">
                                        <i class="fas fa-calendar-week" style="font-size: 12px;"></i>
                                    </div>
                                    <span class="text-dark text-sm fw-bold">{{ $log['period'] }}</span>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $log['hours'] }}</p>
                            </td>
                            <td>
                                <span class="badge badge-sm bg-gradient-{{ $log['class'] }} text-white px-2 py-1" style="border-radius: 6px;">
                                    {{ $log['status'] }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <span class="text-secondary text-xs font-weight-bold">$</span>
                                <span class="text-dark text-sm fw-bold">{{ number_format($log['salary'], 0) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted small">
                                No history data available yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection