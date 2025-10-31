@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/commercial-post.css') }}">
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

<div class="commercial-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('dashboard.index') }}">Dashboard</a>
        <span class="separator">></span>
        <span>Post Ad</span>
    </div>

    <!-- Back to List Button -->
    <div class="back-button-container">
        <a href="{{ url()->previous() }}" class="back-button">
            <span>←</span> Back to List
        </a>
    </div>

    <!-- Progress Steps -->
    <div class="progress-steps">
        <div class="step completed">
            <div class="step-circle">1</div>
            <span class="step-label">Basic Info</span>
        </div>
        <div class="step-line"></div>
        <div class="step active">
            <div class="step-circle">2</div>
            <span class="step-label">Commercial Details</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">3</div>
            <span class="step-label">Contact Info</span>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('posts.commercial.store') }}" method="POST">
        @csrf
        
        <!-- Hidden fields for property type and subtype -->
        <input type="hidden" name="property_type" value="{{ Session::get('post_step1.property_type') }}">
        <input type="hidden" name="property_subtype" value="{{ Session::get('post_step1.property_subtype') }}">
        
        <!-- Display Property Type Info -->
        <div class="property-info-banner">
            <strong>Property Type:</strong> {{ Session::get('post_step1.property_type') }} - 
            {{ Session::get('post_step1.property_subtype') }}
        </div>

        <!-- Basic Details -->
        <div class="form-section">
            <h2 class="section-title">Basic Details of the Commercial Property</h2>
            <div class="basic-details-grid">
                <div class="field-group">
                    <label for="commercial_type">Commercial Type *</label>
                    <input type="text" id="commercial_type_display" 
                           value="{{ Session::get('post_step1.property_subtype') }}" 
                           class="readonly-field" readonly>
                    <input type="hidden" name="commercial_type" value="{{ Session::get('post_step1.property_subtype') }}">
                    <small class="field-note">Selected from previous step</small>
                </div>
                
                <div class="field-group">
                    <label for="floor_area">Floor Area (sq ft) *</label>
                    <input type="number" id="floor_area" name="floor_area" 
                           placeholder="E.g. 1200" min="0" step="0.01" 
                           value="{{ old('floor_area') }}" required>
                    @error('floor_area')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="field-group">
                    <label for="floor_level">Floor Level</label>
                    <input type="text" id="floor_level" name="floor_level" 
                           placeholder="E.g. Ground Floor, 1st Floor" 
                           value="{{ old('floor_level') }}">
                    @error('floor_level')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Price Details -->
        <div class="form-section">
            <h2 class="section-title">Price Details</h2>
            <div class="price-details-grid">
                <div class="field-group">
                    <label for="price">Expected Price in Rs *</label>
                    <input type="number" id="price" name="price" 
                           placeholder="E.g. 5000000" min="0" 
                           value="{{ old('price') }}" required>
                    @error('price')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field-group">
                    <label for="price_type">Price Type *</label>
                    <select id="price_type" name="price_type" required>
                        <option value="">Select</option>
                        <option value="fixed" {{ old('price_type') == 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                        <option value="negotiable" {{ old('price_type') == 'negotiable' ? 'selected' : '' }}>Negotiable</option>
                        <option value="per_sqft" {{ old('price_type') == 'per_sqft' ? 'selected' : '' }}>Price Per Sq Ft</option>
                        <option value="monthly_rent" {{ old('price_type') == 'monthly_rent' ? 'selected' : '' }}>Monthly Rent</option>
                    </select>
                    @error('price_type')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Property Features -->
        <div class="form-section">
            <h2 class="section-title">Property Features</h2>
            <div class="features-grid">
                @php
                    $oldFeatures = old('features', []);
                @endphp
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="parking"
                           {{ in_array('parking', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">🚗</span>
                    <span class="label">Parking Available</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="three_phase_electricity"
                           {{ in_array('three_phase_electricity', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">⚡</span>
                    <span class="label">3 Phase Electricity</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="security"
                           {{ in_array('security', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">🛡️</span>
                    <span class="label">Security System</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="air_conditioning"
                           {{ in_array('air_conditioning', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">❄️</span>
                    <span class="label">Air Conditioning</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="lift"
                           {{ in_array('lift', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">⬆️</span>
                    <span class="label">Lift/Elevator</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="conference_room"
                           {{ in_array('conference_room', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">📊</span>
                    <span class="label">Conference Room</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="reception"
                           {{ in_array('reception', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">🏛️</span>
                    <span class="label">Reception Area</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="24hr_security"
                           {{ in_array('24hr_security', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">🕐</span>
                    <span class="label">24 Hours Security</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="furnished"
                           {{ in_array('furnished', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">🛋️</span>
                    <span class="label">Fully Furnished</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="internet"
                           {{ in_array('internet', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">🌐</span>
                    <span class="label">High Speed Internet</span>
                </label>
            </div>
            @error('features')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Ad Details -->
        <div class="form-section">
            <h2 class="section-title">Ad Details</h2>
            <div class="ad-details-grid">
                <div class="field-group full-width">
                    <label for="ad_title">Ad Title *</label>
                    <input type="text" id="ad_title" name="ad_title" 
                           placeholder="E.g. Prime commercial space in city center" 
                           value="{{ old('ad_title') }}" required>
                    @error('ad_title')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field-group full-width">
                    <label for="ad_description">Ad Description *</label>
                    <textarea id="ad_description" name="ad_description" rows="4" 
                              placeholder="Describe your commercial property including location, facilities, business potential, etc."
                              required>{{ old('ad_description') }}</textarea>
                    @error('ad_description')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
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
        let isValid = true;
        
        // Validate required fields
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('error');
            } else {
                field.classList.remove('error');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill all required fields');
        }
    });
});
</script>
@endsection