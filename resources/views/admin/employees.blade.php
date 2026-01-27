@extends('layouts.admin')

@push('styles')
<style>
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    
    .animate-enter {
        opacity: 0; 
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    
    .table-card { 
        background: white; 
        border-radius: 16px; 
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025); 
        overflow: hidden; 
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .table-custom thead {
        background-color: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-custom th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .table-custom tr {
        transition: background-color 0.2s ease;
    }
    
    .table-custom tr:hover td {
        background-color: #f8fafc; 
    }

    .avatar-circle { 
        width: 40px; 
        height: 40px; 
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-weight: 700; 
        color: #475569; 
        font-size: 0.9rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .avatar-img {
        width: 40px; 
        height: 40px; 
        object-fit: cover; 
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: 2px solid #fff;
    }

    
    .badge-modern {
        padding: 0.5em 0.8em;
        font-weight: 600;
        letter-spacing: 0.02em;
        border-radius: 6px;
    }

    
    
    .swal2-container {
        z-index: 20000 !important; 
    }
    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal {
        z-index: 1050 !important;
    }
</style>
@endpush

@section('content')


@if ($errors->any())
    <div class="alert alert-danger shadow-sm border-0 mb-4 animate-enter">
        <div class="d-flex align-items-center mb-2">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Perhatian</strong>
        </div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="animate-enter" style="animation-delay: 0ms">
            <h2 class="fw-bold text-dark m-0" style="letter-spacing: -0.5px;">Employees Data</h2>
            <p class="text-muted small m-0">Manage your team members and roles.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm animate-enter" style="animation-delay: 100ms; padding: 10px 20px; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
            <i class="fas fa-plus-circle me-2"></i>Add Employee
        </button>
    </div>

    
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({ 
                    title: 'Berhasil!', 
                    text: "{{ session('success') }}", 
                    icon: 'success', 
                    confirmButtonColor: '#3b82f6', 
                    confirmButtonText: 'OK'
                    
                });
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({ 
                    title: 'Akses Ditolak!', 
                    text: "{{ session('error') }}", 
                    icon: 'error', 
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <div class="table-card animate-enter" style="animation-delay: 200ms">
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Username</th>
                        <th class="text-end pe-5">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="animate-enter" style="animation-delay: {{ ($loop->index * 100) + 300 }}ms">
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" class="avatar-img me-3" alt="avatar">
                                @else
                                    <div class="avatar-circle me-3">{{ substr($user->name, 0, 1) }}</div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem"><i class="far fa-id-card me-1"></i>{{ $user->citizen_id ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge badge-modern bg-dark"><i class="fas fa-shield-alt me-1"></i> ADMINISTRATOR</span>
                            @elseif($user->role == 'finance')
                                <span class="badge badge-modern bg-warning text-dark bg-opacity-25 border border-warning">FINANCE</span>
                            @else
                                <span class="badge badge-modern bg-primary bg-opacity-10 text-primary text-uppercase border border-primary border-opacity-10">
                                    {{ str_replace('_', ' ', $user->role) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_on_duty)
                                <span class="badge badge-modern bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                    <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i> ON DUTY
                                </span>
                            @else
                                <span class="badge badge-modern bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">
                                    <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i> OFF DUTY
                                </span>
                            @endif
                        </td>
                        <td class="text-muted small fw-semibold">{{ $user->username }}</td>
                        
                        
                        <td class="text-end pe-4">
                            
                         
                            @php
                                $canEdit = auth()->user()->role === 'admin' || (auth()->user()->role === 'finance' && $user->role !== 'admin');
                            @endphp

                            @if($canEdit)
                                <button class="btn btn-sm btn-light border shadow-sm me-1 text-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}" style="border-radius: 6px;">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @else
                                <button class="btn btn-sm btn-light border me-1 text-muted" disabled style="border-radius: 6px; opacity: 0.5; cursor: not-allowed;">
                                    <i class="fas fa-lock"></i>
                                </button>
                            @endif
                            
                            
                            @if(auth()->user()->role === 'admin' && $user->id != auth()->id())
                                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.employees.delete', $user->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-light border shadow-sm text-danger" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" style="border-radius: 6px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    
    
    
    @foreach($users as $user)
    <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="px-3 pt-1 pb-3">
                    <small class="text-muted">Update information for <span class="fw-bold text-dark">{{ $user->name }}</span></small>
                </div>
                <form action="{{ route('admin.employees.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body bg-light bg-opacity-50 py-4">
                        
                        @php
                            // Finance tidak boleh mengedit data Admin
                            $isEditable = auth()->user()->role === 'admin' || (auth()->user()->role === 'finance' && $user->role !== 'admin');
                        @endphp
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control shadow-sm" 
                                   value="{{ $user->name }}" 
                                   required 
                                   {{ !$isEditable ? 'disabled bg-light' : '' }}>
                        </div>

                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Username Login</label>
                            <input type="text" name="username" class="form-control shadow-sm" 
                                   value="{{ $user->username }}" 
                                   required
                                   {{ !$isEditable ? 'disabled bg-light' : '' }}>
                        </div>

                        <div class="row">
                            
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Jabatan / Role</label>
                                <select name="role" class="form-select shadow-sm" 
                                        {{ !$isEditable ? 'disabled bg-light' : '' }}>
                                    
                      
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Staff)</option>
                                    <option value="recruit" {{ $user->role == 'recruit' ? 'selected' : '' }}>Recruit</option>
                                    <option value="showroom_sales" {{ $user->role == 'showroom_sales' ? 'selected' : '' }}>Showroom Sales</option>
                                    <option value="business_sales" {{ $user->role == 'business_sales' ? 'selected' : '' }}>Business Sales</option>
                                    
                                   
                                    @if(auth()->user()->role === 'admin')
                                        <option value="finance" {{ $user->role == 'finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                                    @elseif($user->role == 'finance') 
                                      
                                        <option value="finance" selected>Finance</option>
                                    @endif
                                </select>
                            </div>

                            
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Status</label>
                                <select name="status" class="form-select shadow-sm border-success" {{ !$isEditable ? 'disabled' : '' }}>
                                    <option value="1" {{ $user->is_on_duty ? 'selected' : '' }}>🟢 On Duty</option>
                                    <option value="0" {{ !$user->is_on_duty ? 'selected' : '' }}>⚪ Off Duty</option>
                                </select>
                            </div>
                        </div>
                        
                        <hr class="text-muted opacity-25">

                        
                        @if($isEditable)
                            <div class="mb-1">
                                <label class="form-label small fw-bold text-danger">Reset Password</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white text-muted"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Isi hanya jika ingin mengubah">
                                </div>
                            </div>
                        @else
                            <div class="alert alert-light border text-center small text-muted mb-0">
                                <i class="fas fa-lock me-1"></i> Restricted.
                            </div>
                        @endif

                    </div>
                    <div class="modal-footer border-top-0 pt-0 pb-3 bg-light bg-opacity-50">
                        <button type="button" class="btn btn-link text-muted no-decoration fw-bold" data-bs-dismiss="modal">Batal</button>
                        @if($isEditable)
                            <button type="submit" class="btn btn-dark px-4 rounded-3 shadow-sm">Simpan</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    
 
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="px-3 pt-1 pb-3">
                    <small class="text-muted">Create a new account for your staff.</small>
                </div>
                <form action="{{ route('admin.employee.store') }}" method="POST">
                    @csrf
                    <div class="modal-body bg-light bg-opacity-50 py-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Citizen ID</label>
                            <input type="text" name="citizen_id" class="form-control shadow-sm" placeholder="CX91C4" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Full Name</label>
                            <input type="text" name="name" class="form-control shadow-sm" placeholder="Maman Resing" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Username</label>
                                <input type="text" name="username" class="form-control shadow-sm" placeholder="Username" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Password</label>
                                <input type="password" name="password" class="form-control shadow-sm" placeholder="min 6 chars" required>
                            </div>
                        </div>

                        
                        <div class="mb-1">
                            <label class="form-label small fw-bold text-uppercase text-muted">Role</label>
                            
                            
                            @if(in_array(auth()->user()->role, ['admin', 'finance']))
                                <select name="role" class="form-select shadow-sm" required>
                                    <option value="" disabled selected>-- Select Role --</option>
                                    
                                    <optgroup label="Sales Team">
                                         
                                        @if(auth()->user()->role === 'admin')
                                            <option value="user">User / Staff</option>
                                        @endif

                                      
                                        <option value="recruit">Recruit</option>
                                        <option value="showroom_sales">Showroom Sales</option>
                                        <option value="business_sales">Business Sales</option>
                                    </optgroup>
                                    
                          
                                    @if(auth()->user()->role === 'admin')
                                        <optgroup label="Management">
                                            <option value="finance">Finance</option>
                                            <option value="admin">Administrator</option>
                                        </optgroup>
                                    @endif
                                </select>
                            @else
                              
                                <input type="text" class="form-control bg-white text-muted shadow-sm" value="Restricted" disabled>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0 pb-3 bg-light bg-opacity-50">
                        <button type="button" class="btn btn-link text-muted no-decoration fw-bold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 rounded-3 shadow-sm">Save Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function confirmDelete(userId, userName) {
        Swal.fire({
            title: 'Hapus Karyawan?',
            text: "Anda akan menghapus data '" + userName + "'. Data penjualan terkait mungkin akan kehilangan relasinya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1e293b', 
            cancelButtonColor: '#94a3b8', 
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true
            
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        })
    }
</script>
@endpush