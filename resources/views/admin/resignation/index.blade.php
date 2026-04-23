@extends('layouts.admin') 

@section('content')
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Manage Resignation Requests</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-xmark-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-secondary fw-semibold">Submission Date</th>
                            <th scope="col" class="text-secondary fw-semibold">Employee Name</th>
                            <th scope="col" class="text-secondary fw-semibold" style="width: 25%;">Reason</th>
                            <th scope="col" class="text-secondary fw-semibold text-center">Status</th>
                            <th scope="col" class="text-secondary fw-semibold">Approver</th>  
                            <th scope="col" class="text-secondary fw-semibold text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($resignations as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                            <td class="fw-bold text-dark">{{ $item->user->name ?? 'Unknown User' }}</td>
                            <td>
                                <p class="mb-0 text-muted small text-wrap" style="max-height: 60px; overflow-y: auto;">
                                    {{ $item->reason }}
                                </p>
                            </td>
                            <td class="text-center">
                                @if($item->status == 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fa-solid fa-hourglass-half me-1"></i> Pending</span>
                                @elseif($item->status == 'approved')
                                    <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fa-solid fa-check me-1"></i> Approved</span>
                                @elseif($item->status == 'declined')
                                    <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fa-solid fa-xmark me-1"></i> Rejected</span>
                                @endif
                            </td>

                 
                            <td>
                                @if($item->status != 'pending' && $item->approver)
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                            <i class="fa-solid fa-user-tie text-secondary small"></i>
                                        </div>
                                        <span class="small fw-semibold text-dark">{{ $item->approver->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($item->status == 'pending')
                                    <div class="d-flex justify-content-center gap-2">
                                       
                                        <form action="{{ route('admin.resignation.approve', $item->id) }}" method="POST" id="approveForm-{{ $item->id }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-sm btn-success rounded-3" onclick="confirmAction('approveForm-{{ $item->id }}', 'Approve Request?', 'Are you sure you want to approve this resignation?', 'Yes, Approve', '#198754')">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>

                                  
                                        <form action="{{ route('admin.resignation.reject', $item->id) }}" method="POST" id="rejectForm-{{ $item->id }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-sm btn-danger rounded-3" onclick="confirmAction('rejectForm-{{ $item->id }}', 'Reject Request?', 'Are you sure you want to reject this request?', 'Yes, Reject', '#dc3545')">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small"><i class="fa-solid fa-lock me-1"></i> Process completed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted"> 
                                <i class="fa-solid fa-folder-open fa-2x mb-2 opacity-50"></i>
                                <br>No resignation requests available yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmAction(formId, title, text, confirmText, confirmColor) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa-solid fa-check me-1"></i> ' + confirmText,
            cancelButtonText: '<i class="fa-solid fa-xmark me-1"></i> Cancel',
            reverseButtons: true,
            customClass: { popup: 'rounded-4' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        })
    }
</script>
@endsection