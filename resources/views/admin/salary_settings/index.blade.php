@extends('layouts.app') 

@section('content')


<style>
    
    :root {
        --primary-color: #4f46e5; 
        --hover-bg: #f9fafb;
        --border-radius: 12px;
    }

    
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
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        border-radius: 16px;
        background: #fff;
        overflow: hidden;
    }

    
    .table-modern thead th {
        background-color: #f3f4f6;
        color: #6b7280;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
        border: none;
    }

    .table-modern tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f3f4f6;
    }

    .table-modern tbody tr:hover {
        background-color: #f8fafc;
        transform: scale(1.005); 
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        z-index: 10;
        position: relative;
    }

    .table-modern td {
        padding: 1.2rem 1.5rem;
        vertical-align: middle;
    }

    
    .form-control-modern {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        transition: all 0.3s;
        background-color: #f9fafb;
        font-weight: 600;
        color: #374151;
    }
    
    .form-control-modern:focus {
        background-color: #fff;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    
    .btn-modern {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    
    .role-badge {
        display: inline-block;
        padding: 0.5em 1em;
        background-color: #eef2ff;
        color: #4f46e5;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
</style>

<div class="container py-5">
    
    <div class="d-flex align-items-center mb-4 animate-enter" style="animation-delay: 0.1s">
        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3 text-primary">
            <i class="fas fa-cogs fa-2x"></i>
        </div>
        <div>
            <h3 class="fw-bold text-dark m-0">Setting Gaji Per Role</h3>
            <p class="text-secondary small m-0">Atur besaran gaji pokok dan lembur untuk setiap jabatan.</p>
        </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm animate-enter" style="animation-delay: 0.2s; background-color: #ecfdf5; color: #065f46;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card card-modern animate-enter" style="animation-delay: 0.3s">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th style="width: 20%">Role</th>
                            <th style="width: 35%">Gaji Pokok (Base)</th>
                            <th style="width: 25%">Rate Lembur</th>
                            <th style="width: 20%" class="text-end pe-5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($settings as $set)
                         
                        <tr class="animate-enter" style="animation-delay: {{ ($loop->index * 100) + 400 }}ms">
                            <form action="{{ route('admin.salary_settings.update', $set->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <td>
                                    <span class="role-badge text-uppercase">
                                        {{ $set->role }}
                                    </span>
                                </td>
                                
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0 text-muted" style="border: 1px solid #e5e7eb; border-radius: 8px 0 0 8px;">$</span>
                                        <input type="number" name="base_salary" class="form-control form-control-modern border-start-0 ps-1" value="{{ $set->base_salary }}" style="border-radius: 0 8px 8px 0;">
                                    </div>
                                    <div class="mt-1">
                                        <small class="text-muted fst-italic" style="font-size: 0.75rem;">
                                            <i class="fas fa-info-circle me-1"></i>Default: 4800 / 13600
                                        </small>
                                    </div>
                                </td>

                                <td>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0 text-muted" style="border: 1px solid #e5e7eb; border-radius: 8px 0 0 8px;">$</span>
                                        <input type="number" name="overtime_rate" class="form-control form-control-modern border-start-0 ps-1" value="{{ $set->overtime_rate }}" style="border-radius: 0 8px 8px 0;">
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Per Jam</small>
                                </td>
                                
                                <input type="hidden" name="threshold_hours" value="{{ $set->threshold_hours }}">

                                <td class="text-end pe-4 align-middle">
                                    <button type="submit" class="btn btn-primary btn-modern btn-sm shadow-sm text-white">
                                        <i class="fas fa-save me-2"></i> Update
                                    </button>
                                </td>
                            </form>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection