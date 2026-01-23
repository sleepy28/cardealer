@extends('layouts.admin')

@section('content')

<style>
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-enter {
        opacity: 0;
        animation: fadeInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
        overflow: hidden;
    }

    
    .table-modern thead th {
        background-color: #f9fafb;
        color: #6b7280;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-modern tbody td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
        transition: background-color 0.2s;
    }

    .table-modern tbody tr:hover td {
        background-color: #f8fafc;
    }

    
    .avatar-wrapper img, .avatar-wrapper .avatar {
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .table-modern tbody tr:hover .avatar-wrapper img {
        transform: scale(1.1);
    }

    
    .badge-soft {
        padding: 0.5em 0.8em;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-soft-success { background-color: #d1fae5; color: #065f46; }
    .badge-soft-danger { background-color: #fee2e2; color: #991b1b; }
    .badge-soft-warning { background-color: #fef3c7; color: #92400e; }

    
    .btn-action {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-enter" style="animation-delay: 0.1s">
        <div>
            <h3 class="fw-bold text-dark m-0" style="letter-spacing: -0.5px;">📋 Permit Approval</h3>
            <p class="text-secondary small m-0">Manage and review employee permit requests.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 animate-enter" style="animation-delay: 0.2s; border-radius: 12px;">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-check-circle me-2 fs-5"></i> 
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    <div class="card card-modern animate-enter" style="animation-delay: 0.3s">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 font-weight-bolder">Name</th>
                            <th class="font-weight-bolder">Duration</th>
                            <th class="font-weight-bolder">Reason</th>
                            <th class="text-center font-weight-bolder">Status / Approver</th>
                            <th class="text-center font-weight-bolder">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permits as $permit)
                        
                        <tr class="animate-enter" style="animation-delay: {{ ($loop->index * 100) + 400 }}ms">
                            
                            <td class="ps-4">
                                <div class="d-flex align-items-center avatar-wrapper">
                                    
                                    @if($permit->user->avatar)
                                        <img src="{{ asset('storage/' . $permit->user->avatar) }}" class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover;" alt="Avatar">
                                    @else
                                        <div class="avatar bg-gradient-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 45px; height: 45px; font-weight: bold;">
                                            {{ substr($permit->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <h6 class="mb-0 text-sm fw-bold text-dark">{{ $permit->user->name }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $permit->user->email ?? 'Staff' }}</p>
                                    </div>
                                </div>
                            </td>

                            
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-dark text-sm fw-bold">
                                        <i class="fa-regular fa-calendar me-1 text-secondary"></i>
                                        {{ $permit->start_date->format('d M') }} - {{ $permit->end_date->format('d M Y') }}
                                    </span>
                                    <span class="badge bg-light text-secondary border mt-1" style="width: fit-content; font-weight: normal;">
                                        <i class="fa-regular fa-clock me-1"></i>
                                        {{ $permit->start_date->diffInDays($permit->end_date) + 1 }} day(s)
                                    </span>
                                </div>
                            </td>

                            
                            <td style="max-width: 250px;">
                                <div class="p-2 bg-light rounded-3 border border-light">
                                    <p class="text-sm text-secondary mb-0 text-wrap fst-italic">"{{ $permit->reason }}"</p>
                                </div>
                            </td>

                            
                            <td class="text-center">
                                @if($permit->status == 'approved')
                                    <span class="badge badge-soft badge-soft-success mb-1">
                                        <i class="fa-solid fa-check me-1"></i> Approved
                                    </span>
                                    <div class="text-xs text-secondary mt-1">
                                        by <span class="fw-bold text-dark">{{ $permit->approver->name ?? 'Admin' }}</span>
                                    </div>
                                @elseif($permit->status == 'rejected')
                                    <span class="badge badge-soft badge-soft-danger mb-1">
                                        <i class="fa-solid fa-xmark me-1"></i> Declined
                                    </span>
                                    <div class="text-xs text-secondary mt-1">
                                        by <span class="fw-bold text-dark">{{ $permit->approver->name ?? 'Admin' }}</span>
                                    </div>
                                @else
                                    <span class="badge badge-soft badge-soft-warning">
                                        <i class="fa-solid fa-hourglass-half me-1"></i> Pending Review
                                    </span>
                                @endif
                            </td>

                            
                            <td class="text-center">
                                @if($permit->status == 'pending')
                                    <div class="d-flex justify-content-center gap-2">
                                        
                                        <form action="{{ route('admin.permits.approve', $permit->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-action" title="Approve Request">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>

                                        
                                        <form action="{{ route('admin.permits.reject', $permit->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-danger btn-action bg-white" title="Reject Request">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-muted">
                                        <i class="fa-solid fa-lock me-1"></i> Locked
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="animate-enter" style="animation-delay: 0.4s">
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="fa-regular fa-folder-open fa-2x text-secondary"></i>
                                    </div>
                                    <p class="mb-0 fw-bold text-dark">No Permit Requests</p>
                                    <p class="text-xs text-secondary">Saat ini belum ada pengajuan izin baru.</p>
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
@endsection