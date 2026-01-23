@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white pb-0 border-0">
                    <h5 class="fw-bold text-dark m-0">Edit Komisi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.commission.update', $rate->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Nama Kategori (Database Value)</label>
                            <input type="text" name="category" class="form-control" value="{{ $rate->category }}" required>
                            <small class="text-danger text-xs">*Pastikan nama ini sama dengan value di Form Input Sales agar terdeteksi otomatis.</small>
                        </div>

                        
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Nominal Komisi ($)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="amount" class="form-control" value="{{ $rate->amount }}" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.commission.index') }}" class="btn btn-light border">Batal</a>
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection