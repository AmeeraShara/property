@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/land-details.css') }}">
<link rel="stylesheet" href="{{ asset('css/home-details.css') }}">
@endpush

@section('content')
<div class="home-details-container">
    <!-- Small Blue Navbar -->
    <div class="home-navbar">
        <div class="container">
            <!-- Visible links (first 3) -->
           <a href="{{ route('sales.index') }}" class="nav-link">Sales</a>
                <a href="{{ route('rent.index') }}" class="nav-link">Rentals</a>
                <a href="{{ route('land.index') }}" class="nav-link">Land</a>
                

            <!-- Overflow links (hidden on tablet/mobile, shown in sidebar) -->
           
            <a href="#" class="nav-link nav-overflow">Our Services</a>
            
            <a href="#" class="nav-link nav-overflow">Market Insight</a>
            <a href="#" class="nav-link nav-overflow">Wanted</a>
            

            <!-- Toggle button (visible on tablet/mobile) -->
            <button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="navSidebar">
                ☰ More
            </button>
        </div>
    </div>

    <!-- Overlay and Sidebar for overflow nav items -->
    <div class="nav-overlay" id="navOverlay" tabindex="-1" aria-hidden="true"></div>

    <aside class="nav-sidebar" id="navSidebar" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="sidebar-header">
            <div class="sidebar-title">More</div>
            <button class="sidebar-close" id="navClose" aria-label="Close navigation">Close</button>
        </div>
        <nav class="sidebar-list" id="navSidebarList" aria-label="More navigation">
            <!-- JS will populate this with the .nav-overflow links -->
        </nav>
    </aside>
    
    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <a href="{{ url('/dashboard') }}" class="breadcrumb-link">Home</a> 
            <span class="breadcrumb-separator">/</span>
            <a href="#" class="breadcrumb-link">{{ ucfirst($property->type) }}</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ $property->title }}</span>
        </div>
    </div>
    
    <div class="container">
<!-- Replace the gallery section in your land details blade with this updated version -->

<!-- Image Gallery Section with Improved Sizing -->
<div class="gallery-section gallery-layout">
    @php
        $images = $property->images; // JSON array from DB
        $imagesArray = is_array($images) ? $images : [];
        $mainImage = null;

        if (!empty($imagesArray) && !empty($imagesArray[0])) {
            $mainImage = asset('storage/' . $imagesArray[0]);
        }
    @endphp

    <!-- Main Image Container -->
    <div class="main-image">
        @if($mainImage)
            <img src="{{ $mainImage }}" 
                 alt="{{ $property->title ?? 'Property Image' }}"
                 id="mainImage">
            <div class="district-overlay">{{ $property->district ?? 'Unknown' }}</div>
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
    </div>

    <!-- Thumbnail Grid (2x2 on desktop) -->
    <div class="thumbnail-grid">
        @if(!empty($imagesArray) && count($imagesArray) > 0)
            @foreach($imagesArray as $index => $image)
                <div class="thumbnail {{ $index === 0 ? 'active' : '' }}" 
                     data-image-index="{{ $index }}"
                     role="button"
                     tabindex="0"
                     aria-label="View image {{ $index + 1 }}">
                    <img src="{{ asset('storage/' . $image) }}" 
                         alt="Property Image {{ $index + 1 }}"
                         loading="lazy">
                </div>
            @endforeach
        @else
            <!-- Default placeholder thumbnails if no images -->
            <div class="thumbnail active">
                <img src="{{ asset('images/property1.jpg') }}" alt="Property Image 1">
            </div>
            <div class="thumbnail">
                <img src="{{ asset('images/property2.jpg') }}" alt="Property Image 2">
            </div>
            <div class="thumbnail">
                <img src="{{ asset('images/property1.jpg') }}" alt="Property Image 3">
            </div>
            <div class="thumbnail">
                <img src="{{ asset('images/property2.jpg') }}" alt="Property Image 4">
            </div>
        @endif
    </div>
</div>

<style>
/* Additional inline styles for no-image placeholder */
.no-image-placeholder {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.no-image-content {
    text-align: center;
    color: #6c757d;
}

.no-image-content svg {
    margin: 0 auto 15px;
    opacity: 0.5;
}

.no-image-content p {
    margin: 0;
    font-size: 16px;
    font-weight: 500;
}
</style>

    </div>

    <!-- Property Details Section -->
    <div class="details-section">
        <!-- Left Column -->
        <div class="details-left">
            <!-- Title and Location -->
            <div class="property-header">
                <div class="property-header-top">
                    <h1 class="property-title">{{ $property->title }}</h1>

                    <!-- Save & Share Buttons -->
                    <div class="property-actions">
                        <button class="action-btn save-btn" data-property-id="{{ $property->id }}">
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
                    <span>{{ $property->location }}</span>
                </div>

                <div class="property-badges">
                    <span class="badge-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;">
                            <path d="M3 3h18v18H3z"></path>
                        </svg>
                        {{ $property->size }} {{ $property->size_unit }}
                    </span>
                </div>
            </div>
                    
            <!-- Price Section -->
            <div class="price-section">
                <div class="price-info">
                    <span class="price-amount">Rs. {{ number_format($property->price) }}</span>
                    <span class="price-label">{{ $property->price_type }}</span>
                </div>
            </div>

            <!-- Overview Section -->
            <div class="overview-section">
                <h2 class="section-title">Overview</h2>
                <form class="overview-form">
                    <div class="overview-grid">
                        <div class="overview-row">
                            <div class="overview-item">
                                <span class="overview-label">Property Type</span>
                                <span class="overview-value">{{ $property->type }}</span>
                            </div>
                            <div class="overview-item">
                                <span class="overview-label">Area Of Land</span>
                                <span class="overview-value">{{ $property->size }} {{ $property->size_unit }}</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Property Details Section -->
            <div class="property-details-section">
                <h2 class="section-title">Property Details</h2>
                <p class="details-description">
                    {!! nl2br(e($property->description)) !!}
                </p>
            </div>

            <!-- Property Features Section -->
            <div class="features-section">
                <h2 class="section-title">Property Features</h2>
                <ul class="features-list">
                    @if(!empty($property->features) && count($property->features) > 0)
                        @foreach($property->features as $feature)
                        <li>{{ $feature }}</li>
                        @endforeach
                    @else
                        <li>No features listed</li>
                    @endif
                </ul>
            </div>
        </div>
        </div>

        <!-- Right Column - Contact Form (Desktop) -->
        <div class="details-right">
            <div class="contact-card">
                <h2 class="contact-title">Contact Advertiser</h2>
                
                <div class="advertiser-info">
                    <div class="advertiser-avatar">
                        @if($property->advertiser->avatar)
                            <img src="{{ asset($property->advertiser->avatar) }}" alt="Advertiser Avatar">
                        @else
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        @endif
                    </div>
                    <div class="advertiser-details">
                        <span class="advertiser-name">{{ $property->advertiser->name }}</span>
                        <span class="advertiser-badge">{{ $property->advertiser->type }}</span>
                    </div>
                </div>

                <div class="contact-form-wrapper">
                    <div class="contact-left">
                        <div class="contact-buttons">
                            <button class="btn-phone" data-phone="{{ $property->advertiser->phone }}">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span class="phone-text">072-Click to View Number</span>
                            </button>
                            <button class="btn-whatsapp" data-phone="{{ $property->advertiser->phone }}">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                                WhatsApp
                            </button>
                        </div>
                    </div>
                    <div class="contact-right">
                        <form class="contact-form" id="contactForm">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            <input type="text" class="form-input" name="name" placeholder="Your Name" required>
                            <input type="email" class="form-input" name="email" placeholder="Your Email Address" required>
                            <input type="tel" class="form-input" name="phone" placeholder="Your Phone Number" required>
                            <textarea class="form-textarea" name="message" placeholder="Enter Your Message" rows="4" required></textarea>
                            <button type="submit" class="btn-send">SEND</button>
                        </form>
                    </div>
                </div>

                <div class="post-info">
                    Posted/Edited: {{ $property->updated_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>

<!-- Similar Properties Section -->
<div class="similar-properties-section">
    <h2 class="section-title">Similar Properties</h2>
    <div class="similar-properties-grid">
        @if(!empty($similarProperties) && count($similarProperties) > 0)
            @php
                // Filter only land properties
                $landProperties = $similarProperties->filter(function($item) {
                    return $item->property_type === 'land';
                });
            @endphp

            @if($landProperties->count() > 0)
                @foreach($landProperties as $similar)
                @php
                    // Get first image or fallback
                    $thumbnail = asset('images/property2.jpg');
                    if (!empty($similar->images) && is_array($similar->images) && !empty($similar->images[0])) {
                        $thumbnail = asset('storage/' . $similar->images[0]);
                    }

                    // Land area & unit
                    $size = $similar->land_area ? number_format($similar->land_area) : 'N/A';
                    $sizeUnit = $similar->land_unit ?? 'Perches';

                    // Price type
                    $priceUnit = '';
                    if ($similar->price_type === 'per_month') {
                        $priceUnit = '/month';
                    } elseif ($similar->price_type === 'per_year') {
                        $priceUnit = '/year';
                    }
                @endphp

                <div class="similar-property-card">
                    <div class="similar-image-wrapper">
                        <img src="{{ $thumbnail }}" 
                             alt="{{ $similar->ad_title ?? 'Land Property' }}"
                             onerror="this.src='{{ asset('images/property2.jpg') }}'">
                        <span class="similar-badge">{{ $similar->district ?? 'Location' }}</span>
                        <button class="similar-favorite" data-property-id="{{ $similar->id }}">★</button>
                    </div>

                    <div class="similar-content">
                        <div class="similar-meta">
                            <span class="similar-sqft">{{ $size }} {{ $sizeUnit }}</span>
                            <span class="similar-type">{{ ucfirst($similar->property_type ?? 'Property') }}</span>
                        </div>

                        <div class="similar-price">
                            @if($similar->price)
                                Rs. {{ number_format($similar->price) }}
                                <span class="price-unit">{{ $priceUnit }}</span>
                            @else
                                <span class="price-on-request">Price on Request</span>
                            @endif
                        </div>

                        <h4 class="similar-title">
                            <a href="{{ route('sales.property-details', ['id' => $similar->id]) }}">
                                {{ $similar->ad_title ?? 'Land for Sale' }}
                            </a>
                        </h4>

                        <p class="similar-description">
                            {{ Str::limit($similar->ad_description ?? 'No description available', 80) }}
                        </p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="no-similar-properties">
                    <p>No similar land properties found at the moment.</p>
                    <a href="{{ route('sales.index') }}" class="btn-view-all">View All Properties</a>
                </div>
            @endif
        @else
            <div class="no-similar-properties">
                <p>No similar properties found at the moment.</p>
                <a href="{{ route('sales.index') }}" class="btn-view-all">View All Properties</a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // NAVBAR TOGGLE FUNCTIONALITY
    // ========================================
    const navToggle = document.getElementById('navToggle');
    const navClose = document.getElementById('navClose');
    const navSidebar = document.getElementById('navSidebar');
    const navOverlay = document.getElementById('navOverlay');
    const navSidebarList = document.getElementById('navSidebarList');

    // Populate sidebar with overflow nav items
    const overflowLinks = document.querySelectorAll('.nav-overflow');
    overflowLinks.forEach(link => {
        const clonedLink = link.cloneNode(true);
        clonedLink.classList.remove('nav-overflow');
        navSidebarList.appendChild(clonedLink);
    });

    // Open sidebar
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            navSidebar.classList.add('open');
            navOverlay.classList.add('open');
            navToggle.setAttribute('aria-expanded', 'true');
            navSidebar.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden'; // Prevent body scroll
        });
    }

    // Close sidebar function
    function closeSidebar() {
        navSidebar.classList.remove('open');
        navOverlay.classList.remove('open');
        if (navToggle) {
            navToggle.setAttribute('aria-expanded', 'false');
        }
        navSidebar.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = ''; // Restore body scroll
    }

    // Close button
    if (navClose) {
        navClose.addEventListener('click', closeSidebar);
    }

    // Close when clicking overlay
    if (navOverlay) {
        navOverlay.addEventListener('click', closeSidebar);
    }

    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && navSidebar.classList.contains('open')) {
            closeSidebar();
        }
    });

    // ========================================
    // IMAGE GALLERY FUNCTIONALITY
    // ========================================
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('mainImage');
    
    if (thumbnails.length > 0 && mainImage) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const imgSrc = this.querySelector('img').src;
                mainImage.src = imgSrc;
            });
        });
    }

    // Phone number reveal
    document.querySelectorAll('.btn-phone').forEach(btn => {
        btn.addEventListener('click', function() {
            const phone = this.getAttribute('data-phone');
            const phoneText = this.querySelector('.phone-text');
            if (phoneText && phoneText.textContent === '072-Click to View Number') {
                phoneText.textContent = phone;
            }
        });
    });
});
// Professional Form Submission
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitButton = this.querySelector('.btn-send');
        const originalText = submitButton.textContent;
        
        // Show loading state
        submitButton.textContent = 'SENDING...';
        submitButton.classList.add('loading');
        submitButton.disabled = true;
        
        fetch('/submit-inquiry', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show professional success message
                showSuccessMessage(
                    'Message Sent Successfully!', 
                    'Thank you for your inquiry. We will contact you within 24 hours.',
                    true
                );
                this.reset();
            } else {
                showErrorMessage(data.message || 'Failed to send message. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorMessage('Network error. Please check your connection and try again.');
        })
        .finally(() => {
            // Reset button state
            submitButton.textContent = originalText;
            submitButton.classList.remove('loading');
            submitButton.disabled = false;
        });
    });
}

