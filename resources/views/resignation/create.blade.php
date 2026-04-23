@extends('layouts.app') 

@section('content')

<style>
     
    .fade-in-up {
        animation: fadeInUp 0.7s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }

     
    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        background: #ffffff;
        overflow: hidden;
    }

    .card-modern-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 2rem;
        border-bottom: none;
    }

    .card-modern-header h4 {
        color: #ffffff;
        margin: 0;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

     
    .alert-modern {
        border: none;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        position: relative;
        overflow: hidden;
    }

    .alert-modern::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 5px; height: 100%;
        background: currentColor;
        opacity: 0.8;
    }

    .alert-modern-warning { background-color: #fff9e6; color: #9c6c0a; }
    .alert-modern-success { background-color: #eafbf3; color: #1e7e4c; }
    .alert-modern-danger { background-color: #fceced; color: #b71c1c; }

     
    .form-modern-textarea {
        border-radius: 16px;
        border: 2px solid #f1f1f4;
        padding: 1.25rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background-color: #fafbfc;
    }

    .form-modern-textarea:focus {
        border-color: #2a5298;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(42, 82, 152, 0.1);
        outline: none;
    }

    .btn-modern {
        border-radius: 12px;
        padding: 0.8rem 1.8rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-modern-primary {
        background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
        color: white;
    }

    .btn-modern-danger {
        background: #dc3545;
        color: white;
    }
    
    .btn-modern-danger:hover {
        background: #c82333;
    }

    .reason-box {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #edf2f7;
    }
</style>

<div class="container-fluid py-4 fade-in-up">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card card-modern">
                <div class="card-modern-header d-flex align-items-center gap-3">
                    <i class="fa-solid fa-file-signature fa-2x text-white opacity-75"></i>
                    <div>
                        <h4>Resignation Submission</h4>
                        <span class="text-white opacity-75 small">Manage your resignation status and form</span>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    
                    @if(session('success'))
                        <div class="alert alert-modern alert-modern-success mb-4 fade-in-up" style="animation-delay: 0.1s;">
                            <i class="fa-solid fa-circle-check fa-lg mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Success!</h6>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

            
                    @if(!$existingResignation || $existingResignation->status == 'declined')
                        
                        @if($existingResignation && $existingResignation->status == 'declined')
                            <div class="alert alert-modern alert-modern-danger mb-4 fade-in-up" style="animation-delay: 0.1s;">
                                <i class="fa-solid fa-circle-xmark fa-lg mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Submission Rejected</h6>
                                    Your previous submission was rejected by <strong>{{ $existingResignation->approver->name ?? 'Admin' }}</strong>. You may fill out the form below to submit again.
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('resignation.store') }}" method="POST" class="fade-in-up" style="animation-delay: 0.2s;">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="reason" class="fw-bold text-dark mb-2">
                                    <i class="fa-solid fa-pen-clip me-2 text-primary"></i>Reason for Resignation
                                </label>
                                <textarea name="reason" id="reason" rows="6" class="form-control form-modern-textarea" placeholder="Clearly and politely explain why you are submitting your resignation..." required></textarea>
                                @error('reason')
                                    <small class="text-danger fw-bold mt-2 d-block"><i class="fa-solid fa-triangle-exclamation me-1"></i>{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-modern btn-modern-primary">
                                    Submit Application <i class="fa-solid fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </form>

    
                    @elseif($existingResignation->status == 'pending')
                        <div class="alert alert-modern alert-modern-warning mb-4 fade-in-up" style="animation-delay: 0.1s;">
                            <i class="fa-solid fa-hourglass-half fa-lg mt-1 fa-spin-pulse"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Awaiting Approval</h6>
                                You have already submitted your resignation. Your document is currently being reviewed by the Admin.
                            </div>
                        </div>

                        <div class="reason-box fade-in-up" style="animation-delay: 0.2s;">
                            <span class="text-uppercase fw-bold text-muted small" style="letter-spacing: 1px;">Submitted Reason:</span>
                            <p class="mt-2 mb-0 text-dark fs-6" style="line-height: 1.6;">
                                "{{ $existingResignation->reason }}"
                            </p>
                        </div>

       
                        <div class="d-flex justify-content-end mt-4 fade-in-up" style="animation-delay: 0.3s;">
                            <form action="{{ route('resignation.destroy') }}" method="POST" id="cancelForm">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-modern btn-modern-danger d-flex align-items-center gap-2" onclick="confirmCancel()">
                                    <i class="fa-solid fa-xmark fs-5"></i> Cancel Submission
                                </button>
                            </form>
                        </div>

        
                    @elseif($existingResignation->status == 'approved')
                        <div class="alert alert-modern alert-modern-success mb-0 fade-in-up" style="animation-delay: 0.1s;">
                            <i class="fa-solid fa-handshake-angle fa-lg mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Application Approved</h6>
                                Your resignation request has been <strong>approved</strong>. Thank you for your dedication and hard work while you have been with us.
                                <hr class="my-2 opacity-25">
                                <span class="small fw-bold">Approved by: <i class="fa-regular fa-user mx-1"></i> {{ $existingResignation->approver->name ?? 'Admin' }}</span>
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmCancel() {
        Swal.fire({
            title: 'Cancel Submission?',
            text: "Are you sure you want to cancel this resignation submission?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545', 
            cancelButtonColor: '#6c757d', 
            confirmButtonText: '<i class="fa-solid fa-check me-1"></i> Yes, Cancel!',
            cancelButtonText: '<i class="fa-solid fa-xmark me-1"></i> Back',
            reverseButtons: true, 
            customClass: {
                popup: 'card-modern', 
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancelForm').submit();
            }
        })
    }
</script>

@endsection