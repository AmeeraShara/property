@extends('layouts.app')

@section('content')
{{--  Include Bootstrap CSS and Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @include('superadmin.navbar')
<div class="container mt-5">

        <h2 class="text-center mb-4 text-black fw-bold">All Advertisers</h2>

        {{-- Add New Button --}}
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-dark d-flex align-items-center justify-content-center"
                data-bs-toggle="modal" data-bs-target="#addAdvertiserModal">
                <i class="bi bi-plus-lg me-1"></i> create New
            </button>
        </div>

        {{-- Success & Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Advertisers Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advertisers as $adv)
                        <tr>
                            <td>{{ $adv->id }}</td>
                            <td>{{ $adv->name }}</td>
                            <td>{{ $adv->email }}</td>
                            <td>{{ $adv->phone ?? 'N/A' }}</td>
                            <td>{{ $adv->type }}</td>
                            <td>{{ \Carbon\Carbon::parse($adv->created_at)->format('d M Y') }}</td>
                            <td class="text-center">
                                {{-- Edit --}}
                                <a href="#" class="text-primary me-2 editBtn"
                                    data-id="{{ $adv->id }}"
                                    data-name="{{ $adv->name }}"
                                    data-email="{{ $adv->email }}"
                                    data-phone="{{ $adv->phone }}"
                                    data-type="{{ $adv->type }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Advertiser">
                                    <i class="bi bi-pencil-square fs-6"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('superadmin.advertisers.delete', $adv->id) }}"
                                    method="POST" class="d-inline-block"
                                    onsubmit="return confirm('Delete this advertiser?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Advertiser">
                                        <i class="bi bi-trash fs-6"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No advertisers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">{{ $advertisers->links() }}</div>

        {{-- Add Advertiser Modal --}}
        <div class="modal fade" id="addAdvertiserModal" tabindex="-1" aria-labelledby="addAdvertiserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('superadmin.advertisers.store') }}" method="POST">
                        @csrf
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAdvertiserModalLabel">Add Advertiser</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Email *</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>

                            <div class="mb-3">
                                <label>Type *</label>
                                <select name="type" class="form-control" required>
                                    <option value="Owner" {{ old('type')=='Owner'?'selected':'' }}>Owner</option>
                                    <option value="Agent" {{ old('type')=='Agent'?'selected':'' }}>Agent</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-dark">Add Advertiser</button>
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Advertiser Modal --}}
        <div class="modal fade" id="editAdvertiserModal" tabindex="-1" aria-labelledby="editAdvertiserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="editAdvertiserForm" method="POST">
                        @csrf
                        @method('PATCH') 
                        <input type="hidden" name="id" id="advertiserId">

                        <div class="modal-header">
                            <h5 class="modal-title" id="editAdvertiserModalLabel">Edit Advertiser</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Name *</label>
                                <input type="text" name="name" id="advertiserName" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Email *</label>
                                <input type="email" name="email" id="advertiserEmail" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" id="advertiserPhone" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Type *</label>
                                <select name="type" id="advertiserType" class="form-control" required>
                                    <option value="Owner">Owner</option>
                                    <option value="Agent">Agent</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-dark">Update Advertiser</button>
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
</div>

{{-- JS for modal population --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.editBtn');
    const form = document.getElementById('editAdvertiserForm');

    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const id = this.dataset.id;
            const name = this.dataset.name;
            const email = this.dataset.email;
            const phone = this.dataset.phone;
            const type = this.dataset.type;

            document.getElementById('advertiserId').value = id;
            document.getElementById('advertiserName').value = name;
            document.getElementById('advertiserEmail').value = email;
            document.getElementById('advertiserPhone').value = phone;
            document.getElementById('advertiserType').value = type;

            form.action = `/superadmin/advertisers/update/${id}`;

            const modal = new bootstrap.Modal(document.getElementById('editAdvertiserModal'));
            modal.show();
        });
    });
});
</script>
@endsection
