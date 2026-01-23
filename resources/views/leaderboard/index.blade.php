@extends(Auth::user()->role == 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<style>
    
    .bg-gradient-primary-soft { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .bg-gradient-success-soft { background: linear-gradient(135deg, #2af598 0%, #009efd 100%); color: white; }
    .bg-gradient-warning-soft { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); color: white; }
    
    .card-stat {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card-stat .icon-bg {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 8rem;
        opacity: 0.15;
        transform: rotate(-15deg);
    }
    
    .avatar-circle {
        width: 45px;
        height: 45px;
        background-color: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #495057;
        font-size: 1.2rem;
        border: 2px solid white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .avatar-img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .table-modern thead th {
        border-top: none;
        border-bottom: 2px solid #eef2f7;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #8898aa;
        padding: 15px;
    }
    .table-modern tbody td {
        vertical-align: middle;
        padding: 15px;
        border-top: 1px solid #f5f7fa;
    }
    .table-modern tbody tr:hover {
        background-color: #f8f9fe;
    }
    
    .rank-badge {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: bold;
        font-size: 0.9rem;
    }
    .rank-1 { background-color: #ffd700; color: #fff; box-shadow: 0 2px 5px rgba(255, 215, 0, 0.4); } 
    .rank-2 { background-color: #c0c0c0; color: #fff; box-shadow: 0 2px 5px rgba(192, 192, 192, 0.4); } 
    .rank-3 { background-color: #cd7f32; color: #fff; box-shadow: 0 2px 5px rgba(205, 127, 50, 0.4); } 
    .rank-other { color: #8898aa; font-size: 0.9rem; }

    .badge-pill-soft {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .badge-duty { background-color: #eef2ff; color: #5e72e4; }
    .badge-sales { background-color: #e6fffa; color: #2dce89; }

    
    
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    
    .animate-entry {
        opacity: 0; 
        animation: fadeInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-table-container { animation-delay: 0.4s; }

    
    .table-modern tbody tr {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .table-modern tbody tr:nth-child(1) { animation-delay: 0.5s; }
    .table-modern tbody tr:nth-child(2) { animation-delay: 0.6s; }
    .table-modern tbody tr:nth-child(3) { animation-delay: 0.7s; }
    .table-modern tbody tr:nth-child(4) { animation-delay: 0.8s; }
    .table-modern tbody tr:nth-child(5) { animation-delay: 0.9s; }
    .table-modern tbody tr:nth-child(6) { animation-delay: 1.0s; }
    .table-modern tbody tr:nth-child(7) { animation-delay: 1.1s; }
    .table-modern tbody tr:nth-child(8) { animation-delay: 1.2s; }
    .table-modern tbody tr:nth-child(9) { animation-delay: 1.3s; }
    .table-modern tbody tr:nth-child(10) { animation-delay: 1.4s; }
    
    .table-modern tbody tr:nth-child(n+11) { animation-delay: 1.5s; }

</style>

<div class="container-fluid py-4">
    
    
    <div class="d-flex justify-content-between align-items-center mb-4 animate-entry">
        <div>
            <h3 class="mb-1 text-dark fw-bold">🏆 Leaderboard</h3>
            <p class="text-muted text-sm mb-0">Real-time Update</p>
        </div>
        <div class="text-end">
            <span class="badge bg-transparent text-dark border shadow-sm">
                <i class="fa-regular fa-clock me-1"></i> Week {{ now()->weekOfYear }} / {{ now()->year }}
            </span>
        </div>
    </div>

    <div class="row mb-4 g-3">
      
        
        @php $topDuty = $employees->sortByDesc('weekly_duty_hours')->first(); @endphp
        <div class="col-md-4 animate-entry delay-1">
            <div class="card card-stat bg-gradient-primary-soft h-100 shadow">
                <div class="card-body position-relative">
                    <i class="fa-solid fa-hourglass-half icon-bg"></i>
                    <h6 class="text-uppercase mb-3 opacity-75 fw-bold" style="letter-spacing: 1px;">⏳ SI RAJIN</h6>
                    @if($topDuty && $topDuty->weekly_duty_hours > 0)
                        <div class="d-flex align-items-center">
                            @if($topDuty->avatar)
                                <img src="{{ asset('storage/' . $topDuty->avatar) }}" class="avatar-img me-3" style="width: 50px; height: 50px;" alt="Avatar">
                            @else
                                <div class="avatar-circle bg-white text-primary me-3" style="width: 50px; height: 50px;">
                                    {{ substr($topDuty->name, 0, 1) }}
                                </div>
                            @endif
                            
                            <div>
                                <h3 class="mb-0 fw-bold text-white">{{ $topDuty->name }}</h3>
                                
                                @php
                                    $jam = floor($topDuty->weekly_duty_hours);
                                    $menit = round(($topDuty->weekly_duty_hours - $jam) * 60);
                                @endphp
                                <p class="mb-0 text-white opacity-80">
                                    {{ $jam }} Jam {{ $menit }} Menit
                                </p>
                            </div>
                        </div>
                    @else
                        <h4 class="fst-italic opacity-50">- Belum ada data -</h4>
                    @endif
                </div>
            </div>
        </div>

        
        @php $topSales = $employees->sortByDesc('weekly_sales')->first(); @endphp
        <div class="col-md-4 animate-entry delay-2">
            <div class="card card-stat bg-gradient-success-soft h-100 shadow">
                <div class="card-body position-relative">
                    <i class="fa-solid fa-money-bill-trend-up icon-bg"></i>
                    <h6 class="text-uppercase mb-3 opacity-75 fw-bold" style="letter-spacing: 1px;">💰 SI CINA</h6>
                    @if($topSales && $topSales->weekly_sales > 0)
                        <div class="d-flex align-items-center">
                            @if($topSales->avatar)
                                <img src="{{ asset('storage/' . $topSales->avatar) }}" class="avatar-img me-3" style="width: 50px; height: 50px;" alt="Avatar">
                            @else
                                <div class="avatar-circle bg-white text-success me-3" style="width: 50px; height: 50px;">
                                    {{ substr($topSales->name, 0, 1) }}
                                </div>
                            @endif

                            <div>
                                <h3 class="mb-0 fw-bold text-white">{{ $topSales->name }}</h3>
                                <p class="mb-0 text-white opacity-80">{{ $topSales->weekly_sales }} Mobil Terjual</p>
                            </div>
                        </div>
                    @else
                        <h4 class="fst-italic opacity-50">- Belum ada data -</h4>
                    @endif
                </div>
            </div>
        </div>

        
        <div class="col-md-4 animate-entry delay-3">
            <div class="card card-stat bg-gradient-warning-soft h-100 shadow">
                <div class="card-body position-relative">
                    <i class="fa-solid fa-rocket icon-bg"></i>
                    <h6 class="text-uppercase mb-3 opacity-75 fw-bold" style="letter-spacing: 1px;">🚀 Total Team Impact</h6>
                    <div class="d-flex justify-content-between align-items-end mt-2">
                        <div>
                            <span class="d-block text-white opacity-80 text-sm">Total Sales (Weekly)</span>
                            <h2 class="fw-bold text-white mb-0">{{ $employees->sum('weekly_sales') }} <span class="fs-6">Unit</span></h2>
                        </div>
                        <div class="text-end">
                            <span class="d-block text-white opacity-80 text-sm">Total Hours (Weekly)</span>
                            
                            @php
                                $totalRaw = $employees->sum('weekly_duty_hours');
                                $totalJam = floor($totalRaw);
                                $totalMenit = round(($totalRaw - $totalJam) * 60);
                            @endphp
                            <h3 class="fw-bold text-white mb-0">{{ $totalJam }}j {{ $totalMenit }}m</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card border-0 shadow-sm rounded-3 animate-entry delay-table-container">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="font-weight-bold mb-0 text-dark">📊 Employee Rankings</h5>
        </div>
        <div class="card-body px-0 pt-0">
            <div class="table-responsive p-0">
                <table class="table table-modern align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">Rank</th>
                            <th class="ps-4">Employee</th>
                            <th class="text-center">
                                <span class="badge bg-primary text-xxs">WEEKLY</span><br>Duty Time
                            </th>
                            <th class="text-center text-secondary opacity-7">
                                <small>LIFETIME</small><br>Duty Hours
                            </th>
                            <th class="text-center">
                                <span class="badge bg-success text-xxs">WEEKLY</span><br>Sales
                            </th>
                            <th class="text-center text-secondary opacity-7">
                                <small>LIFETIME</small><br>Sales
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $index => $emp)
                        <tr>
                            <td class="text-center">
                                @if($index == 0)
                                    <div class="rank-badge rank-1"><i class="fa-solid fa-trophy"></i></div>
                                @elseif($index == 1)
                                    <div class="rank-badge rank-2">2</div>
                                @elseif($index == 2)
                                    <div class="rank-badge rank-3">3</div>
                                @else
                                    <span class="rank-other fw-bold">#{{ $index + 1 }}</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex px-2 py-1 align-items-center">
                                    @if($emp->avatar)
                                        <img src="{{ asset('storage/' . $emp->avatar) }}" class="avatar-img me-3" alt="Avatar">
                                    @else
                                        <div class="avatar-circle me-3 bg-light text-dark shadow-sm">
                                            {{ substr($emp->name, 0, 1) }}
                                        </div>
                                    @endif
                                    
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm fw-bold text-dark">{{ $emp->name }}</h6>
                                        <p class="text-xs text-muted mb-0">{{ $emp->username }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="badge-pill-soft badge-duty">
                                    @php
                                        $val = $emp->weekly_duty_hours ?? 0;
                                        $j = floor($val);
                                        $m = round(($val - $j) * 60);
                                    @endphp
                                    
                                    @if($j > 0)
                                        {{ $j }} Jam {{ $m }} Menit
                                    @else
                                        {{ $m }} Menit
                                    @endif
                                </span>
                            </td>
                            <td class="text-center text-muted fw-bold text-sm">
                                {{ number_format($emp->lifetime_duty_hours ?? 0, 1) }}
                            </td>

                            <td class="text-center">
                                @if(($emp->weekly_sales ?? 0) > 0)
                                    <span class="badge-pill-soft badge-sales">
                                        {{ $emp->weekly_sales }} Unit 🚗
                                    </span>
                                @else
                                    <span class="text-muted text-xs">-</span>
                                @endif
                            </td>
                            <td class="text-center text-muted fw-bold text-sm">
                                {{ $emp->lifetime_sales ?? 0 }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection