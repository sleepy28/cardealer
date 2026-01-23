@extends('layouts.app')

@section('content')

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        --glass-bg: rgba(255, 255, 255, 0.95);
        --shadow-soft: 0 10px 30px -5px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 20px 40px -5px rgba(0, 0, 0, 0.12);
    }

    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-enter {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }

    
    .card-modern {
        border: none;
        border-radius: 16px;
        background: var(--glass-bg);
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .card-modern:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }
    
    
    .header-modern {
        background: #ffffff00;
        border-bottom: 1px solid #f1f5f9;
        padding: 1.5rem;
    }

    
    .form-control-modern {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 15px;
        transition: all 0.2s;
        background-color: #f8fafc;
    }
    .form-control-modern:focus {
        border-color: #4f46e5;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    
    .btn-gradient {
        background: var(--primary-gradient);
        border: none;
        border-radius: 10px;
        color: white;
        padding: 12px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        color: white;
    }
    .btn-gradient:active {
        transform: scale(0.98);
    }

    
    .table-modern thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-modern tbody td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .table-row-hover {
        transition: background-color 0.2s;
    }
    .table-row-hover:hover {
        background-color: #f8fafc;
    }

    
    .badge-soft-success { background-color: #dcfce7; color: #166534; }
    .badge-soft-danger { background-color: #fee2e2; color: #991b1b; }
    .badge-soft-warning { background-color: #fef3c7; color: #92400e; }
    .badge-pill { padding: 0.5em 1em; border-radius: 50rem; font-weight: 600; }
</style>

<div class="container-fluid py-5" style=" min-height: 100vh;">
    
    
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center animate-enter mb-4" style="border-radius: 12px; background: #dcfce7; color: #166534;">
            <i class="fa-solid fa-circle-check me-2 fs-5"></i> 
            <span class="fw-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="row g-4">
        
        
        <div class="col-lg-4 animate-enter delay-1">
            <div class="card card-modern h-100">
                <div class="header-modern">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 text-primary">
                            <i class="fa-solid fa-paper-plane"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">New Work Permit</h6>
                            <small class="text-muted">Fill details to request leave</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('permit.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-1">From Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-regular fa-calendar text-muted"></i></span>
                                <input type="date" name="start_date" class="form-control form-control-modern border-start-0 ps-0" required value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-1">Until Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-regular fa-calendar-check text-muted"></i></span>
                                <input type="date" name="end_date" class="form-control form-control-modern border-start-0 ps-0" required value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-1">Reason</label>
                            <textarea name="reason" class="form-control form-control-modern" rows="4" placeholder=" Umroh..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-gradient w-100 fw-bold d-flex align-items-center justify-content-center gap-2">
                            <span>Send Application</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-lg-8 animate-enter delay-2">
            <div class="card card-modern h-100">
                <div class="header-modern bg-transparent d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-2 rounded-circle me-3 text-warning">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Employee Schedule</h6>
                            <small class="text-muted">Overview of active permits</small>
                        </div>
                    </div>
                    <span class="badge bg-transparent text-secondary border px-3 py-2 rounded-pill shadow-sm">
                        <i class="fa-solid fa-circle-dot text-success me-1" style="font-size: 8px;"></i> Active & Upcoming
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4 text-uppercase">Employee</th>
                                    <th class="text-uppercase">Duration</th>
                                    <th class="text-uppercase">Reason</th>
                                    <th class="text-center text-uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permits as $permit)
                                <tr class="table-row-hover">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative">
                                                @if($permit->user->avatar)
                                                    <img src="{{ asset('storage/' . $permit->user->avatar) }}" class="rounded-circle border shadow-sm" width="45" height="45" style="object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px; background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                                                        <span class="fw-bold">{{ substr($permit->user->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 12px; height: 12px;"></span>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-bold text-dark text-sm">{{ $permit->user->name }}</h6>
                                                <span class="text-xs text-muted">Employee ID: #{{ $permit->user->id ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark text-sm">{{ $permit->start_date->format('d M') }} - {{ $permit->end_date->format('d M Y') }}</span>
                                            <small class="text-xs text-secondary">
                                                <i class="fa-regular fa-clock me-1"></i> 
                                                {{ $permit->start_date->diffInDays($permit->end_date) + 1 }} Days
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center" data-bs-toggle="tooltip" title="{{ $permit->reason }}">
                                            <i class="fa-solid fa-quote-left text-muted me-2 opacity-25"></i>
                                            <p class="text-sm text-secondary mb-0 text-truncate" style="max-width: 200px; font-style: italic;">
                                                {{ $permit->reason }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($permit->status == 'approved')
                                            <span class="badge badge-pill badge-soft-success">
                                                <i class="fa-solid fa-check me-1"></i> Approved
                                            </span>
                                        @elseif($permit->status == 'rejected')
                                            <span class="badge badge-pill badge-soft-danger">
                                                <i class="fa-solid fa-xmark me-1"></i> Declined
                                            </span>
                                        @else
                                            <span class="badge badge-pill badge-soft-warning">
                                                <i class="fa-solid fa-hourglass-half me-1"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center opacity-50">
                                            <div class="bg-light rounded-circle p-4 mb-3">
                                                <i class="fa-solid fa-clipboard-check fa-3x text-secondary"></i>
                                            </div>
                                            <h6 class="text-dark fw-bold">No Active Permits</h6>
                                            <p class="text-sm text-muted">All employees are present today.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection