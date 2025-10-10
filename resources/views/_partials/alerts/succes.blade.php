@if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <span class="alert-icon text-success me-2">
            <i class="tf-icons ti i-check-circle ti-xs"></i>
        </span>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
@endif