// Professional Success Message Function
function showSuccessMessage(title, message, autoClose = true) {
    // Remove existing success messages
    removeExistingMessages();
    
    const successDiv = document.createElement('div');
    successDiv.className = 'success-message';
    successDiv.innerHTML = `
        <svg class="success-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <div class="success-content">
            <div class="success-title">${title}</div>
            <div class="success-text">${message}</div>
        </div>
        <button class="success-close" aria-label="Close message">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    `;
    
    document.body.appendChild(successDiv);
    
    // Close button functionality
    const closeBtn = successDiv.querySelector('.success-close');
    closeBtn.addEventListener('click', () => {
        hideMessage(successDiv);
    });
    
    // Auto close after 5 seconds
    if (autoClose) {
        setTimeout(() => {
            hideMessage(successDiv);
        }, 5000);
    }
}

// Error Message Function
function showErrorMessage(message) {
    removeExistingMessages();
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'success-message';
    errorDiv.style.background = '#ef4444';
    errorDiv.style.borderLeftColor = '#dc2626';
    
    errorDiv.innerHTML = `
        <svg class="success-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <div class="success-content">
            <div class="success-title">Message Not Sent</div>
            <div class="success-text">${message}</div>
        </div>
        <button class="success-close" aria-label="Close message">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    `;
    
    document.body.appendChild(errorDiv);
    
    const closeBtn = errorDiv.querySelector('.success-close');
    closeBtn.addEventListener('click', () => {
        hideMessage(errorDiv);
    });
    
    setTimeout(() => {
        hideMessage(errorDiv);
    }, 5000);
}

// Hide message with animation
function hideMessage(messageElement) {
    messageElement.classList.add('hidden');
    setTimeout(() => {
        if (messageElement.parentNode) {
            messageElement.parentNode.removeChild(messageElement);
        }
    }, 300);
}

// Remove existing messages
function removeExistingMessages() {
    const existingMessages = document.querySelectorAll('.success-message');
    existingMessages.forEach(msg => {
        if (msg.parentNode) {
            msg.parentNode.removeChild(msg);
        }
    });
}
// Save Property Functionality
document.querySelectorAll('.save-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const propertyId = this.getAttribute('data-property-id');
        if (!propertyId) return;
        
        const isCurrentlySaved = this.classList.contains('saved');
        const action = isCurrentlySaved ? 'remove' : 'add';
        
        // Show loading state
        const originalHtml = this.innerHTML;
        this.innerHTML = `
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            SAVING...
        `;
        this.disabled = true;
        
        // AJAX call to save/remove property
        fetch('{{ route("sales.save-property") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                property_id: propertyId,
                action: action
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Toggle saved state
                this.classList.toggle('saved');
                
                // Update button text and icon
                if (this.classList.contains('saved')) {
                    this.innerHTML = `
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                            <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8z"/>
                        </svg>
                        SAVED
                    `;
                    
                    // Show success message
                    showSuccessMessage('Property Saved', 'Property has been added to your favorites!', false);
                } else {
                    this.innerHTML = originalHtml;
                    showSuccessMessage('Property Removed', 'Property has been removed from favorites.', false);
                }
            } else {
                this.innerHTML = originalHtml;
                showErrorMessage(data.message || 'Failed to save property.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.innerHTML = originalHtml;
            showErrorMessage('Network error. Please try again.');
        })
        .finally(() => {
            this.disabled = false;
        });
    });
});
// Share Property Functionality
document.querySelectorAll('.share-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const propertyTitle = '{{ $property->title }}';
        const propertyUrl = window.location.href;
        const shareText = `Check out this property: ${propertyTitle}`;
        
        // Show share options
        showShareOptions(propertyTitle, propertyUrl, shareText);
    });
});

// Share Options Modal
function showShareOptions(title, url, text) {
    // Remove existing share modal
    const existingModal = document.getElementById('shareModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    const shareModal = document.createElement('div');
    shareModal.id = 'shareModal';
    shareModal.innerHTML = `
        <div class="share-modal-overlay">
            <div class="share-modal">
                <div class="share-modal-header">
                    <h3>Share Property</h3>
                    <button class="share-close-btn">&times;</button>
                </div>
                <div class="share-options">
                    <button class="share-option" data-platform="whatsapp">
                        <div class="share-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </div>
                        <span>WhatsApp</span>
                    </button>
                    
                    <button class="share-option" data-platform="facebook">
                        <div class="share-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                        <span>Facebook</span>
                    </button>
                    
                    <button class="share-option" data-platform="twitter">
                        <div class="share-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.016 10.016 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </div>
                        <span>Twitter</span>
                    </button>
                    
                    <button class="share-option" data-platform="copy">
                        <div class="share-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </div>
                        <span>Copy Link</span>
                    </button>
                </div>
                
                <div class="share-url">
                    <input type="text" value="${url}" readonly class="url-input">
                    <button class="copy-url-btn">Copy</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(shareModal);
    
    // Add event listeners
    shareModal.querySelector('.share-close-btn').addEventListener('click', () => {
        shareModal.remove();
    });
    
    shareModal.querySelector('.share-modal-overlay').addEventListener('click', (e) => {
        if (e.target === e.currentTarget) {
            shareModal.remove();
        }
    });
    
    // Share option clicks
    shareModal.querySelectorAll('.share-option').forEach(option => {
        option.addEventListener('click', () => {
            const platform = option.getAttribute('data-platform');
            handleShare(platform, title, url, text);
        });
    });
    
    // Copy URL button
    shareModal.querySelector('.copy-url-btn').addEventListener('click', () => {
        copyToClipboard(url);
        showSuccessMessage('Link Copied!', 'Property link has been copied to clipboard.', false);
        shareModal.remove();
    });
}

// Handle different share platforms
function handleShare(platform, title, url, text) {
    let shareUrl = '';
    
    switch(platform) {
        case 'whatsapp':
            shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
            break;
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
            break;
        case 'copy':
            copyToClipboard(url);
            showSuccessMessage('Link Copied!', 'Property link has been copied to clipboard.', false);
            return;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
}

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        console.log('Text copied to clipboard');
    }).catch(err => {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
    });
}
</script>
@endpush