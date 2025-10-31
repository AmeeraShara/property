@extends('layouts.app')

@section('content')

<!--  Include Bootstrap CSS & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<div class="container-fluid">
    <div class="row">
@include('superadmin.navbar')


        <!-- Main Content -->
        <main class="col-12 px-2 py-3">
            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <!-- Dashboard Cards -->
            <div class="row g-3">
                <!-- Total Posts -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <a href="{{ route('superadmin.posts') }}" class="text-decoration-none">
                        <div class="card shadow-sm border-0 text-center p-2 small-card">
                            <div class="card-body">
                                <i class="bi bi-file-earmark-text fs-2 mb-2"></i>
                                <h6 class="card-title fw-bold mb-1">Total Posts</h6>
                                <p class="card-text fs-5 fw-bold mb-0">{{ $totalPosts }}</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Users -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <a href="{{ route('superadmin.users') }}" class="text-decoration-none">
                        <div class="card shadow-sm border-0 text-center p-2 small-card">
                            <div class="card-body">
                                <i class="bi bi-people fs-2 mb-2"></i>
                                <h6 class="card-title fw-bold mb-1">Total Users</h6>
                                <p class="card-text fs-5 fw-bold mb-0">{{ $totalUsers }}</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Properties -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <a href="{{ route('superadmin.properties') }}" class="text-decoration-none">
                        <div class="card shadow-sm border-0 text-center p-2 small-card">
                            <div class="card-body">
                                <i class="bi bi-building fs-2 mb-2"></i>
                                <h6 class="card-title fw-bold mb-1">Total Properties</h6>
                                <p class="card-text fs-5 fw-bold mb-0">{{ $totalProperties }}</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Advertisers -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <a href="{{ route('superadmin.advertisers') }}" class="text-decoration-none">
                        <div class="card shadow-sm border-0 text-center p-2 small-card">
                            <div class="card-body">
                                <i class="bi bi-bag-check fs-2 mb-2"></i>
                                <h6 class="card-title fw-bold mb-1">Total Advertisers</h6>
                                <p class="card-text fs-5 fw-bold mb-0">{{ $totalAdvertisers }}</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Inquiries -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <a href="{{ route('superadmin.inquiries') }}" class="text-decoration-none">
                        <div class="card shadow-sm border-0 text-center p-2 small-card">
                            <div class="card-body">
                                <i class="bi bi-question-circle fs-2 mb-2"></i>
                                <h6 class="card-title fw-bold mb-1">Total Inquiries</h6>
                                <p class="card-text fs-5 fw-bold mb-0">{{ $totalInquiries }}</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Subscribers -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                    <a href="{{ route('superadmin.subscribers') }}" class="text-decoration-none">
                        <div class="card shadow-sm border-0 text-center p-2 small-card">
                            <div class="card-body">
                                <i class="bi bi-envelope-paper fs-2 mb-2"></i>
                                <h6 class="card-title fw-bold mb-1">Subscribers</h6>
                                <p class="card-text fs-5 fw-bold mb-0">{{ $totalSubscribers }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Custom Styling -->
            <style>
                .small-card {
                    border-radius: 0.5rem;
                    transition: all 0.3s ease-in-out;
                }

                .small-card:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                }

                .small-card .bi {
                    color: #000 !important;
                    transition: color 0.3s ease-in-out;
                }

                .small-card .bi:hover {
                    color: #333;
                }
            </style>
        </main>
    </div>
</div>

<!-- Include Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
