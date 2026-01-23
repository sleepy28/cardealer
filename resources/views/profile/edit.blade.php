
@extends(Auth::user()->role == 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show text-white" role="alert">
                    <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-user-gear me-2 text-primary"></i> Pengaturan Akun</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <label class="form-label fw-bold d-block mb-3">Foto Profil</label>
                                
                                <div class="mb-3 d-flex justify-content-center position-relative">
                                    
                                    <img id="avatar_preview" 
                                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : '#' }}" 
                                         alt="Avatar Preview" 
                                         class="rounded-circle shadow-sm img-thumbnail {{ $user->avatar ? '' : 'd-none' }}" 
                                         style="width: 150px; height: 150px; object-fit: cover;">

                                    
                                    @if(!$user->avatar)
                                        <div id="avatar_initials" class="rounded-circle shadow-sm bg-secondary d-flex align-items-center justify-content-center text-white fw-bold display-4" style="width: 150px; height: 150px;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>

                                <div class="d-grid">
                                    <label for="avatar_input" class="btn btn-outline-primary btn-sm cursor-pointer">
                                        <i class="fa-solid fa-camera me-1"></i> Ganti Foto
                                    </label>
                                    <input type="file" name="avatar" id="avatar_input" class="d-none @error('avatar') is-invalid @enderror" accept="image/*">
                                    
                                    @error('avatar')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted mt-2">Format: JPG, PNG. Max: 2MB.</small>
                                </div>
                            </div>

                            
                            <div class="col-md-8">
                                <h6 class="fw-bold text-muted mb-3">Informasi Dasar</h6>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <hr class="my-4">

                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-muted mb-0">
                                        <i class="fa-solid fa-shield-halved me-1"></i> Keamanan Akun
                                    </h6>
                                    
                                    <button type="button" id="btn_toggle_password" class="btn btn-outline-secondary btn-sm">
                                        <i class="fa-solid fa-key me-1"></i> Ganti Password
                                    </button>
                                </div>

                                
                                
                                <div id="password_section" class="d-none bg-light p-3 rounded border">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label small fw-bold">Password Saat Ini</label>
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Masukkan password lama untuk verifikasi">
                                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="new_password" class="form-label small fw-bold">Password Baru</label>
                                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" placeholder="Minimal 8 karakter">
                                            @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="new_password_confirmation" class="form-label small fw-bold">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Ulangi password baru">
                                        </div>
                                    </div>
                                    <small class="text-muted fst-italic">* Klik tombol "Batal" di atas jika tidak jadi mengganti password.</small>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                                        <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const avatarInput = document.getElementById('avatar_input');
        const avatarPreview = document.getElementById('avatar_preview');
        const avatarInitials = document.getElementById('avatar_initials');

        avatarInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                    avatarPreview.classList.remove('d-none');
                    if (avatarInitials) avatarInitials.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            }
        });

        
        const btnToggle = document.getElementById('btn_toggle_password');
        const passSection = document.getElementById('password_section');
        
        
        const inputCurrent = document.getElementById('current_password');
        const inputNew = document.getElementById('new_password');
        const inputConfirm = document.getElementById('new_password_confirmation');

        
        
        const hasError = @json($errors->has('current_password') || $errors->has('new_password'));
        
        if(hasError) {
            passSection.classList.remove('d-none');
            btnToggle.innerHTML = '<i class="fa-solid fa-xmark me-1"></i> Batal Ganti Password';
            btnToggle.classList.replace('btn-outline-secondary', 'btn-outline-danger');
        }

        btnToggle.addEventListener('click', function() {
            
            const isHidden = passSection.classList.contains('d-none');

            if (isHidden) {
                
                passSection.classList.remove('d-none');
                
                this.innerHTML = '<i class="fa-solid fa-xmark me-1"></i> Batal Ganti Password';
                this.classList.replace('btn-outline-secondary', 'btn-outline-danger');
            } else {
                
                passSection.classList.add('d-none');
                
                this.innerHTML = '<i class="fa-solid fa-key me-1"></i> Ganti Password';
                this.classList.replace('btn-outline-danger', 'btn-outline-secondary');
                
                
                inputCurrent.value = '';
                inputNew.value = '';
                inputConfirm.value = '';
            }
        });
    });
</script>
@endsection