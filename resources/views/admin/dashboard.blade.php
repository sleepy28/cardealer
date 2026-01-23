@extends('layouts.admin')

@push('styles')
<style>
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-entry {
        opacity: 0; 
        animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    
    .delay-0 { animation-delay: 0ms; }
    .delay-1 { animation-delay: 100ms; }
    .delay-2 { animation-delay: 200ms; }
    .delay-3 { animation-delay: 300ms; }
    .delay-4 { animation-delay: 400ms; }
    .delay-5 { animation-delay: 500ms; }

    
    .table-custom tbody tr {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .table-custom tbody tr:nth-child(1) { animation-delay: 500ms; }
    .table-custom tbody tr:nth-child(2) { animation-delay: 600ms; }
    .table-custom tbody tr:nth-child(3) { animation-delay: 700ms; }
    .table-custom tbody tr:nth-child(4) { animation-delay: 800ms; }
    .table-custom tbody tr:nth-child(5) { animation-delay: 900ms; }
    
    
    .salary-list-item {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .salary-list-item:nth-child(1) { animation-delay: 600ms; }
    .salary-list-item:nth-child(2) { animation-delay: 700ms; }
    .salary-list-item:nth-child(3) { animation-delay: 800ms; }
    .salary-list-item:nth-child(4) { animation-delay: 900ms; }
    .salary-list-item:nth-child(5) { animation-delay: 1000ms; }


    
    
    .stat-card { 
        background: white; 
        border-radius: 16px; 
        padding: 24px; 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); 
        height: 100%; 
        border: 1px solid rgba(226, 232, 240, 0.8); 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        position: relative;
        overflow: hidden;
    }
    
    
    .stat-card:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); 
        border-color: #cbd5e1;
    }

    .stat-label { 
        font-size: 0.75rem; 
        color: #94a3b8; 
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 0.05em;
        margin-bottom: 8px; 
    }
    
    .stat-value { 
        font-size: 1.75rem; 
        font-weight: 800; 
        color: #1e293b; 
        margin-bottom: 0; 
        line-height: 1.2;
    }
    
    .icon-box { 
        width: 48px; 
        height: 48px; 
        border-radius: 12px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 1.25rem; 
        margin-bottom: 16px; 
        transition: transform 0.3s ease;
    }
    .stat-card:hover .icon-box {
        transform: scale(1.1) rotate(5deg);
    }

    
    .table-custom th { 
        font-size: 0.75rem; 
        text-transform: uppercase; 
        letter-spacing: 0.05em; 
        color: #64748b; 
        font-weight: 700; 
        background-color: #f8fafc; 
        border-bottom: 2px solid #e2e8f0; 
        padding: 16px; 
    }
    .table-custom td { 
        font-size: 0.9rem; 
        vertical-align: middle; 
        padding: 16px; 
        border-bottom: 1px solid #f1f5f9; 
        color: #334155;
    }
    .table-custom tr:last-child td { border-bottom: none; }
    
    
    .table-custom tr:hover td {
        background-color: #f8fafc;
        cursor: default;
    }
</style>
@endpush



