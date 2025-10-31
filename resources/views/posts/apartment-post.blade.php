@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/apartment-post.css') }}">
@endpush

@section('content')
<!-- Blue Navbar -->
<nav class="blue-navbar">
    <div class="container">
           <a href="{{ route('sales.index') }}" class="nav-link">Sales</a>
        <a href="{{ route('rent.index') }}" class="nav-link">Rentals</a>
        <a href="{{ route('land.index') }}" class="nav-link">Land</a>
            <a href="#" class="nav-link">Our Services</a>
            <a href="#" class="nav-link">Invest</a>
            <a href="#" class="nav-link">Market Insight</a>
            <a href="#" class="nav-link">Wanted</a>
          <a href="#" class="nav-link">Find Agent</a>
    </div>
</nav>
<div class="apartment-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="">Dashboard</a>
        <span class="separator">></span>
        <span>Post Ad</span>
    </div>

    <!-- Back to List Button -->
    <div class="back-button-container">
        <a href="" class="back-button">
            <span>←</span> Back to List
        </a>
    </div>
    
    <!-- Progress Steps -->
    <div class="progress-steps">
        <div class="step active">
            <div class="step-circle">1</div>
        </div>
        <div class="step-line"></div>
        <div class="step active">
            <div class="step-circle">2</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">3</div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('posts.store.apartment') }}" method="POST">
        @csrf
        
        <!-- Basic Details -->
        <div class="form-section">
            <h2 class="section-title">Basic Details of the Apartment</h2>
            <div class="basic-details-grid">
                <div class="field-group">
                    <label for="bedrooms">Number of Bedrooms</label>
                    <input type="number" id="bedrooms" name="bedrooms" placeholder="E.g. 3" min="0" required>
                </div>
                <div class="field-group">
                    <label for="bathrooms">Number of Bathrooms</label>
                    <input type="number" id="bathrooms" name="bathrooms" placeholder="E.g. 3" min="0" required>
                </div>
                <div class="field-group">
                    <label for="floor_area">Floor Area</label>
                    <input type="number" id="floor_area" name="floor_area" placeholder="E.g. 1234" min="0" required>
                    <span class="unit">sqft</span>
                </div>
            </div>
        </div>

        <!-- Price Details -->
        <div class="form-section">
            <h2 class="section-title">Price Details</h2>
            <div class="price-details-grid">
                <div class="field-group">
                    <label for="price">Expected Price in Rs</label>
                    <input type="number" id="price" name="price" placeholder="E.g. 230000" min="0" required>
                </div>
                <div class="field-group">
                    <label for="price_type">Price Type</label>
                    <select id="price_type" name="price_type" required>
                        <option value="">Select</option>
                        <option value="fixed">Fixed Price</option>
                        <option value="negotiable">Negotiable</option>
                        <option value="call">Call for Price</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Property Features -->
        <div class="form-section">
            <h2 class="section-title">Property Features</h2>
            <div class="features-grid">
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="ac_rooms">
                    <span class="icon">❄️</span>
                    <span class="label">AC Rooms</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="swimming_pool">
                    <span class="icon">🏊</span>
                    <span class="label">Swimming Pool</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="attached_toilets">
                    <span class="icon">🚽</span>
                    <span class="label">Attached Toilets</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="hot_water">
                    <span class="icon">🔥</span>
                    <span class="label">Hot Water</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="indoor_garden">
                    <span class="icon">🌿</span>
                    <span class="label">Indoor Garden</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="roof_top_garden">
                    <span class="icon">🌳</span>
                    <span class="label">Roof Top Garden</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="main_line_water">
                    <span class="icon">💧</span>
                    <span class="label">Main Line Water</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="brand_new">
                    <span class="icon">✨</span>
                    <span class="label">Brand New</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="servant_room">
                    <span class="icon">🛏️</span>
                    <span class="label">Servant Room</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="servant_toilet">
                    <span class="icon">🚻</span>
                    <span class="label">Servant Toilet</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="gym">
                    <span class="icon">💪</span>
                    <span class="label">Gym</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="kids_play_area">
                    <span class="icon">🎾</span>
                    <span class="label">Kids Play Area</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="24hr_security">
                    <span class="icon">🛡️</span>
                    <span class="label">24 Hours Security</span>
                </label>
            </div>
        </div>

        <!-- Ad Details -->
        <div class="form-section">
            <h2 class="section-title">Ad Details</h2>
            <div class="ad-details-grid">
                <div class="field-group full-width">
                    <label for="ad_title">Ad Title</label>
                    <input type="text" id="ad_title" name="ad_title" placeholder="E.g. Brand new apartment" required>
                </div>
                <div class="field-group full-width">
                    <label for="ad_description">Ad Description</label>
                    <textarea id="ad_description" name="ad_description" rows="4" placeholder="E.g. Brand new apartment with modern amenities" required></textarea>
                </div>
            </div>
        </div>

        <!-- Form Footer -->
        <div class="form-footer">
            <button type="button" class="back-button" onclick="window.history.back()">BACK</button>
            <span class="page-counter">2/3</span>
            <button type="submit" class="continue-button">CONTINUE</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const bedrooms = document.getElementById('bedrooms').value;
        const bathrooms = document.getElementById('bathrooms').value;
        const floorArea = document.getElementById('floor_area').value;
        const price = document.getElementById('price').value;
        const priceType = document.getElementById('price_type').value;
        const adTitle = document.getElementById('ad_title').value;
        const adDescription = document.getElementById('ad_description').value;

        if (!bedrooms || !bathrooms || !floorArea || !price || !priceType || !adTitle || !adDescription) {
            e.preventDefault();
            alert('Please fill all required fields');
            return false;
        }
    });
});
</script>
@endsection