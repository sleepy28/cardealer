@extends('layouts.admin')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">


<style>
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
   
    .animate-enter {
        opacity: 0;
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
        transition: transform 0.2s, box-shadow 0.2s;
    }
   
    .card-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    
    .card-gradient {
        background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
   
    .card-gradient::before {
        content: '';
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIvPjwvc3ZnPg==');
        opacity: 0.3;
    }

    
    .table-modern thead th {
        background-color: #f9fafb;
        color: #6b7280;
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

    
    .avatar-hover {
        transition: transform 0.2s;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .table-modern tbody tr:hover .avatar-hover {
        transform: scale(1.15);
    }

    
    .badge-modern {
        padding: 0.5em 0.8em;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-soft-purple {
        background-color: #f3e8ff;
        color: #9333ea;
        border: 1px solid #e9d5ff;
    }

    
    .btn-action-check {
        transition: all 0.3s ease;
    }
    .btn-action-check:hover {
        transform: scale(1.05);
        background-color: #e9ecef;
    }
</style>

<div class="container-fluid py-4">
   
    
    <div class="d-flex justify-content-between align-items-center mb-4 animate-enter" style="animation-delay: 0.1s">
        <div>
            <h3 class="fw-bold text-dark m-0" style="letter-spacing: -0.5px;">💰 Payroll & Komisi</h3>
            <p class="text-secondary small m-0">Laporan Keuangan Gaji & Komisi Sales</p>
        </div>
        <button class="btn btn-white border shadow-sm btn-sm px-3 rounded-pill" onclick="window.print()">
            <i class="fa-solid fa-print me-2 text-primary"></i> Cetak PDF
        </button>
    </div>

    
    <div class="card card-modern mb-4 animate-enter" style="animation-delay: 0.2s">
        <div class="card-body p-4">
            <form action="{{ route('admin.salary.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.7rem;">Dari Tanggal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-calendar text-muted"></i></span>
                            <input type="date" name="start_date" id="start_date_val" class="form-control border-start-0 ps-0 bg-light" value="{{ $startDate->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.7rem;">Sampai Tanggal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-calendar text-muted"></i></span>
                            <input type="date" name="end_date" id="end_date_val" class="form-control border-start-0 ps-0 bg-light" value="{{ $endDate->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 fw-bold rounded-3 shadow-sm">
                                <i class="fa-solid fa-filter me-2"></i> Tampilkan
                            </button>
                            <a href="{{ route('admin.salary.index') }}" class="btn btn-light text-muted border px-3 rounded-3">
                                <i class="fa-solid fa-rotate-left me-2"></i> Reset Minggu Ini
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="row mb-4 animate-enter" style="animation-delay: 0.3s">
        <div class="col-12">
            <div class="card card-gradient shadow-lg text-white">
                <div class="card-body p-5 text-center position-relative">
                    <i class="fa-solid fa-money-bill-wave position-absolute" style="font-size: 15rem; opacity: 0.05; right: -40px; top: -50px; transform: rotate(-15deg);"></i>
                   
                    <h6 class="text-uppercase text-white-50 fw-bold letter-spacing-1 mb-3">Total Tagihan Periode Ini</h6>
                   
                    <div class="d-inline-block bg-white bg-opacity-10 rounded-pill px-3 py-1 mb-3 border border-white border-opacity-25">
                        <small class="fw-bold">{{ $startDate->format('d M Y') }} — {{ $endDate->format('d M Y') }}</small>
                    </div>

                    <h1 class="display-3 fw-bold mb-0 text-white" style="text-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                        ${{ number_format($totalPayout, 0, ',', '.') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card card-modern animate-enter" style="animation-delay: 0.4s">
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-2 rounded me-3 text-primary">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h6 class="mb-0 fw-bold text-dark">Rincian Per Karyawan</h6>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 font-weight-bolder">Karyawan</th>
                            <th class="text-center font-weight-bolder">Citizen ID</th>
                            <th class="text-center font-weight-bolder">Total Duty</th>
                            <th class="text-end font-weight-bolder">Final Salary</th>
                            <th class="text-end font-weight-bolder">Total Komisi</th>
                            <th class="text-end font-weight-bolder text-primary">Total Diterima</th>
                            
                            <th class="text-center font-weight-bolder ps-4" style="width: 170px;">Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $emp)
                        <tr class="animate-enter" style="animation-delay: {{ ($loop->index * 100) + 500 }}ms">
                           
                            @php
                                
                                $rawHours = $emp->weekly_duty_hours ?? 0;
                                $displayJam = floor($rawHours);
                                $displayMenit = round(($rawHours - $displayJam) * 60);

                                $role = $emp->role ?? 'showroom_sales';
                                $salarySetting = \App\Models\SalarySetting::where('role', $role)->first();
                                $baseSalary = $salarySetting ? $salarySetting->base_salary : 0;

                                $threshold = 12;
                                $overtimeRate = 500;
                                $normalRate = $threshold > 0 ? ($baseSalary / $threshold) : 0;
                                $penaltyRate = $normalRate / 2;

                                $finalSalary = 0;
                                $jamBulat = floor($rawHours);

                                if ($jamBulat > $threshold) {
                                    $overtimeHours = $jamBulat - $threshold;
                                    $finalSalary = $baseSalary + ($overtimeHours * $overtimeRate);
                                    $statusGaji = 'Target + OT';
                                    $colorGaji = 'text-success';
                                } elseif ($jamBulat == $threshold) {
                                    $finalSalary = $baseSalary;
                                    $statusGaji = 'Target Reached';
                                    $colorGaji = 'text-success';
                                } else {
                                    if ($jamBulat > 0) {
                                        $finalSalary = $penaltyRate * $jamBulat;
                                        $statusGaji = 'Under Target';
                                        $colorGaji = 'text-warning';
                                    } else {
                                        $finalSalary = 0;
                                        $statusGaji = 'No Data';
                                        $colorGaji = 'text-secondary';
                                    }
                                }

                                $totalKomisi = $emp->sales_sum_commission ?? 0;
                                $grandTotal = $finalSalary + $totalKomisi;

                                
                                
                                $paymentData = \App\Models\PayrollPayment::where('user_id', $emp->id)
                                                ->where('start_date', $startDate->format('Y-m-d'))
                                                ->first();
                               
                                $isPaid = $paymentData ? true : false;
                                $payerName = $paymentData ? $paymentData->paid_by_name : '';
                            @endphp

                            
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    @if($emp->avatar)
                                        <img src="{{ asset('storage/' . $emp->avatar) }}" class="rounded-circle me-3 avatar-hover" width="45" height="45" style="object-fit: cover;">
                                    @else
                                        <div class="avatar bg-gradient-secondary rounded-circle text-white d-flex align-items-center justify-content-center me-3 shadow-sm avatar-hover" style="width: 45px; height: 45px; font-weight: bold;">
                                            {{ substr($emp->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0 text-sm fw-bold text-dark">{{ $emp->name }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $emp->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-secondary border fw-normal">{{ $emp->citizen_id ?? '-' }}</span>
                            </td>

                            <td class="text-center">
                                @if($rawHours > 0)
                                    <span class="badge badge-modern badge-soft-purple">
                                        <i class="fa-regular fa-clock me-1"></i> {{ $displayJam }} h {{ $displayMenit }} m
                                    </span>
                                @else
                                    <span class="text-muted text-xs fst-italic">-</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <div class="d-flex flex-column align-items-end">
                                    <h6 class="mb-0 fw-bold">${{ number_format($finalSalary, 0, ',', '.') }}</h6>
                                    @if($finalSalary > 0)
                                        <small class="text-xs {{ $colorGaji }}" style="font-size: 0.65rem;">{{ $statusGaji }}</small>
                                    @endif
                                </div>
                            </td>

                            <td class="text-end">
                                @if($totalKomisi > 0)
                                    <h6 class="mb-0 text-success fw-bold">+ ${{ number_format($totalKomisi, 0, ',', '.') }}</h6>
                                @else
                                    <span class="text-muted text-sm opacity-50">$ 0</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <h6 class="mb-0 text-primary fw-bolder fs-6">${{ number_format($grandTotal, 0, ',', '.') }}</h6>
                            </td>

                            
                            <td class="text-center pe-4 align-middle">
                                <div id="action-container-{{ $emp->id }}" class="d-flex justify-content-center">
                                   
                                    @if($isPaid)
                                        
                                        <div class="d-flex flex-column align-items-center animate-enter">
                                            <span class="badge bg-success bg-gradient px-3 py-2 shadow-sm mb-1">
                                                <i class="fa-solid fa-check-double me-1"></i> LUNAS
                                            </span>
                                            <small class="text-xs text-muted fst-italic">
                                                By: {{ $payerName }}
                                            </small>
                                        </div>
                                    @else
                                        
                                        <button onclick="markAsPaid('{{ $emp->id }}')"
                                                id="btn-pay-{{ $emp->id }}"
                                                class="btn btn-sm btn-outline-secondary border-dashed rounded-pill px-3 py-1 btn-action-check position-relative"
                                                title="Tandai Sudah Dibayar">
                                            <i class="fa-regular fa-circle me-1"></i> Pending
                                        </button>
                                        
                                        
                                        <div id="loading-{{ $emp->id }}" class="d-none">
                                            <i class="fa-solid fa-circle-notch fa-spin text-primary"></i>
                                        </div>
                                    @endif

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    function markAsPaid(employeeId) {
        
        const startDate = document.getElementById('start_date_val').value;
        const endDate = document.getElementById('end_date_val').value;
        const btn = document.getElementById('btn-pay-' + employeeId);
        const loading = document.getElementById('loading-' + employeeId);
        const container = document.getElementById('action-container-' + employeeId);

        
        if(btn) btn.classList.add('d-none');
        if(loading) loading.classList.remove('d-none');

        
        fetch("{{ route('admin.salary.pay') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                employee_id: employeeId,
                start_date: startDate,
                end_date: endDate
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                
                
                const currentAdmin = "{{ Auth::user()->name ?? 'Admin' }}";
               
                const paidHtml = `
                    <div class="d-flex flex-column align-items-center animate-enter">
                        <span class="badge bg-success bg-gradient px-3 py-2 shadow-sm mb-1">
                            <i class="fa-solid fa-check-double me-1"></i> LUNAS
                        </span>
                        <small class="text-xs text-muted fst-italic">
                            By: ${currentAdmin}
                        </small>
                    </div>
                `;
                container.innerHTML = paidHtml;
            } else {
                alert("Gagal menyimpan data.");
                if(btn) btn.classList.remove('d-none');
                if(loading) loading.classList.add('d-none');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Terjadi kesalahan koneksi.");
            if(btn) btn.classList.remove('d-none');
            if(loading) loading.classList.add('d-none');
        });
    }
</script>

@endsection