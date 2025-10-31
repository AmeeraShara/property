@extends('layouts.app')

@section('content')
{{--  Include Bootstrap CSS and Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

{{--  Navbar --}}
@include('superadmin.navbar')

<div class="container mt-5">
    <h2 class="text-center mb-4 text-black fw-bold">All Inquiries</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Property ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>IP Address</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inquiries as $inquiry)
                    <tr>
                        <td>{{ $inquiry->id }}</td>
                        <td>{{ $inquiry->property_id }}</td>
                        <td>{{ $inquiry->name }}</td>
                        <td>{{ $inquiry->email }}</td>
                        <td>{{ $inquiry->phone }}</td>
                        <td class="text-start">{{ Str::limit($inquiry->message, 60) }}</td>
                        <td>{{ $inquiry->ip_address ?? 'N/A' }}</td>
                        <td>{{ $inquiry->created_at ? $inquiry->created_at->format('Y-m-d H:i') : 'N/A' }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-3">No inquiries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{--  Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $inquiries->links('pagination::bootstrap-5') }}
    </div>
</div>

{{--  View Inquiry Modal --}}
<div class="modal fade" id="viewInquiryModal" tabindex="-1" aria-labelledby="viewInquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewInquiryModalLabel">Inquiry Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewInquiryModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-info"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

    // Handle View Inquiry Modal
    const viewModal = document.getElementById('viewInquiryModal');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const modalBody = document.getElementById('viewInquiryModalBody');
            modalBody.innerHTML = `<div class="text-center py-4"><div class="spinner-border text-info"></div></div>`;

            // Fetch inquiry details
            fetch(`/superadmin/inquiries/${id}`)
                .then(res => res.text())
                .then(html => modalBody.innerHTML = html)
                .catch(() => modalBody.innerHTML = `<div class="alert alert-danger">Error loading inquiry details.</div>`);
        });
    }
});
</script>

{{--  Custom CSS for compact table and pagination --}}
<style>
    .pagination {
        font-size: 0.85rem;
    }
    .page-link {
        padding: 0.25rem 0.5rem;
    }
    .table td .bi {
        font-size: 1rem;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endsection