@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        
        @if(session('access_denied'))
            Swal.fire({
                title: 'Akses Dibatasi!',
                text: "{{ session('access_denied') }}", 
                imageUrl: 'https:
                imageWidth: 100,
                imageHeight: 100,
                imageAlt: 'Restricted Access',
                background: '#fff',
                confirmButtonText: 'Siap, Mengerti',
                confirmButtonColor: '#1e293b', 
                showClass: {
                    popup: 'animate__animated animate__fadeInDown' 
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        @endif

    });
</script>
@endpush

@section('content')
    <h2 class="fw-bold mb-4 text-dark animate-entry delay-0" style="letter-spacing: -0.5px;">Dashboard Overview</h2>

    <div class="row g-4">
        
        <div class="col-lg-8">
            
            <div class="row g-3 mb-4">
                <div class="col-md-4 animate-entry delay-1">
                    <div class="stat-card">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary"><i class="fas fa-users"></i></div>
                        <div class="stat-label">Total Employees</div>
                        <div class="stat-value">{{ $totalAnggota }}</div>
                    </div>
                </div>
                
                <div class="col-md-4 animate-entry delay-2">
                    <div class="stat-card">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning"><i class="fas fa-car"></i></div>
                        <div class="stat-label">units sold this week</div>
                        <div class="stat-value">{{ $totalUnitMingguan }}</div>
                    </div>
                </div>
                
                <div class="col-md-4 animate-entry delay-3">
                    <div class="stat-card">
                        <div class="icon-box bg-success bg-opacity-10 text-success"><i class="fas fa-dollar-sign"></i></div>
                        <div class="stat-label">Total Income</div>
                        <div class="stat-value">${{ number_format($totalInvoice) }}</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 animate-entry delay-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold m-0 text-secondary"><i class="fas fa-history me-2"></i>Recent Sales Activity</h6>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Live Data</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">DATE</th>
                                    <th>salesman</th>
                                    <th>Vehicle</th>
                                    <th>Invoice</th>
                                    <th class="pe-4 text-end">Commission</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSales as $sale)
                                <tr>
                                    <td class="ps-4 text-muted small">
                                        <div class="fw-bold text-dark">{{ $sale->created_at->format('d M') }}</div>
                                        <div style="font-size: 0.7rem">{{ $sale->created_at->format('H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle text-center me-2" style="width:32px; height:32px; line-height:32px;">
                                                <i class="fas fa-user text-secondary" style="font-size: 0.8rem"></i>
                                            </div>
                                            <span class="fw-bold text-dark small">{{ $sale->user->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-semibold small">{{ $sale->vehicle_model }}</span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-secondary small">${{ number_format($sale->sale_price) }}</td>
                                    <td class="pe-4 text-end">
                                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">+ ${{ number_format($sale->commission) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada penjualan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">
            
            <div class="card border-0 shadow-sm rounded-3 h-100 animate-entry delay-5">
                <div class="p-4 bg-danger bg-opacity-10 rounded-top text-center border-bottom border-danger border-opacity-25">
                    <p class="text-danger small fw-bold text-uppercase mb-1" style="letter-spacing: 1px;">Total Salary Bill</p>
                    <h2 class="text-danger fw-bold mb-0 display-6">${{ number_format($totalGaji) }}</h2>
                    <small class="text-danger opacity-75">Total commission to be paid</small>
                </div>

                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold m-0 text-secondary small text-uppercase">Top Performers</h6>
                </div>

                <div class="card-body p-3 overflow-auto custom-scrollbar" style="max-height: 600px;">
                    @foreach($topEmployees as $emp)
                    <div class="salary-list-item d-flex align-items-center justify-content-between p-3 mb-2 rounded bg-white border shadow-sm transition-hover" style="transition: transform 0.2s;">
                        <div class="d-flex align-items-center">
                            <div class="bg-light border text-secondary rounded-circle p-2 me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <span class="fw-bold">{{ substr($emp->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark small">{{ $emp->name }}</h6>
                                <small class="text-muted" style="font-size: 0.75rem"><i class="fas fa-check-circle text-success me-1"></i>{{ $emp->sales_count }} Unit Terjual</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="d-block text-muted" style="font-size: 0.65rem">bill:</small>
                            <span class="fw-bold text-danger">${{ number_format($emp->sales_sum_commission ?? 0) }}</span>
                        </div>
                    </div>
                    @endforeach

                    @if($topEmployees->isEmpty())
                        <div class="text-center text-muted py-4">Belum ada data karyawan.</div>
                    @endif
                </div>
                
                <div class="card-footer bg-white border-0 text-center pb-4 pt-0">
                    <hr class="text-muted opacity-25">
                    <button class="btn btn-dark w-100 btn-sm shadow-sm py-2"><i class="fas fa-print me-2"></i>Cetak Laporan Gaji</button>
                </div>
            </div>
        </div>

    </div>
@endsection