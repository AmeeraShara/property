@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home-details.css') }}">
@endpush

@section('content')
<div class="home-details-container">
    <!-- Blue Navbar -->
    <nav class="blue-navbar">
        <div class="container">
            <div class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="nav-menu" id="navMenu">
                <a href="{{ route('sales.index') }}" class="nav-link">Sales</a>
                <a href="{{ route('rent.index') }}" class="nav-link">Rentals</a>
                <a href="{{ route('land.index') }}" class="nav-link">Land</a>
                <a href="#" class="nav-link">Our Services</a>
                <a href="#" class="nav-link">Invest</a>
                <a href="#" class="nav-link">Market Insight</a>
                <a href="#" class="nav-link">Wanted</a>
                <a href="#" class="nav-link">Find Agent</a>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Home</a> 
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('sales.index') }}" class="breadcrumb-link">Sales</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ ucfirst($property->property_type) }}</span>
        </div>
    </div>

    <div class="container">
        <div class="gallery-section">
            @php
                $propertyImages = $property->images_array ?? [];
                $firstImage = $propertyImages[0] ?? null;
            @endphp

            {{-- Main Image --}}
            @if($firstImage)
                <div class="main-image">
                    <img src="{{ asset('storage/' . $firstImage) }}" 
                         alt="{{ $property->ad_title ?? 'Property Image' }}" 
                         id="mainImage">
                </div>
            @else
                <div class="no-image-placeholder">
                    <div class="no-image-content">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                        <p>No property image available</p>
                    </div>
                </div>
            @endif

            {{-- Thumbnails --}}
            @if(!empty($propertyImages))
                <div class="thumbnail-grid">
                    @foreach($propertyImages as $index => $image)
                        <div class="thumbnail {{ $index === 0 ? 'active' : '' }}" 
                             data-image-index="{{ $index }}"
                             role="button"
                             tabindex="0"
                             aria-label="View image {{ $index + 1 }}">
                            <img src="{{ asset('storage/' . $image) }}" 
                                 alt="Property Thumbnail {{ $index + 1 }}"
                                 loading="lazy">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Property Details Section -->
        <div class="details-section">
            <!-- Left Column -->
            <div class="details-left">
                <!-- Title and Location -->
                <div class="property-header">
                    <div class="property-header-top">
                        <h1 class="property-title">{{ $property->ad_title ?? 'Property for Sale' }}</h1>

                        <!-- Save & Share Buttons -->
                        <div class="property-actions">
                            <button class="action-btn save-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
                                </svg>
                                SAVE
                            </button>
                            <button class="action-btn share-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="18" cy="5" r="3"></circle>
                                    <circle cx="6" cy="12" r="3"></circle>
                                    <circle cx="18" cy="19" r="3"></circle>
                                    <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                    <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                                </svg>
                                SHARE
                            </button>
                        </div>
                    </div>

                    <div class="property-location">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>{{ $property->street ?? '' }}, {{ $property->city ?? '' }}, {{ $property->district ?? 'Location not specified' }}</span>
                    </div>

                    <div class="property-badges">
                        @if($property->bedrooms)
                            <span class="badge-item">🏠 {{ $property->bedrooms }} Bedrooms</span>
                        @endif
                        @if($property->bathrooms)
                            <span class="badge-item">🛁 {{ $property->bathrooms }} Washrooms</span>
                        @endif
                        @if($property->floor_area)
                            <span class="badge-item">📏 {{ number_format($property->floor_area) }} sqft</span>
                        @endif
                        @if($property->land_area)
                            <span class="badge-item">🌳 {{ number_format($property->land_area) }} {{ $property->land_unit ?? 'Perches' }}</span>
                        @endif
                    </div>
                </div>

                <!-- Price Section -->
                <div class="price-section">
                    <div class="price-info">
                        <span class="price-amount">Rs. {{ number_format($property->price ?? 0, 2) }}</span>
                        <span class="price-label">
                            @if($property->price_type === 'per_month')
                                / Month
                            @elseif($property->price_type === 'per_year')
                                / Year
                            @else
                                Fixed Price
                            @endif
                        </span>
                    </div>
                </div>

                <form action="#" method="POST" class="overview-form">
                    @csrf
                    <h2 class="section-title">Overview</h2>
                    <div class="overview-grid">
                        <div class="overview-item">
                            <span class="overview-label">Property Type</span>
                            <span class="overview-value">{{ ucfirst($property->property_type ?? 'Property') }}</span>
                        </div>
                        @if($property->bedrooms)
                        <div class="overview-item">
                            <span class="overview-label">Bedrooms</span>
                            <span class="overview-value">{{ $property->bedrooms }}</span>
                        </div>
                        @endif
                        @if($property->bathrooms)
                        <div class="overview-item">
                            <span class="overview-label">Bathrooms</span>
                            <span class="overview-value">{{ $property->bathrooms }}</span>
                        </div>
                        @endif
                        @if($property->floor_area)
                        <div class="overview-item">
                            <span class="overview-label">Floor Area</span>
                            <span class="overview-value">{{ number_format($property->floor_area) }} sqft</span>
                        </div>
                        @endif
                        @if($property->land_area)
                        <div class="overview-item">
                            <span class="overview-label">Area of Land</span>
                            <span class="overview-value">{{ number_format($property->land_area) }} {{ $property->land_unit ?? 'Perches' }}</span>
                        </div>
                        @endif
                    </div>
                </form>

                <!-- Property Details Section -->
                <div class="property-details-section">
                    <h2 class="section-title">Property Details</h2>
                    <p class="details-description">
                        {!! nl2br(e($property->ad_description ?? 'No description available.')) !!}
                    </p>
                </div>

                <!-- Property Features Section -->
                @php
                    $propertyFeatures = $property->features_array;
                    $featuresCount = count($propertyFeatures);
                @endphp

                @if($featuresCount > 0)
                <div class="features-section">
                    <h2 class="section-title">Property Features</h2>
                    <div class="features-grid">
                        @foreach($propertyFeatures as $feature)
                            @if(!empty(trim($feature)))
                            <div class="feature-item">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                                <span>{{ ucfirst(trim($feature)) }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="feature-underline"></div>
                </div>
                @else
                <div class="features-section">
                    <h2 class="section-title">Property Features</h2>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; text-align: center;">
                        <p style="margin: 0; color: #6c757d;">No features specified for this property.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Contact Section (Mobile & Tablet) -->
        <div class="contact-section-fullwidth">
            <div class="contact-card">
                <h2 class="contact-title">Contact Advertiser</h2>
                
                <div class="advertiser-info">
                    <div class="advertiser-avatar">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="advertiser-details">
                        <span class="advertiser-name">{{ $property->contact_name ?? ($property->user->name ?? 'Property Owner') }}</span>
                        <span class="advertiser-badge">
                            @if($property->user && $property->user->role)
                                {{ $property->user->role }}
                            @else
                                {{ $property->offer_type === 'sale' ? 'Seller' : ($property->offer_type === 'rent' ? 'Landlord' : 'Owner') }}
                            @endif
                        </span>
                    </div>
                </div>

                <div class="contact-form-wrapper">
                    <div class="contact-left">
                        <div class="contact-buttons">
                            <button class="btn-phone" onclick="window.location.href='tel:{{ $property->contact_phone }}'">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                {{ $property->contact_phone ?? 'Contact for Number' }}
                            </button>
                            @if($property->whatsapp_phone)
                            <button class="btn-whatsapp" onclick="window.open('https://wa.me/94{{ ltrim($property->whatsapp_phone, '0') }}', '_blank')">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                                WhatsApp
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="contact-right">
                        <form class="contact-form" id="contactFormMobile">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            
                            <input type="text" class="form-input" name="name" placeholder="Your Name" required>
                            <input type="email" class="form-input" name="email" placeholder="Your Email Address" required>
                            <input type="tel" class="form-input" name="phone" placeholder="Your Phone Number" required>
                            
                            <textarea class="form-textarea" name="message" placeholder="Enter Your Message" rows="4" required>
I'm interested in this property: {{ $property->ad_title }}
Property ID: {{ $property->id }}
                            </textarea>
                            
                            <button type="submit" class="btn-send" id="submitBtnMobile">
                                <span id="btnTextMobile">SEND MESSAGE</span>
                                <div id="btnSpinnerMobile" class="spinner" style="display: none;"></div>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="post-info">
                    Posted: {{ $property->created_at->diffForHumans() }}
                    @if($property->is_urgent)
                        <span class="urgent-badge">URGENT</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Contact Form (Desktop) -->
        <div class="details-right">
            <div class="contact-card">
                <h2 class="contact-title">Contact Advertiser</h2>
                
                <div class="advertiser-info">
                    <div class="advertiser-avatar">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="advertiser-details">
                        <span class="advertiser-name">{{ $property->contact_name ?? ($property->user->name ?? 'Property Owner') }}</span>
                        <span class="advertiser-badge">
                            @if($property->user && $property->user->role)
                                {{ $property->user->role }}
                            @else
                                {{ $property->offer_type === 'sale' ? 'Seller' : ($property->offer_type === 'rent' ? 'Landlord' : 'Owner') }}
                            @endif
                        </span>
                    </div>
                </div>

                <div class="contact-form-wrapper">
                    <div class="contact-left">
                        <div class="contact-buttons">
                            <button class="btn-phone" onclick="window.location.href='tel:{{ $property->contact_phone }}'">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                {{ $property->contact_phone ?? 'Contact for Number' }}
                            </button>
                            @if($property->whatsapp_phone)
                            <button class="btn-whatsapp" onclick="window.open('https://wa.me/94{{ ltrim($property->whatsapp_phone, '0') }}', '_blank')">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                                WhatsApp
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="contact-right">
                        <form class="contact-form" id="contactFormDesktop">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            
                            <input type="text" class="form-input" name="name" placeholder="Your Name" required>
                            <input type="email" class="form-input" name="email" placeholder="Your Email Address" required>
                            <input type="tel" class="form-input" name="phone" placeholder="Your Phone Number" required>
                            
                            <textarea class="form-textarea" name="message" placeholder="Enter Your Message" rows="4" required>
I'm interested in this property: {{ $property->ad_title }}
Property ID: {{ $property->id }}
                            </textarea>
                            
                            <button type="submit" class="btn-send" id="submitBtnDesktop">
                                <span id="btnTextDesktop">SEND MESSAGE</span>
                                <div id="btnSpinnerDesktop" class="spinner" style="display: none;"></div>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="post-info">
                    Posted: {{ $property->created_at->diffForHumans() }}
                    @if($property->is_urgent)
                        <span class="urgent-badge">URGENT</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Similar Properties Section -->
    @php
        $similarCount = $similarProperties ? $similarProperties->count() : 0;
    @endphp

    @if($similarCount > 0)
    <div class="similar-properties-section">
        <h2 class="section-title">Similar Properties</h2>
        <div class="similar-properties-grid">
            @foreach($similarProperties as $similarProperty)
            @php
                $images = $similarProperty->images ?? [];
                $firstImage = null;
                
                if (!empty($images) && is_array($images) && !empty($images[0])) {
                    $firstImage = asset('storage/' . $images[0]);
                } else {
                    $firstImage = asset('images/property2.jpg');
                }
            @endphp
            
            <div class="similar-property-card">
                <div class="similar-image-wrapper">
                    <img src="{{ $firstImage }}" 
                         alt="{{ $similarProperty->ad_title ?? 'Similar Property' }}"
                         onerror="this.src='{{ asset('images/property2.jpg') }}'">
                    <span class="similar-badge">{{ $similarProperty->district ?? 'Location' }}</span>
                    <button class="similar-favorite" data-property-id="{{ $similarProperty->id }}">★</button>
                </div>
                <div class="similar-content">
                    <div class="similar-meta">
                        <span class="similar-sqft">
                            @if($similarProperty->property_type === 'land')
                                {{ $similarProperty->land_area ? number_format($similarProperty->land_area) . ' ' . ($similarProperty->land_unit ?? 'Perches') : 'Size N/A' }}
                            @else
                                {{ $similarProperty->floor_area ? number_format($similarProperty->floor_area) . ' sqft' : 'Size N/A' }}
                            @endif
                        </span>
                        <span class="similar-type">{{ ucfirst($similarProperty->property_type ?? 'Property') }}</span>
                    </div>
                    <div class="similar-price">
                        @if($similarProperty->price)
                            Rs. {{ number_format($similarProperty->price) }} 
                            <span class="price-period">
                                @if($similarProperty->price_type === 'per_month')
                                    /month
                                @elseif($similarProperty->price_type === 'per_year')
                                    /year
                                @endif
                            </span>
                        @else
                            <span class="price-on-request">Price on Request</span>
                        @endif
                    </div>
                    <h4 class="similar-title">
                        <a href="{{ route('sales.home-details', $similarProperty->id) }}">
                            {{ $similarProperty->ad_title ?? 'Property for Sale' }}
                        </a>
                    </h4>
                    <p class="similar-description">
                        {{ Str::limit($similarProperty->ad_description ?? 'No description available', 80) }}
                    </p>
                    <div class="similar-features">
                        @if($similarProperty->bedrooms)
                            <span class="feature">🏠 {{ $similarProperty->bedrooms }} Bed</span>
                        @endif
                        @if($similarProperty->bathrooms)
                            <span class="feature">🛁 {{ $similarProperty->bathrooms }} Bath</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="similar-properties-section">
        <h2 class="section-title">Similar Properties</h2>
        <div class="no-similar-properties">
            <p>No similar properties found at the moment.</p>
            <a href="{{ route('sales.index') }}" class="btn-view-all">View All Properties</a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation Toggle
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
        });
    }

    // Contact form submission for both mobile and desktop
    const contactForms = [
        { form: 'contactFormDesktop', btn: 'submitBtnDesktop', text: 'btnTextDesktop', spinner: 'btnSpinnerDesktop' },
        { form: 'contactFormMobile', btn: 'submitBtnMobile', text: 'btnTextMobile', spinner: 'btnSpinnerMobile' }
    ];

    contactForms.forEach(formConfig => {
        const contactForm = document.getElementById(formConfig.form);
        const submitBtn = document.getElementById(formConfig.btn);
        const btnText = document.getElementById(formConfig.text);
        const btnSpinner = document.getElementById(formConfig.spinner);
        
        if (contactForm) {
            contactForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Change button state
                submitBtn.disabled = true;
                btnText.textContent = 'SENDING...';
                btnSpinner.style.display = 'inline-block';
                
                try {
                    const formData = new FormData(this);
                    
                    const response = await fetch('{{ route("sales.contact-inquiry") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        showProfessionalAlert('success', 'Message Sent Successfully!', 'Thank you for your inquiry. We will contact you within 24 hours.');
                        contactForm.reset();
                    } else {
                        showProfessionalAlert('error', 'Message Not Sent', result.message || 'Failed to send message. Please try again.');
                    }
                    
                } catch (error) {
                    console.error('Error:', error);
                    showProfessionalAlert('error', 'Network Error', 'Please check your connection and try again.');
                } finally {
                    // Reset button state
                    submitBtn.disabled = false;
                    btnText.textContent = 'SEND MESSAGE';
                    btnSpinner.style.display = 'none';
                }
            });
        }
    });

    // Professional Alert Display Function
    function showProfessionalAlert(type, title, message) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.professional-alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `professional-alert professional-alert-${type}`;
        
        const icon = type === 'success' ? 
            `<svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>` :
            `<svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>`;
        
        alertDiv.innerHTML = `
            <div class="alert-content">
                ${icon}
                <div class="alert-text">
                    <div class="alert-title">${title}</div>
                    <div class="alert-message">${message}</div>
                </div>
            </div>
            <button class="alert-close" onclick="this.parentElement.remove()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Save/Favorite button functionality
    const saveButtons = document.querySelectorAll('.save-btn');
    saveButtons.forEach(btn => {
        btn.addEventListener('click', async function() {
            const propertyId = {{ $property->id }};
            const isSaved = this.classList.contains('saved');
            
            try {
                const response = await fetch('{{ route("sales.save-property") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        property_id: propertyId,
                        action: isSaved ? 'remove' : 'add'
                    })
                });

                const result = await response.json();

                if (result.success) {
                    if (isSaved) {
                        this.classList.remove('saved');
                        this.innerHTML = `
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
                            </svg>
                            SAVE
                        `;
                        showProfessionalAlert('success', 'Property Removed', 'Property has been removed from your favorites.');
                    } else {
                        this.classList.add('saved');
                        this.innerHTML = `
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"></path>
                            </svg>
                            SAVED
                        `;
                        showProfessionalAlert('success', 'Property Saved', 'Property has been added to your favorites!');
                    }
                } else {
                    showProfessionalAlert('error', 'Save Failed', result.message || 'Failed to save property. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                showProfessionalAlert('error', 'Authentication Required', 'Please login to save properties.');
            }
        });
    });

    // Share button functionality
    const shareButtons = document.querySelectorAll('.share-btn');
    shareButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const propertyTitle = '{{ $property->ad_title }}';
            const propertyUrl = window.location.href;
            const shareText = `Check out this property: ${propertyTitle}`;
            
            if (navigator.share) {
                // Use Web Share API if available (mobile devices)
                navigator.share({
                    title: propertyTitle,
                    text: shareText,
                    url: propertyUrl
                })
                .then(() => showProfessionalAlert('success', 'Shared Successfully', 'Property shared successfully!'))
                .catch(err => {
                    console.log('Error sharing:', err);
                    showProfessionalShareModal(propertyTitle, propertyUrl);
                });
            } else {
                // Fallback for desktop browsers
                showProfessionalShareModal(propertyTitle, propertyUrl);
            }
        });
    });

    // Image gallery functionality
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('mainImage');
    
    if (thumbnails.length > 0 && mainImage) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Remove active class from all thumbnails
                thumbnails.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked thumbnail
                this.classList.add('active');
                
                // Get the image source from the clicked thumbnail
                const imgSrc = this.querySelector('img').src;
                
                // Update main image with fade effect
                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.src = imgSrc;
                    mainImage.style.opacity = '1';
                }, 150);
            });
        });
    }
});
</script>
