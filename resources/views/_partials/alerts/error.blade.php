@if(session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <span class="alert-icon text-danger me-2">
            <i class="tf-icons ti ti-alert-circle ti-xs"></i>
        </span>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
@endif