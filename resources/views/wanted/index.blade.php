@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/wanted.css') }}">
@endpush

@section('content')
<section class="wanted-hero text-center py-5 bg-light">
    <div class="container">
        <h1 class="display-5 fw-bold text-primary">Post Your Wanted Ad</h1>
        <p class="lead text-muted">Looking for a property? Post your wanted ad below and let sellers find you!</p>
    </div>
</section>

<div class="container my-5">

    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div class="alert alert-success text-center mb-4">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ✅ Wanted Ad Form --}}
    <form action="{{ route('wanted.store') }}" method="POST" class="p-4 shadow rounded bg-white">
        @csrf

        <div class="row g-4">
            {{-- 🏷️ Ad Title --}}
            <div class="col-md-12">
                <label for="title" class="form-label fw-semibold">Ad Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter ad title" required>
            </div>

            {{-- Offer Type --}}
            <div class="col-md-6">
                <label for="offer_type" class="form-label fw-semibold">Offer Type</label>
                <select name="offer_type" id="offer_type" class="form-select" required>
                    <option value="">Select offer type</option>
                    <option value="rent">Rent</option>
                    <option value="sale">Sale</option>
                </select>
            </div>

            {{-- Property Type --}}
            <div class="col-md-6">
                <label for="property_type" class="form-label fw-semibold">Property Type</label>
                <select name="property_type" id="property_type" class="form-select" required>
                    <option value="">Select property type</option>
                    <option value="house">House</option>
                    <option value="land">Land</option>
                    <option value="apartment">Apartment</option>
                    <option value="commercial">Commercial</option>
                </select>
            </div>

            {{-- District --}}
            <div class="col-md-6">
                <label for="district" class="form-label fw-semibold">District</label>
                <input type="text" name="district" id="district" class="form-control" placeholder="Enter district" required>
            </div>

            {{-- City --}}
            <div class="col-md-6">
                <label for="city" class="form-label fw-semibold">City</label>
                <input type="text" name="city" id="city" class="form-control" placeholder="Enter city" required>
            </div>

            {{-- Bedrooms --}}
            <div class="col-md-6">
                <label for="bedrooms" class="form-label fw-semibold">Bedrooms</label>
                <input type="number" name="bedrooms" id="bedrooms" class="form-control" placeholder="e.g. 3">
            </div>

            {{-- Bathrooms --}}
            <div class="col-md-6">
                <label for="bathrooms" class="form-label fw-semibold">Bathrooms</label>
                <input type="number" name="bathrooms" id="bathrooms" class="form-control" placeholder="e.g. 2">
            </div>

            {{-- Budget Range --}}
            <div class="col-md-6">
                <label for="budget_min" class="form-label fw-semibold">Budget Min (LKR)</label>
                <input type="number" name="budget_min" id="budget_min" class="form-control" placeholder="e.g. 5000000">
            </div>

            <div class="col-md-6">
                <label for="budget_max" class="form-label fw-semibold">Budget Max (LKR)</label>
                <input type="number" name="budget_max" id="budget_max" class="form-control" placeholder="e.g. 15000000">
            </div>

            {{-- Floor Area Range --}}
            <div class="col-md-6">
                <label for="floor_area_min" class="form-label fw-semibold">Floor Area Min (sqft)</label>
                <input type="number" name="floor_area_min" id="floor_area_min" class="form-control" placeholder="e.g. 1000">
            </div>

            <div class="col-md-6">
                <label for="floor_area_max" class="form-label fw-semibold">Floor Area Max (sqft)</label>
                <input type="number" name="floor_area_max" id="floor_area_max" class="form-control" placeholder="e.g. 2000">
            </div>

            {{-- Requirements --}}
            <div class="col-md-12">
                <label for="requirements" class="form-label fw-semibold">Requirements</label>
                <textarea name="requirements" id="requirements" class="form-control" rows="4" placeholder="Describe what kind of property you are looking for..." required></textarea>
            </div>

            {{-- Contact Details --}}
            <div class="col-md-4">
                <label for="contact_name" class="form-label fw-semibold">Contact Name</label>
                <input type="text" name="contact_name" id="contact_name" class="form-control" placeholder="Your name" required>
            </div>

            <div class="col-md-4">
                <label for="contact_phone" class="form-label fw-semibold">Contact Phone</label>
                <input type="text" name="contact_phone" id="contact_phone" class="form-control" placeholder="Your phone number" required>
            </div>

            <div class="col-md-4">
                <label for="contact_email" class="form-label fw-semibold">Contact Email</label>
                <input type="email" name="contact_email" id="contact_email" class="form-control" placeholder="Your email address">
            </div>

            {{-- Submit Button --}}
            <div class="col-12 text-center mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2">
                    <i class="fas fa-paper-plane"></i> Post Ad
                </button>
            </div>
        </div>
    </form>

    {{-- Existing ads section --}}
    <div class="wanted-ads mt-5">
        <h3 class="text-center text-secondary fw-semibold mb-4">Recently Posted Wanted Ads</h3>

        <div class="row">
            @forelse($wantedAds as $ad)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ $ad->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($ad->requirements, 100) }}</p>
                            <p class="small mb-1"><strong>District:</strong> {{ $ad->district }}</p>
                            <p class="small mb-1"><strong>Budget:</strong> {{ $ad->budget_min ?? 'N/A' }} - {{ $ad->budget_max ?? 'N/A' }} LKR</p>
                            <p class="small mb-0"><strong>Contact:</strong> {{ $ad->contact_name }} | {{ $ad->contact_phone }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No wanted ads found.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $wantedAds->links() }}
        </div>
    </div>
</div>
@endsection
