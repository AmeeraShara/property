@extends('layouts.app')

@section('content')
{{--  Include Bootstrap CSS and Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

{{--  Include the Super Admin Navbar --}}
@include('superadmin.navbar')

<div class="container mt-5">
    <h2 class="mb-4 text-center fw-bold text-black">All Registered Users</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{--  Make table horizontally scrollable on small screens --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>User Type</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th width="120px" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td><span class="badge bg-dark text-white">{{ ucfirst($user->user_type) }}</span></td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td><span class="badge bg-dark">{{ ucfirst($user->role) }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>
                    <td class="text-center">
                        {{-- View Button --}}
                        <button type="button" 
                                class="btn btn-link text-primary p-0 me-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#viewUserModal"
                                data-user-id="{{ $user->id }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="View User">
                            <i class="bi bi-eye fs-6"></i>
                        </button>

                        {{-- Edit Button --}}
                        <button type="button" 
                                class="btn btn-link text-warning p-0 me-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editUserModal"
                                data-user-id="{{ $user->id }}"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="Edit User">
                            <i class="bi bi-pencil-square fs-6"></i>
                        </button>

                        {{-- Delete --}}
                        <form action="{{ route('superadmin.users.destroy', $user->id) }}" 
                              method="POST" 
                              class="d-inline" 
                              onsubmit="return confirm('Are you sure to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-link text-danger p-0" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="Delete User">
                                <i class="bi bi-trash fs-6"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{--  Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- View User Modal --}}
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewUserModalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit User Modal --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editUserModalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  Initialize Bootstrap Tooltips and Handle Modal Events --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // View User Modal
    const viewUserModal = document.getElementById('viewUserModal');
    if (viewUserModal) {
        viewUserModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');

            fetch(`/superadmin/users/${userId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('viewUserModalBody').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading user details:', error);
                    document.getElementById('viewUserModalBody').innerHTML = 
                        '<div class="alert alert-danger">Error loading user details</div>';
                });
        });

        viewUserModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('viewUserModalBody').innerHTML = 
                '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        });
    }

    // Edit User Modal
    const editUserModal = document.getElementById('editUserModal');
    if (editUserModal) {
        editUserModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');

            fetch(`/superadmin/users/${userId}/edit`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('editUserModalBody').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading edit form:', error);
                    document.getElementById('editUserModalBody').innerHTML = 
                        '<div class="alert alert-danger">Error loading edit form</div>';
                });
        });

        // Clear modal on hide
        editUserModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('editUserModalBody').innerHTML = 
                '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        });
    }
});
</script>

{{--  Custom CSS for responsiveness and compact design --}}
<style>
/* Pagination smaller */
.pagination {
    font-size: 0.85rem;
}
.page-link {
    padding: 0.25rem 0.5rem;
}

/* Table icons smaller */
.table td .bi {
    font-size: 1rem;
}

.user-detail-row {
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}
.user-detail-label {
    font-weight: bold;
    color: #555;
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

@media (max-width: 576px) {
    .table td .btn {
        display: block;
        margin-bottom: 0.3rem;
    }
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .modal-dialog {
        max-width: 95%;
        margin: 1rem auto;
    }
}
</style>

@endsection
