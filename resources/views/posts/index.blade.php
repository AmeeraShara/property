@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/post-ad.css') }}">
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

<div class="post-ad-container">
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
        <div class="step active">
            <div class="step-circle">1</div>
            <span class="step-label">Basic Info</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">2</div>
            <span class="step-label">Details</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">3</div>
            <span class="step-label">Review</span>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('posts.store') }}" method="POST" id="post-ad-form">
        @csrf
        
        <!-- Display Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Offer Type -->
        <div class="form-section">
            <h2 class="section-title">Offer Type</h2>
            <div class="offer-type-buttons">
                <button type="button" class="offer-btn active" data-value="sale">Sale</button>
                <button type="button" class="offer-btn" data-value="rent">Rent</button>
                <button type="button" class="offer-btn" data-value="wanted">Wanted</button>
                <button type="button" class="offer-btn" data-value="professionals">Professionals and Services</button>
            </div>
            <input type="hidden" name="offer_type" id="offer_type" value="sale">
            @error('offer_type')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Property Type -->
        <div class="form-section">
            <h2 class="section-title">Property Type</h2>
            <div class="property-type-buttons">
                <button type="button" class="property-btn" data-value="house">
                    <span class="icon">🏠</span>
                    <span>House</span>
                </button>
                <button type="button" class="property-btn" data-value="apartment">
                    <span class="icon">🏢</span>
                    <span>Apartment</span>
                </button>
                <button type="button" class="property-btn dropdown-btn" data-value="land">
                    <span class="icon">🌳</span>
                    <span>Land</span>
                    <span class="dropdown-arrow">▼</span>
                    <div class="dropdown-menu">
                        <div class="dropdown-item" data-value="bare_land">Bare Land</div>
                        <div class="dropdown-item" data-value="land_with_house">Land with House</div>
                        <div class="dropdown-item" data-value="coconut_land">Coconut Land</div>
                        <div class="dropdown-item" data-value="tea_land">Tea Land</div>
                        <div class="dropdown-item" data-value="rubber_land">Rubber Land</div>
                    </div>
                </button>
                <button type="button" class="property-btn dropdown-btn" data-value="commercial">
                    <span class="icon">🏪</span>
                    <span>Commercial</span>
                    <span class="dropdown-arrow">▼</span>
                    <div class="dropdown-menu">
                        <div class="dropdown-item" data-value="shop_space">Shop Space</div>
                        <div class="dropdown-item" data-value="office_space">Office Space</div>
                        <div class="dropdown-item" data-value="factory">Factory</div>
                        <div class="dropdown-item" data-value="hotel_resort">Hotel/Resort</div>
                        <div class="dropdown-item" data-value="warehouse">Warehouse</div>
                        <div class="dropdown-item" data-value="guest_house">Guest House</div>
                    </div>
                </button>
                <button type="button" class="property-btn" data-value="villa">
                    <span class="icon">🏠</span>
                    <span>Villa</span>
                </button>
                <button type="button" class="property-btn" data-value="room">
                    <span class="icon">🏠</span>
                    <span>Room</span>
                </button>
                <button type="button" class="property-btn" data-value="annex">
                    <span class="icon">🏠</span>
                    <span>Annex</span>
                </button>
            </div>
            
            <!-- Main Property Type Input -->
            <input type="hidden" name="property_type" id="property_type" value="">
            
            <!-- Property Subtype Input (Only for Land and Commercial) -->
            <input type="hidden" name="property_subtype" id="property_subtype" value="">
            
            @error('property_type')
                <span class="error-message">{{ $message }}</span>
            @enderror
            @error('property_subtype')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Location -->
        <div class="form-section">
            <h2 class="section-title">Location</h2>
            <div class="location-fields">
                <div class="field-group">
                    <label for="district">District *</label>
                    <input type="text" id="district" name="district" placeholder="E.g. Colombo" value="{{ old('district') }}" required>
                    @error('district')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field-group">
                    <label for="city">City/Town *</label>
                    <input type="text" id="city" name="city" placeholder="E.g. Piliyandala" value="{{ old('city') }}" required>
                    @error('city')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="field-group full-width">
                <label for="street">Street</label>
                <input type="text" id="street" name="street" placeholder="E.g. Main Street" value="{{ old('street') }}">
                @error('street')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Page Counter and Continue Button -->
        <div class="form-footer">
            <span class="page-counter">1/3</span>
            <button type="submit" class="continue-button">CONTINUE</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('post-ad-form');
    const propertyTypeInput = document.getElementById('property_type');
    const propertySubtypeInput = document.getElementById('property_subtype');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validate property type is selected
        if (!propertyTypeInput.value) {
            isValid = false;
            showError('Please select a property type');
        }
        
        // Validate subtype for land and commercial properties
        if (propertyTypeInput.value === 'land' || propertyTypeInput.value === 'commercial') {
            if (!propertySubtypeInput.value) {
                isValid = false;
                showError('Please select a property subtype');
            }
        }
        
        // Validate required fields
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('error');
                showError(`Please fill in the ${field.previousElementSibling?.textContent || 'required field'}`);
            } else {
                field.classList.remove('error');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
        }
    });
    
    function showError(message) {
        // Remove existing error messages
        const existingError = document.querySelector('.submit-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Create error message element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger submit-error';
        errorDiv.style.marginBottom = '20px';
        errorDiv.innerHTML = `<span class="error-message">${message}</span>`;
        
        // Insert before the form
        form.parentNode.insertBefore(errorDiv, form);
        
        // Scroll to error
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Offer Type buttons
    const offerBtns = document.querySelectorAll('.offer-btn');
    const offerTypeInput = document.getElementById('offer_type');
    
    offerBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            offerBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            offerTypeInput.value = this.dataset.value;
        });
    });
    
    // Property Type buttons with enhanced functionality
    const propertyBtns = document.querySelectorAll('.property-btn');
    
    propertyBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Handle dropdown buttons
            if (this.classList.contains('dropdown-btn')) {
                // Close other dropdowns first
                propertyBtns.forEach(b => {
                    if (b !== this && b.classList.contains('dropdown-btn')) {
                        b.classList.remove('active');
                    }
                });
                
                // Toggle current dropdown
                this.classList.toggle('active');
                return;
            }
            
            // For regular buttons (non-dropdown)
            selectPropertyButton(this);
        });
    });
    
    function selectPropertyButton(button) {
        // Remove active class from all buttons
        propertyBtns.forEach(b => b.classList.remove('active'));
        
        // Add active class to clicked button
        button.classList.add('active');
        
        // Set property type
        const propertyType = button.dataset.value;
        propertyTypeInput.value = propertyType;
        
        // Reset subtype for regular buttons (non-dropdown)
        if (!button.classList.contains('dropdown-btn')) {
            propertySubtypeInput.value = '';
        }
        
        console.log('Selected Property Type:', propertyType);
        console.log('Selected Subtype:', propertySubtypeInput.value);
        
        // Clear any property type errors
        const errorElement = document.querySelector('.error-message');
        if (errorElement && errorElement.textContent.includes('property type')) {
            errorElement.remove();
        }
    }
    
    // Handle dropdown item clicks
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const dropdownMenu = this.closest('.dropdown-menu');
            const dropdownBtn = this.closest('.dropdown-btn');
            
            // Remove selected from all items in this dropdown
            dropdownMenu.querySelectorAll('.dropdown-item').forEach(i => {
                i.classList.remove('selected');
            });
            this.classList.add('selected');
            
            // Update hidden inputs
            const propertyType = dropdownBtn.dataset.value;
            const propertySubtype = this.dataset.value;
            
            propertyTypeInput.value = propertyType;
            propertySubtypeInput.value = propertySubtype;
            
            // Update button text to show selected item
            const textSpan = dropdownBtn.querySelector('span:nth-of-type(2)');
            textSpan.textContent = this.textContent.trim();
            
            // Set button as active and close dropdown
            selectPropertyButton(dropdownBtn);
            dropdownBtn.classList.remove('active'); // Close dropdown
            
            console.log('Selected Property Type:', propertyType);
            console.log('Selected Subtype:', propertySubtype);
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-btn')) {
            document.querySelectorAll('.dropdown-btn').forEach(btn => {
                btn.classList.remove('active');
            });
        }
    });
    
    // Input field validation
    const inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('error');
            }
        });
        
        // Restore old values if form was submitted with errors
        if (this.value) {
            this.classList.remove('error');
        }
    });
    
    // Pre-select property type if there was a validation error
    @if(old('property_type'))
        const oldPropertyType = "{{ old('property_type') }}";
        const oldPropertySubtype = "{{ old('property_subtype') }}";
        
        if (oldPropertyType) {
            // Find and select the property button
            const propertyBtn = document.querySelector(`.property-btn[data-value="${oldPropertyType}"]`);
            if (propertyBtn) {
                if (propertyBtn.classList.contains('dropdown-btn') && oldPropertySubtype) {
                    // For dropdown buttons with subtype
                    const dropdownItem = propertyBtn.querySelector(`.dropdown-item[data-value="${oldPropertySubtype}"]`);
                    if (dropdownItem) {
                        // Select the dropdown item
                        dropdownItem.click();
                    } else {
                        // If subtype not found, just select the main button
                        selectPropertyButton(propertyBtn);
                    }
                } else {
                    // For regular buttons
                    selectPropertyButton(propertyBtn);
                }
            }
        }
    @endif
    
    // Pre-select offer type if there was a validation error
    @if(old('offer_type'))
        const oldOfferType = "{{ old('offer_type') }}";
        const offerBtn = document.querySelector(`.offer-btn[data-value="${oldOfferType}"]`);
        if (offerBtn) {
            offerBtn.click();
        }
    @endif
});
</script>
@endsection