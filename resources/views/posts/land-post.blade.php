@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/land-post.css') }}">
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

<div class="land-container">
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
            <span class="step-label">Land Details</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">3</div>
            <span class="step-label">Contact Info</span>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('posts.land.store') }}" method="POST">
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
            <h2 class="section-title">Basic Details of the Land</h2>
            <div class="basic-details-grid">
                <div class="field-group">
                    <label for="land_size">Size of Land Area *</label>
                    <input type="number" id="land_size" name="land_size" placeholder="E.g. 35" 
                           min="0" step="0.01" value="{{ old('land_size') }}" required>
                    @error('land_size')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="field-group unit-select">
                    <label for="land_unit">Land Unit *</label>
                    <select id="land_unit" name="land_unit" required>
                        <option value="perches" {{ old('land_unit') == 'perches' ? 'selected' : 'selected' }}>Perches</option>
                        <option value="acres" {{ old('land_unit') == 'acres' ? 'selected' : '' }}>Acres</option>
                        <option value="sq_ft" {{ old('land_unit') == 'sq_ft' ? 'selected' : '' }}>Square Feet</option>
                        <option value="sq_m" {{ old('land_unit') == 'sq_m' ? 'selected' : '' }}>Square Meters</option>
                    </select>
                    @error('land_unit')
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
                    <input type="number" id="price" name="price" placeholder="E.g. 230000" 
                           min="0" value="{{ old('price') }}" required>
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
                        <option value="per_perch" {{ old('price_type') == 'per_perch' ? 'selected' : '' }}>Price Per Perch</option>
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
                    <input type="checkbox" name="features[]" value="near_main_town" 
                           {{ in_array('near_main_town', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">🏙️</span>
                    <span class="label">Near to Main Town</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="near_hospital"
                           {{ in_array('near_hospital', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">🏥</span>
                    <span class="label">Near to Hospital</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="near_school"
                           {{ in_array('near_school', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">🏫</span>
                    <span class="label">Near to School</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="pipe_borne_water"
                           {{ in_array('pipe_borne_water', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">💧</span>
                    <span class="label">Have Pipe Borne Water</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="fiber_internet"
                           {{ in_array('fiber_internet', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">🌐</span>
                    <span class="label">Have Fiber Internet Connection</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="electricity"
                           {{ in_array('electricity', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">⚡</span>
                    <span class="label">Electricity Available</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="main_road"
                           {{ in_array('main_road', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">🛣️</span>
                    <span class="label">Facing Main Road</span>
                </label>
                <label class="feature-checkbox">
                    <input type="checkbox" name="features[]" value="clear_title"
                           {{ in_array('clear_title', $oldFeatures) ? 'checked' : '' }}>
                    <span class="icon">📄</span>
                    <span class="label">Clear Title</span>
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
                           placeholder="E.g. Prime land in Colombo with clear title" 
                           value="{{ old('ad_title') }}" required>
                    @error('ad_title')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field-group full-width">
                    <label for="ad_description">Ad Description *</label>
                    <textarea id="ad_description" name="ad_description" rows="4" 
                              placeholder="Describe your land in detail including location, access roads, nearby facilities, etc."
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