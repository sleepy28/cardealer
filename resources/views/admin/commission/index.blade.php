@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">🏷️ Master Commission</h3>
            <p class="text-muted text-sm mb-0">Set sales categories and sales commission amounts.</p>
        </div>
    </div>

    
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 text-uppercase text-secondary text-xxs font-weight-bolder">ID</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">categories</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Commission Amount ($)</th>
                            <th class="text-end pe-4 text-uppercase text-secondary text-xxs font-weight-bolder">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rates as $rate)
                        <tr>
                            <td class="ps-4 text-secondary text-xs font-weight-bold">#{{ $rate->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center text-dark">
                                        <i class="fa-solid fa-tag"></i>
                                    </div>
                                    <span class="text-dark font-weight-bold text-sm">{{ $rate->category }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-3">
                                    $ {{ number_format($rate->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                
                                <button type="button" 
                                        class="btn btn-sm btn-primary btn-edit"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal"
                                        data-id="{{ $rate->id }}"
                                        data-category="{{ $rate->category }}"
                                        data-amount="{{ $rate->amount }}">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Belum ada data komisi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold" id="editModalLabel">✏️ Edit Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                  
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">category name</label>
                        
                        <input type="text" 
                               id="modalCategory" 
                               class="form-control bg-light fw-bold text-dark" 
                               readonly>
                    </div>
 
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Amount Commission ($)</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-white text-success fw-bold">$</span>
                            <input type="number" name="amount" id="modalAmount" class="form-control border-start-0 ps-0" required>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">SAVE CHANGE</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            html: '<ul class="text-start">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
        });
    @endif
 
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('editModal');
        
        editModal.addEventListener('show.bs.modal', function (event) {
           
            var button = event.relatedTarget;
            
           
            var id = button.getAttribute('data-id');
            var category = button.getAttribute('data-category');
            var amount = button.getAttribute('data-amount');
            
            
            document.getElementById('modalCategory').value = category;
            document.getElementById('modalAmount').value = amount;
            
           
            var urlTemplate = "{{ route('admin.commission.update', ':id', false) }}";
            var finalUrl = urlTemplate.replace(':id', id);
            
            document.getElementById('editForm').action = finalUrl;
        });
    });
</script>
@endpush