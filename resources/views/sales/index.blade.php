@extends('layouts.app') 

@section('content')
 
<style>
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .animate-left { animation: slideInLeft 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }

    
    .card-modern {
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    
    .card-icon-bg {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 8rem;
        opacity: 0.1;
        transform: rotate(-15deg);
        z-index: 0;
        transition: transform 0.3s ease;
    }
    .card-modern:hover .card-icon-bg {
        transform: rotate(0deg) scale(1.1);
    }

    
    .input-modern {
        background-color: #f8f9fa;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    .input-modern:focus {
        background-color: #fff;
        border-color: #3b82f6; 
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    
    .table-row-modern {
        transition: background-color 0.2s ease;
    }
    .table-row-modern:hover {
        background-color: #f1f5f9 !important; 
    }
</style>

<div class="container-fluid py-4">
    
    
    <div class="d-flex justify-content-between align-items-center mb-4 animate-left">
        <div>
            <h2 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <i class="fas fa-car-side text-primary"></i> Car Dealer Sales
            </h2>
            <span class="text-muted small ms-1 ">{{ $label }}</span>
        </div>

        <form action="{{ route('sales.index') }}" method="GET">
            <div class="input-group shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                <span class="input-group-text bg-white border-0 text-primary"><i class="fas fa-filter"></i></span>
                <select name="filter_week" class="form-select border-0 fw-bold text-secondary" style="cursor: pointer; max-width: 250px; outline: none;" onchange="this.form.submit()">
                    <option value="">-- This Week --</option>
                    @foreach($historyWeeks as $weekKey => $group)
                        @php
                            $firstDate = $group->first()->created_at;
                            $startStr = $firstDate->copy()->startOfWeek()->format('d M');
                            $endStr = $firstDate->copy()->endOfWeek()->format('d M Y');
                        @endphp
                        <option value="{{ $weekKey }}" {{ request('filter_week') == $weekKey ? 'selected' : '' }}>
                            Week To-{{ $firstDate->format('W') }} ({{ $startStr }} - {{ $endStr }})
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    
    <div class="row g-3 mb-4">
        
        <div class="col-md-4 animate-up delay-1">
            <div class="card card-modern shadow h-100 text-white" style="border-radius: 20px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                <i class="fas fa-car card-icon-bg"></i> 
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 text-white-50 fw-bold text-uppercase ls-1" style="font-size: 0.75rem; letter-spacing: 1px;">Total Unit (Weekly)</p>
                            <h2 class="fw-bold mb-0 display-5">{{ $totalSales }} <span class="fs-6 fw-normal opacity-75">Unit</span></h2>
                        </div>
                        <div class="p-3 bg-primary bg-opacity-20 rounded-4 backdrop-blur">
                            <i class="fas fa-key fa-lg"></i> 
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top border-white border-opacity-10 d-flex align-items-center small">
                        <i class="fas fa-calendar-day me-2 opacity-75"></i> 
                        <span class="opacity-75">{{ $startDate->format('d M') }} - {{ $startDate->copy()->endOfWeek()->format('d M') }}</span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-4 animate-up delay-2">
            <div class="card card-modern shadow h-100 text-white" style="border-radius: 20px; background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);">
                <i class="fas fa-cash-register card-icon-bg"></i>
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 text-white-50 fw-bold text-uppercase ls-1" style="font-size: 0.75rem; letter-spacing: 1px;">Total Invoice Today</p>
                            <h2 class="fw-bold mb-0 display-5">${{ number_format($dailyTotal, 0, ',', '.') }}</h2>
                        </div>
                        <div class="p-3 bg-primary bg-opacity-20 rounded-4 backdrop-blur">
                            <i class="fas fa-wallet fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top border-white border-opacity-10 d-flex align-items-center small">
                        <i class="fas fa-clock me-2 opacity-75"></i> 
                        <span class="opacity-75">Reset Every 24 Hours</span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-4 animate-up delay-3">
            <div class="card card-modern shadow h-100 text-white" style="border-radius: 20px; background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                <i class="fas fa-chart-line card-icon-bg"></i>
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 text-white-50 fw-bold text-uppercase ls-1" style="font-size: 0.75rem; letter-spacing: 1px;">Estimated Commission</p>
                            <h2 class="fw-bold mb-0 display-5">${{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                        </div>
                        <div class="p-3 bg-primary bg-opacity-20 rounded-4 backdrop-blur">
                            <i class="fas fa-percentage fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top border-white border-opacity-10 d-flex align-items-center small">
                        <i class="fas fa-check-circle me-2 opacity-75"></i> 
                        <span class="opacity-75">Weekly Performance</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row g-4">
        
        
        <div class="col-lg-4 animate-up delay-2">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold text-dark d-flex align-items-center">
                        <span class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 35px; height: 35px;">
                            <i class="fas fa-plus fa-sm"></i>
                        </span>
                        Input New Sales
                    </h5>
                    <p class="text-muted small ms-5 mb-0">Enter transaction details below.</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('sales.store') }}" method="POST"> @csrf
                        
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold text-uppercase">Categories</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-tags text-muted"></i></span>
                                <select name="category" class="form-select form-select-lg input-modern bg-light fs-6" required>
                                    <option value="" disabled selected>Select Category...</option>
                                    <option value="Luxury">✨ Luxury</option>
                                    <option value="HighClass">🔥 High Class</option>
                                    <option value="PDM">🚗 PDM (Standard)</option>
                                    <option value="BMX">🚲 BMX/SKATE</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold text-uppercase">Vehicle Model</label>
                            <input type="text" name="vehicle_model" class="form-control input-modern py-2" placeholder="e.g. BMW M3 GTR" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold text-uppercase">Customer Name</label>
                            <input type="text" name="buyer_name" class="form-control input-modern py-2" placeholder="Full Name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold text-uppercase">Invoice Amount</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 fw-bold text-success">$</span>
                                <input type="number" name="price" class="form-control input-modern py-2 fw-bold text-dark" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-bold text-uppercase">Note (Optional)</label>
                            <textarea name="notes" class="form-control input-modern" rows="2" placeholder="Additional details..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm" style="border-radius: 12px; transition: transform 0.2s;">
                            <i class="fas fa-save me-2"></i> Submit Sales
                        </button>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-lg-8 animate-up delay-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="border-radius: 20px;">
                <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0">Sales History</h5>
                        <small class="text-muted">Transaction log for the selected period.</small>
                    </div>
                    <span class="badge text-dark border px-3 py-2 rounded-pill shadow-sm">{{ $label }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" style="border-collapse: collapse;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-secondary text-xxs font-weight-bolder text-uppercase opacity-7">Date</th>
                                    <th class="py-3 text-secondary text-xxs font-weight-bolder text-uppercase opacity-7">Vehicle</th>
                                    <th class="py-3 text-secondary text-xxs font-weight-bolder text-uppercase opacity-7">Category</th>
                                    <th class="py-3 text-secondary text-xxs font-weight-bolder text-uppercase opacity-7">Customer</th>
                                    <th class="py-3 text-secondary text-xxs font-weight-bolder text-uppercase opacity-7 text-end">Price</th>
                                    <th class="pe-4 py-3 text-secondary text-xxs font-weight-bolder text-uppercase opacity-7 text-end">Comm.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                <tr class="table-row-modern border-bottom border-light">
                                    <td class="ps-4">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark small">{{ $sale->created_at->format('d M Y') }}</span>
                                            <span class="text-muted text-xs">{{ $sale->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $sale->vehicle_model }}</span>
                                    </td>
                                    <td>
                                        @if($sale->category == 'Luxury')
                                            <span class="badge rounded-pill bg-warning text-dark shadow-sm border border-warning border-opacity-25 px-3">
                                                <i class="fas fa-crown me-1 text-dark opacity-50"></i> Luxury
                                            </span>
                                        @elseif($sale->category == 'HighClass')
                                            <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10 px-3">
                                                🔥 High Class
                                            </span>
                                        @elseif($sale->category == 'BMX')
                                            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-dark border border-secondary border-opacity-10 px-3">
                                                🚲 BMX
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-info bg-opacity-10 text-info border border-info border-opacity-10 px-3">
                                                🚗 PDM
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm rounded-circle bg-gradient-primary me-2 d-flex justify-content-center align-items-center text-white fw-bold shadow-sm" style="width:32px; height:32px; background: #3b82f6;">
                                                {{ substr($sale->buyer_name, 0, 1) }}
                                            </div>
                                            <span class="fw-bold text-dark text-sm">{{ $sale->buyer_name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-secondary small fw-bold">${{ number_format($sale->sale_price) }}</span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <span class="text-success fw-bold bg-success bg-opacity-10 px-2 py-1 rounded">
                                            +${{ number_format($sale->commission) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center opacity-50">
                                            <div class="bg-light rounded-circle p-4 mb-3">
                                                <i class="fas fa-folder-open fa-2x text-muted"></i>
                                            </div>
                                            <h6 class="text-muted">No sales found for this period.</h6>
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