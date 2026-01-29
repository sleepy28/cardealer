@extends('layouts.app')

@section('title', 'Dashboard | Car dealer.')

@section('content')




<style>
    
    .fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    
    .modern-card {
        border: none !important;
        border-radius: 16px !important;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
        transition: all 0.3s ease;
    }
    
    
    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
    }

    
    .status-dot {
        width: 12px; 
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 10px currentColor;
    }

    
    .alert-modern {
        border: none;
        border-radius: 12px;
        position: relative;
        overflow: hidden;
    }
    .alert-modern::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 4px; height: 100%;
        background: currentColor;
        opacity: 0.5;
    }

    
    .table-modern thead th {
        border: none;
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .table-modern tbody td {
        border-bottom: 1px solid #f1f1f1;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    .table-modern tr:hover td {
        background-color: #fafafa;
    }
</style>

<div class="fade-in-up"> 

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold text-dark m-0" style="letter-spacing: -0.5px;">Dashboard</h2>
        <span class="text-muted small"><i class="fa-regular fa-calendar me-1"></i> Today Overview</span>
    </div>

    
    <div class="d-flex align-items-center gap-4 mb-5 bg-white p-4 rounded-4 shadow-sm border-0 modern-card">
        <div class="form-check form-switch m-0">
            <input class="form-check-input shadow-none" type="checkbox" role="switch" id="dutySwitch"
                   style="width: 3.5em; height: 1.75em; cursor: pointer; border-color: #dee2e6;"
                   {{ $data['user']->is_on_duty ? 'checked' : '' }}>
        </div>

        <h4 id="dutyLabel" class="fw-bold m-0 {{ $data['user']->is_on_duty ? 'text-success' : 'text-danger' }}" style="min-width: 120px; letter-spacing: -0.5px;">
            {{ $data['user']->is_on_duty ? 'ON DUTY' : 'OFF DUTY' }}
        </h4>

        
        <div id="dutyStatusBox" class="alert {{ $data['user']->is_on_duty ? 'alert-success' : 'alert-danger' }} alert-modern mb-0 px-4 py-3 fw-bold d-flex align-items-center gap-4 mt-2 gap-md-4 w-100 shadow-sm">
            <i id="statusIcon" class="fa-solid {{ $data['user']->is_on_duty ? 'fa-business-time' : 'fa-ban' }} fa-xl me-2"></i>
            <span id="statusText" class="fs-5">
                {{ $data['user']->is_on_duty ? 'You are on duty, work hard!' : 'You are not on duty, have a good rest.' }}
            </span>
        </div>
    </div>

    
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="p-4 h-100  modern-card position-relative bg-dark-subtle overflow-hidden">
                <div class="d-flex align-items-center mb-3">
                    <span class="status-dot bg-primary me-2 text-primary"></span>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Total Working Days</small>
                </div>
                <h2 class="fw-bold mb-0 text-dark">{{ $data['total_hari'] }}</h2>
                <i class="fa-solid fa-calendar-day position-absolute text-primary opacity-10" style="bottom: -10px; right: 10px; font-size: 5rem;"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-4 h-100 bg-dark-subtle modern-card position-relative overflow-hidden">
                <div class="d-flex align-items-center mb-3">
                    <span class="status-dot bg-success me-2 text-success"></span>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Total Working Hours</small>
                </div>
                <h3 class="fw-bold mb-0 text-dark">
                    @php
                        $rawJam = $data['total_jam'] ?? 0;
                        $jam = floor($rawJam);
                        $menit = round(($rawJam - $jam) * 60);
                    @endphp

                    @if($jam > 0)
                        {{ $jam }} <span class="fs-6 text-muted fw-normal">h</span> {{ $menit }} <span class="fs-6 text-muted fw-normal">m</span>
                    @else
                        {{ $menit }} <span class="fs-6 text-muted fw-normal">Menit</span>
                    @endif
                </h3>
                <i class="fa-solid fa-clock position-absolute text-success opacity-10" style="bottom: -10px; right: 10px; font-size: 5rem;"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-4 bg-dark-subtle h-100 modern-card position-relative overflow-hidden">
                <div class="d-flex align-items-center mb-3">
                    <span class="status-dot bg-warning me-2 text-warning"></span>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">This Week's Sales</small>
                </div>
                <h2 class="fw-bold mb-0 text-dark">{{ $data['total_tiket'] }} <span class="fs-6 text-muted">Unit</span></h2>
                <i class="fa-solid fa-tag position-absolute text-warning opacity-10" style="bottom: -10px; right: 10px; font-size: 5rem;"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="p-4 h-100 bg-dark-subtle modern-card position-relative overflow-hidden">
                <div class="d-flex align-items-center mb-3">
                    <span class="status-dot bg-info me-2 text-info"></span>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Weekly Invoice</small>
                </div>
                <h3 class="fw-bold mb-0 text-dark">${{ number_format($data['total_invoice'], 0, ',', '.') }}</h3>
                <i class="fa-solid fa-file-invoice-dollar position-absolute text-info opacity-10" style="bottom: -10px; right: 10px; font-size: 5rem;"></i>
            </div>
        </div>
    </div>

    
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="p-4 h-100 modern-card ">
                <h6 class="fw-bold mb-4 text-secondary text-uppercase small ls-1">Weekly Working Hours</h6>
                <div style="height: 250px; width: 100%;">
                    <canvas id="chartJamKerja"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-4 h-100 modern-card">
                <h6 class="fw-bold mb-4 text-secondary text-uppercase small ls-1">Weekly Invoice</h6>
                <div style="height: 250px; width: 100%;">
                    <canvas id="chartInvoice"></canvas>
                </div>
            </div>
        </div>
    </div>

    
    <div class="p-0 border-0 shadow-none bg-transparent">
       <div class="bg-white p-4 rounded-4 shadow-sm border-0 modern-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-bold m-0 text-dark">Recent Activity</h6>
            <a href="{{ route('duty.history') }}" class="btn btn-sm btn-light text-primary fw-bold rounded-pill px-3">
                View Last 30 Days <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle table-modern mb-0">
                <thead>
                    <tr>
                        <th class="py-3 ps-3 rounded-start">Date</th>
                        <th class="py-3">SHIFT</th>
                        <th class="py-3">ON DUTY</th>
                        <th class="py-3">OFF DUTY</th>
                        <th class="py-3 rounded-end">DURATION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['recent_sessions'] as $session)
                    <tr>
                        <td class="ps-3 fw-bold text-dark">{{ \Carbon\Carbon::parse($session->start_time)->format('d M Y') }}</td>
                        <td>
                            @php
                                $h = \Carbon\Carbon::parse($session->start_time)->hour;
                                $sh = ($h >= 6 && $h < 18) ? 'Afternoon' : 'Night';
                                // Mengubah style badge menjadi lebih soft
                                $cl = ($sh == 'Afternoon') ? 'warning text-dark bg-opacity-25' : 'dark text-white';
                                // Logic warna background khusus custom
                                $styleBadge = ($sh == 'Afternoon') ? 'background-color: #fff3cd; color: #856404;' : 'background-color: #343a40; color: #fff;';
                            @endphp
                            <span class="badge rounded-pill px-3 py-2 fw-normal" style="{{ $styleBadge }} border: 1px solid rgba(0,0,0,0.05);">
                                {{ $sh }}
                            </span>
                        </td>
                        <td class="text-secondary fw-bold">{{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}</td>
                        <td class="text-secondary fw-bold">{{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '-' }}</td>
                        
                        <td class="fw-bold text-primary">
                            @if($session->duration_hours > 0)
                                @php
                                    $dVal = $session->duration_hours;
                                    $dJam = floor($dVal);
                                    $dMenit = round(($dVal - $dJam) * 60);
                                @endphp
                                @if($dJam > 0)
                                    {{ $dJam }}h {{ $dMenit }}m
                                @else
                                    {{ $dMenit }}m
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa-regular fa-folder-open fa-2x mb-3 d-block opacity-25"></i>
                            Belum ada riwayat duty.
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
         
        const dataJam = @json($data['grafik_jam']);
        const dataInvoice = @json($data['grafik_invoice']);
        const labelsHari = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

      
        Chart.defaults.font.family = "'Segoe UI', 'Helvetica Neue', 'Arial', sans-serif";
        Chart.defaults.color = '#6c757d';
        
        const ctxJam = document.getElementById('chartJamKerja').getContext('2d');
       
        var gradientJam = ctxJam.createLinearGradient(0, 0, 0, 300);
        gradientJam.addColorStop(0, 'rgba(54, 162, 235, 0.8)');
        gradientJam.addColorStop(1, 'rgba(54, 162, 235, 0.1)');

        new Chart(ctxJam, {
            type: 'bar', 
            data: {
                labels: labelsHari,
                datasets: [{
                    label: 'Working Hours',
                    data: dataJam,
                    backgroundColor: gradientJam, 
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 0,
                    borderRadius: 6,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        border: { display: false },
                        grid: { color: '#f1f1f1', borderDash: [5, 5] }
                    },
                    x: { 
                        grid: { display: false },
                        border: { display: false }
                    }
                }
            }
        });

 
        const ctxInv = document.getElementById('chartInvoice').getContext('2d');
      
        var gradientInv = ctxInv.createLinearGradient(0, 0, 0, 300);
        gradientInv.addColorStop(0, 'rgba(75, 192, 192, 0.8)');
        gradientInv.addColorStop(1, 'rgba(75, 192, 192, 0.1)');

        new Chart(ctxInv, {
            type: 'line', 
            data: {
                labels: labelsHari,
                datasets: [{
                    label: 'Pendapatan ($)',
                    data: dataInvoice,
                    backgroundColor: gradientInv, 
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'rgba(75, 192, 192, 1)',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4  
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return '$ ' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        border: { display: false },
                        grid: { color: '#f1f1f1', borderDash: [5, 5] }
                    },
                    x: { 
                        grid: { display: false },
                        border: { display: false }
                    }
                }
            }
        });

        
        $('#dutySwitch').hover(function() { $(this).toggleClass('shadow'); });

        $('#dutySwitch').change(function() {
            var isChecked = $(this).is(':checked');
            var label = $('#dutyLabel');
            var statusBox = $('#dutyStatusBox');
            var statusIcon = $('#statusIcon');
            var statusText = $('#statusText');

            $(this).prop('disabled', true);
            
        
            statusText.text('Memproses data...');
            statusBox.removeClass('alert-success alert-danger').addClass('alert-warning bg-opacity-25 text-dark');
            statusIcon.attr('class', 'fa-solid fa-spinner fa-spin fa-lg me-3 text-dark');

            $.ajax({
                url: "{{ route('duty.toggle', [], false) }}",
                type: "POST",
                data: { _token: "{{ csrf_token() }}" },
                success: function(response) {
                    statusBox.removeClass('alert-warning bg-opacity-25 text-dark');
                    
                    if(response.status === 'on') {
                        label.removeClass('text-danger').addClass('text-success').text('ON DUTY');
                        statusBox.removeClass('alert-danger').addClass('alert-success');
                        statusIcon.attr('class', 'fa-solid fa-business-time fa-lg me-3');
                        statusText.text('You are on duty, work hard!');
                        
                        Swal.fire({
                            title: 'Success On-Duty!',
                            text: 'Working time starts to be counted.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                      
                        label.removeClass('text-success').addClass('text-danger').text('OFF DUTY');
                        statusBox.removeClass('alert-success').addClass('alert-danger');
                        statusIcon.attr('class', 'fa-solid fa-ban fa-lg me-3');
                        statusText.text('You are not on duty, have a good rest.');
                      
                        let formattedMsg = response.message;
                        
                       
                        let match = formattedMsg.match(/Durasi:\s*([0-9.]+)\s*Jam/);
                        
                        if(match) {
                            let raw = parseFloat(match[1]);  
                            let jam = Math.floor(raw);
                            let menit = Math.round((raw - jam) * 60);
                            let timeStr = "";
                            
                            if(jam > 0) {
                                timeStr = jam + " Jam " + menit + " Menit";
                            } else {
                                timeStr = menit + " Menit";
                            }
                            
                            formattedMsg = formattedMsg.replace(match[0], "Durasi: " + timeStr);
                        }
                        

                        Swal.fire({
                            title: 'Off-Duty Berhasil',
                            text: formattedMsg, 
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }
                },
                error: function() {
                    var prev = !isChecked;
                    $('#dutySwitch').prop('checked', prev);
                    statusBox.removeClass('alert-warning bg-opacity-25 text-dark');
                    Swal.fire('Error', 'Gagal menghubungi server.', 'error');
                },
                complete: function() {
                    $('#dutySwitch').prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush