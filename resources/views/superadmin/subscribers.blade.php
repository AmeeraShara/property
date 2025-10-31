@extends('layouts.app')

@section('content')
{{--  Bootstrap CSS & Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

{{--  Navbar --}}
@include('superadmin.navbar')

<div class="container mt-5">
    <h2 class="text-center mb-4 text-black fw-bold">All Subscribers</h2>

    {{--  Filter Form --}}
    <form method="GET" class="d-flex justify-content-end mb-4 gap-2 flex-wrap">
        <select name="status" id="status" class="form-select form-select-sm text-center" style="width: 150px;">
            <option value="">Status</option>
            <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
            <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
        </select>
        <button type="submit" class="btn btn-dark btn-sm d-flex align-items-center justify-content-center" style="width: 100px;">
             Filter
        </button>
    </form>

    {{--  Subscribers Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Subscribed At</th>
                    <th>Status</th>
                    <th width="160px" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                <tr>
                    <td>{{ $subscriber->id }}</td>
                    <td>{{ $subscriber->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($subscriber->subscribed_at)->format('Y-m-d H:i') }}</td>
                    <td>
                        <span class="badge {{ $subscriber->is_active ? 'bg-dark' : 'bg-warning' }}">
                            {{ $subscriber->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-center">
                        {{--  Action buttons stacked on mobile --}}
                        <div class="d-flex flex-wrap justify-content-center gap-2">
                            {{-- View --}}
                            <a href="javascript:void(0);" 
                               class="btn btn-link text-primary p-0 openViewModal" 
                               data-url="{{ route('superadmin.subscribers.show', $subscriber->id) }}" 
                               data-bs-toggle="tooltip" title="View Subscriber">
                                <i class="bi bi-eye fs-6"></i>
                            </a>

                            {{-- Edit --}}
                            <a href="javascript:void(0);" 
                               class="btn btn-link text-warning p-0 openEditModal" 
                               data-url="{{ route('superadmin.subscribers.edit', $subscriber->id) }}" 
                               data-bs-toggle="tooltip" title="Edit Subscriber">
                                <i class="bi bi-pencil-square fs-6"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('superadmin.subscribers.destroy', $subscriber->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0" data-bs-toggle="tooltip" title="Delete Subscriber">
                                    <i class="bi bi-trash fs-6"></i>
                                </button>
                            </form>

                            {{-- Toggle Active/Inactive --}}
                            <form action="{{ route('superadmin.subscribers.toggle', $subscriber->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="btn btn-link text-secondary p-0" 
                                        data-bs-toggle="tooltip"
                                        title="{{ $subscriber->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="bi {{ $subscriber->is_active ? 'bi-person-x' : 'bi-person-check' }} fs-6"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">No subscribers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{--  Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $subscribers->links('pagination::bootstrap-5') }}
    </div>
</div>

{{--  View Subscriber Modal --}}
<div class="modal fade" id="viewSubscriberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subscriber Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewSubscriberModalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  Edit Subscriber Modal --}}
<div class="modal fade" id="editSubscriberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subscriber</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="editSubscriberModalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  jQuery & Bootstrap JS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Bootstrap tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // View Subscriber Modal
    $('.openViewModal').click(function() {
        let url = $(this).data('url');
        $('#viewSubscriberModalBody').html('<div class="text-center"><div class="spinner-border" role="status"></div></div>');
        $('#viewSubscriberModal').modal('show');
        $.get(url, function(data) {
            $('#viewSubscriberModalBody').html(data);
        }).fail(function() {
            $('#viewSubscriberModalBody').html('<div class="alert alert-danger">Failed to load subscriber details.</div>');
        });
    });

    // Edit Subscriber Modal
    $('.openEditModal').click(function() {
        let url = $(this).data('url');
        $('#editSubscriberModalBody').html('<div class="text-center"><div class="spinner-border" role="status"></div></div>');
        $('#editSubscriberModal').modal('show');
        $.get(url, function(data) {
            $('#editSubscriberModalBody').html(data);
        }).fail(function() {
            $('#editSubscriberModalBody').html('<div class="alert alert-danger">Failed to load edit form.</div>');
        });
    });
});
</script>

{{--  Custom CSS --}}
<style>
.table td .bi { font-size: 1rem; }
.pagination { font-size: 0.85rem; }
.page-link { padding: 0.25rem 0.5rem; }

/* Mobile responsiveness for actions */
@media (max-width: 576px) {
    .table td .d-flex.flex-wrap { 
        flex-direction: column !important; 
        gap: 5px; 
    }
    .table td .btn { 
        padding: 4px 6px !important; 
    }
}
</style>

@endsection
