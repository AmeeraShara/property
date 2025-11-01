@extends('layouts.app')

@section('content')
{{-- Bootstrap CSS & Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

@include('superadmin.navbar')

<div class="container mt-4">
        <h1 class="mb-4 text-center fw-bold text-black">Premium Packages</h1>
        <!-- Add New Button -->
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-dark d-flex align-items-center justify-content-center"
                data-bs-toggle="modal" data-bs-target="#addAdvertiserModal">
                <i class="bi bi-plus-lg me-1"></i> create New
            </button>
        </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered text-center">
            <thead class="table-dark">
            <tr>
                <th>Duration (Months)</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($packages as $package)
            <tr>
                <td>{{ $package->duration }}</td>
                <td>{{ $package->price }}</td>
                <td class="text-center">
                    {{-- Edit --}}
                    <button type="button"
                            class="btn btn-link text-warning p-0 me-2"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $package->id }}"
                            title="Edit Package">
                        <i class="bi bi-pencil-square fs-5"></i>
                    </button>

                    {{-- Delete --}}
                    <form action="{{ route('superadmin.premium.destroy', $package->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this package?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-danger p-0" title="Delete Package">
                            <i class="bi bi-trash fs-5"></i>
                        </button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal (Centered) -->
            <div class="modal fade" id="editModal{{ $package->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('superadmin.premium.update', $package->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Package</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Duration (Months)</label>
                                    <input type="number" name="duration" class="form-control" value="{{ $package->duration }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Price</label>
                                    <input type="number" step="0.01" name="price" class="form-control" value="{{ $package->price }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-dark text-white">Save Changes</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>

<!-- Create Modal (Centered) -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('superadmin.premium.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Duration (Months)</label>
                        <input type="number" name="duration" class="form-control" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label>Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark text-white">Create Package</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
