@extends('layouts.app')

@section('content')
{{--  Bootstrap CSS and Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

{{--  Navbar --}}
@include('superadmin.navbar')

<div class="container mt-5">
    <h2 class="mb-4 text-center fw-bold text-black">All Properties</h2>

    {{--  Filter Form --}}
    <form method="GET" class="row g-2 mb-4 align-items-end">
        <div class="col-6 col-sm-4 col-md-2">
            <select name="type" class="form-select form-select-sm">
                <option value="">Type</option>
                @foreach($types as $t)
                    <option value="{{ $t }}" {{ request('type') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-sm-4 col-md-2">
            <select name="category" class="form-select form-select-sm">
                <option value="">Category</option>
                @foreach($categories as $c)
                    <option value="{{ $c }}" {{ request('category') == $c ? 'selected' : '' }}>{{ ucfirst($c) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-sm-4 col-md-2">
            <select name="district" class="form-select form-select-sm">
                <option value="">District</option>
                @foreach($districts as $d)
                    <option value="{{ $d }}" {{ request('district') == $d ? 'selected' : '' }}>{{ $d }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-sm-4 col-md-2">
            <select name="city" class="form-select form-select-sm">
                <option value="">City</option>
                @foreach($cities as $c)
                    <option value="{{ $c }}" {{ request('city') == $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-sm-4 col-md-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">Status</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
            </select>
        </div>
        <div class="col-6 col-sm-4 col-md-2">
            <button type="submit" class="btn btn-dark w-100 btn-sm">Filter</button>
        </div>
    </form>

    {{--  Properties Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>District</th>
                    <th>City</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th width="120px" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $property)
                <tr>
                    <td>{{ $property->id }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $property->title }}</td>
                    <td>{{ ucfirst($property->type) }}</td>
                    <td>{{ ucfirst($property->category) }}</td>
                    <td>{{ $property->district }}</td>
                    <td>{{ $property->city }}</td>
                    <td>${{ number_format($property->price, 2) }}</td>
                    <td>
                        <span class="badge {{ $property->status=='active' ? 'bg-dark' : 'bg-secondary' }}">
                            {{ ucfirst($property->status) }}
                        </span>
                    </td>
                    <td class="text-center">
                        {{-- View --}}
                        <button type="button"
                                class="btn btn-link text-primary p-0 me-2"
                                data-bs-toggle="modal"
                                data-bs-target="#viewPropertyModal"
                                data-id="{{ $property->id }}"
                                title="View Property">
                            <i class="bi bi-eye fs-6"></i>
                        </button>

                        {{-- Edit --}}
                        <button type="button"
                                class="btn btn-link text-warning p-0 me-2"
                                data-bs-toggle="modal"
                                data-bs-target="#editPropertyModal"
                                data-id="{{ $property->id }}"
                                title="Edit Property">
                            <i class="bi bi-pencil-square fs-6"></i>
                        </button>

                        {{-- Delete --}}
                        <form action="{{ route('superadmin.properties.delete', $property->id) }}" 
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this property?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger p-0" title="Delete Property">
                                <i class="bi bi-trash fs-6"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">No properties found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


</div>

{{--  View Modal --}}
<div class="modal fade" id="viewPropertyModal" tabindex="-1" aria-labelledby="viewPropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white bg-dark">
                <h5 class="modal-title" id="viewPropertyModalLabel">Property Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewPropertyModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-info"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  Edit Modal --}}
<div class="modal fade" id="editPropertyModal" tabindex="-1" aria-labelledby="editPropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white bg-dark">
                <h5 class="modal-title" id="editPropertyModalLabel">Edit Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="editPropertyModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-warning"></div>
                </div>
            </div>
        </div>
    </div>
</div>
    {{--  Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $properties->links('pagination::bootstrap-5') }}
    </div>
{{-- JS for AJAX Modals and Tooltips --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });

    // View Modal AJAX
    const viewModal = document.getElementById('viewPropertyModal');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (event) {
            const id = event.relatedTarget.getAttribute('data-id');
            const body = document.getElementById('viewPropertyModalBody');
            body.innerHTML = `<div class="text-center py-4"><div class="spinner-border text-info"></div></div>`;
            fetch(`/superadmin/properties/${id}`)
                .then(res => res.text())
                .then(html => body.innerHTML = html)
                .catch(() => body.innerHTML = `<div class="alert alert-danger">Error loading details.</div>`);
        });
    }

    // Edit Modal AJAX
    const editModal = document.getElementById('editPropertyModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const id = event.relatedTarget.getAttribute('data-id');
            const body = document.getElementById('editPropertyModalBody');
            body.innerHTML = `<div class="text-center py-4"><div class="spinner-border text-warning"></div></div>`;
            fetch(`/superadmin/properties/${id}/edit`)
                .then(res => res.text())
                .then(html => body.innerHTML = html)
                .catch(() => body.innerHTML = `<div class="alert alert-danger">Error loading edit form.</div>`);
        });
    }
});
</script>

{{--  Custom CSS --}}
<style>
.table td .bi { font-size: 1rem; }
.pagination { font-size: 0.85rem; }
.page-link { padding: 0.25rem 0.5rem; }
.text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* Stack action buttons on mobile */
@media (max-width: 576px) {
    .table td .btn { display: block; margin-bottom: 0.3rem; }
    .pagination { flex-wrap: wrap; justify-content: center; }
    .modal-dialog { max-width: 95%; margin: 1rem auto; }
}
</style>
@endsection
