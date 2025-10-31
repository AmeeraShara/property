@extends('layouts.app')

@section('content')
{{--  Bootstrap CSS --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

@include('superadmin.navbar')

<div class="container mt-5">
    <h2 class="text-center text-black fw-bold mb-4">All Posts</h2>

    {{--  Success Message --}}
    @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    {{--  Filters --}}
    <form method="GET" action="{{ route('superadmin.posts') }}" class="row g-2 mb-3">
        <div class="col-6 col-md-2">
            <select name="offer_type" class="form-select">
                <option value="">Offer Type</option>
                <option value="sale" {{ request('offer_type') == 'sale' ? 'selected' : '' }}>Sale</option>
                <option value="rent" {{ request('offer_type') == 'rent' ? 'selected' : '' }}>Rent</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <select name="property_type" class="form-select">
                <option value="">Property Type</option>
                <option value="house" {{ request('property_type') == 'house' ? 'selected' : '' }}>House</option>
                <option value="apartment" {{ request('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                <option value="land" {{ request('property_type') == 'land' ? 'selected' : '' }}>Land</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <select name="district" class="form-select">
                <option value="">District</option>
                @foreach($districts as $district)
                <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>{{ $district }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-2">
            <select name="city" class="form-select">
                <option value="">City</option>
                @foreach($cities as $city)
                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-2">
            <button type="submit" class="btn btn-dark w-100">Filter</button>
        </div>
    </form>

    {{--  Posts Table --}}
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Offer</th>
                    <th>Type</th>
                    <th>District</th>
                    <th>City</th>
                    <th>Price (LKR)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ ucfirst($post->offer_type) }}</td>
                    <td>{{ ucfirst($post->property_type) }}</td>
                    <td>{{ $post->district }}</td>
                    <td>{{ $post->city }}</td>
                    <td>{{ number_format($post->price, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ 
                            $post->status == 'published' ? 'success' : 
                            ($post->status == 'pending' ? 'warning' : 'dark') 
                        }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </td>
                    <td class="d-flex justify-content-center flex-wrap gap-1">
                        {{-- View --}}
                        <a href="javascript:void(0);" 
                           class="text-info view-post" 
                           data-id="{{ $post->id }}"
                           data-bs-toggle="tooltip" 
                           data-bs-placement="top" 
                           title="View Post">
                           <i class="bi bi-eye fs-5"></i>
                        </a>

                        {{-- Edit --}}
                        <a href="javascript:void(0);" 
                           class="text-warning edit-post" 
                           data-id="{{ $post->id }}"
                           data-bs-toggle="tooltip" 
                           data-bs-placement="top" 
                           title="Edit Post">
                           <i class="bi bi-pencil-square fs-5"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('superadmin.delete', $post->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-link text-danger p-0"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Delete Post">
                                <i class="bi bi-trash fs-5"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No posts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>



</div>

{{--  Post Details Modal --}}
<div class="modal fade" id="postDetailsModal" tabindex="-1" aria-labelledby="postDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-white bg-dark">
                <h5 class="modal-title" id="postDetailsModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalContent" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  Edit Post Modal --}}
<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-dark bg-light">
                <h5 class="modal-title" id="editPostModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editModalContent" class="text-center">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    {{--  Pagination --}}
<div class="d-flex justify-content-center mt-3 overflow-auto">
    {{ $posts->links('pagination::bootstrap-5', ['class' => 'pagination pagination-sm']) }}
</div>
{{--  CSS Tweaks for Mobile --}}
<style>
    .pagination {
        font-size: 0.85rem;
    }
    .page-link {
        padding: 0.25rem 0.5rem;
    }

    /* Mobile adjustments */
    @media (max-width: 576px) {
        .table td a,
        .table td button {
            width: 40px;
            height: 40px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 0;
        }
        .table td i {
            font-size: 0.85rem;
        }
        .table td span.badge {
            font-size: 0.7rem;
            padding: 0.25em 0.3em;
        }
        .table-responsive {
            overflow-x: auto;
        }
    }
@media (max-width: 576px) {
    .pagination {
        font-size: 0.8rem;
        flex-wrap: wrap; /* allow wrapping */
        justify-content: center;
    }

    .page-link {
        padding: 0.25rem 0.5rem;
        min-width: 35px; /* ensure buttons are clickable */
    }
}



</style>

{{--  Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // AJAX load post details
    const viewButtons = document.querySelectorAll('.view-post');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('postDetailsModal'));
            const modalContent = document.getElementById('modalContent');

            modalContent.innerHTML = '<div class="text-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            fetch(`/superadmin/posts/${postId}`)
                .then(response => response.text())
                .then(html => {
                    modalContent.innerHTML = html;
                })
                .catch(() => {
                    modalContent.innerHTML = '<p class="text-danger text-center">Failed to load post details.</p>';
                });

            modal.show();
        });
    });

    // AJAX load edit post form
    const editButtons = document.querySelectorAll('.edit-post');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-id');
            const modal = new bootstrap.Modal(document.getElementById('editPostModal'));
            const modalContent = document.getElementById('editModalContent');

            modalContent.innerHTML = '<div class="text-center my-5"><div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            fetch(`/superadmin/posts/${postId}/edit`)
                .then(response => response.text())
                .then(html => {
                    modalContent.innerHTML = html;
                    initializeEditFormHandlers();
                })
                .catch(error => {
                    modalContent.innerHTML = `<div class="text-center p-4"><p class="text-danger">Failed to load edit form.</p><p class="text-muted small">${error.message}</p><button class="btn btn-dark btn-sm" data-bs-dismiss="modal">Close</button></div>`;
                });

            modal.show();
        });
    });

    function initializeEditFormHandlers() {
        const offerButtons = document.querySelectorAll('.offer-btn');
        offerButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.offer-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('offer_type').value = this.getAttribute('data-label');
            });
        });

        const propertyButtons = document.querySelectorAll('.property-btn:not(.dropdown-toggle)');
        propertyButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.property-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('property_type').value = this.getAttribute('data-label');
            });
        });

        const dropdownItems = document.querySelectorAll('.dropdown-item.property-btn');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                const label = this.getAttribute('data-label');
                document.querySelectorAll('.property-btn').forEach(b => b.classList.remove('active'));
                const dropdownToggle = this.closest('.dropdown').querySelector('.dropdown-toggle');
                dropdownToggle.classList.add('active');
                document.getElementById('property_type').value = label;
            });
        });

        const editForm = document.getElementById('editPostForm');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;

                submitButton.innerHTML = '⏳ Updating...';
                submitButton.disabled = true;

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('editPostModal')).hide();
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Unknown error'));
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                    }
                })
                .catch(error => {
                    alert('Error updating post.');
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                });
            });
        }
    }
});
</script>

@endsection
