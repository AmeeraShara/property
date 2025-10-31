@extends('layouts.app')

@section('title', 'RALankaProperty - Home')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}"
<!-- Debug Info - REMOVE THIS SECTION -->
<!-- 
<div style="position: fixed; top: 10px; left: 10px; background: red; color: white; padding: 10px; z-index: 9999; font-size: 12px;">
    @php
        $bgCount = \App\Models\HeroBackground::where('is_active', true)->count();
        $bgPath = $heroBackground->image_path;
        $fullPath = public_path($bgPath);
        $fileExists = file_exists($fullPath);
        $bgUrl = asset($bgPath);
    @endphp
    
    Background Path: {{ $bgPath }}<br>
    Full Server Path: {{ $fullPath }}<br>
    Full URL: {{ $bgUrl }}<br>
    Active Backgrounds: {{ $bgCount }}<br>
    Image Exists: {{ $fileExists ? 'YES' : 'NO' }}<br>
    File Size: {{ $fileExists ? filesize($fullPath) . ' bytes' : 'N/A' }}
</div>
-->

<!-- Hero Section Only (Without Debug) -->
@php
    $bgPath = $heroBackground->image_path;
    $bgUrl = asset($bgPath);
    
    // Get all active backgrounds for JavaScript
    $activeBackgrounds = \App\Models\HeroBackground::where('is_active', true)
                        ->orderBy('display_order')
                        ->get()
                        ->filter(function($bg) {
                            return file_exists(public_path($bg->image_path));
                        })
                        ->pluck('image_path')
                        ->map(function($path) {
                            return asset($path);
                        })
                        ->toArray();
@endphp

<section class="hero">
    <div class="hero-overlay" 
         style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ $bgUrl }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                width: 100%;
                height: 100%;">
        
        <!-- Hamburger Toggle Button -->
        <button class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
         <!-- Add this to your hero section after the hero-nav -->
<div class="side-menu" id="sideMenu">
    <button class="close-menu" id="closeMenu">×</button>
    <ul>
       
        <li><a href="#">Our Services</a></li>
        
        <li><a href="#">Wanted</a></li>
        
    </ul>
</div>
        <!-- Navbar (Hidden by default on mobile, toggled by button) -->
         
        <nav class="hero-nav" id="heroNav">
          
            <ul>
                <li><a href="{{ route('sales.index') }}">Sales</a></li>
                <li><a href="{{ route('rent.index') }}">Rentals</a></li>
                <li><a href="{{ route('land.index') }}">Land</a></li>   
                <li><a href="#">Our Services</a></li> 
                <li><a href="{{ route('wanted.index') }}">Wanted</a></li>
               
            </ul>
        </nav>

        <!-- Left-Aligned Heading -->
        <div class="hero-text">
            <h1>JOIN WITH US FOR<br>BEGINNING YOUR NEW CHAPTER</h1>
        </div>

        <!-- New Arrivals Floating Window (Slideshow Carousel) -->
        <div class="new-arrivals-floating">
            <div class="new-arrivals-header">
                <h3>New arrival Properties</h3>
                <button class="close-floating">&times;</button>
            </div>
            <div class="new-arrivals-carousel">
                <button class="carousel-prev" id="newPrev">&lt;</button>
                <div class="carousel-track" id="newTrack">
                    @php
                        $slides = [];
                        for ($i = 0; $i < ceil(count($newArrivals ?? []) / 2); $i++) {
                            $slideProps = [];
                            for ($j = 0; $j < 2; $j++) {
                                $index = $i * 2 + $j;
                                if (isset($newArrivals[$index])) {
                                    $slideProps[] = $newArrivals[$index];
                                }
                            }
                            $slides[] = $slideProps;
                        }
                    @endphp
                    @foreach($slides as $slideIndex => $slideProps)
                        <div class="carousel-slide @if($slideIndex === 0) active @endif" data-slide="{{ $slideIndex }}">
                            @foreach($slideProps as $property)
                                <div class="new-arrival-card">
                                    <div class="property-image-small">
                                        @php
                                            $images = $property->images;
                                            $imageUrl = null;
                                            
                                            if (!empty($images) && is_array($images) && !empty($images[0])) {
                                                $imageUrl = 'http://localhost:8000/storage/' . $images[0];
                                            } else {
                                                $imageUrl = asset('images/placeholder.jpg');
                                            }
                                        @endphp
                                        <img src="{{ $imageUrl }}" alt="{{ $property->ad_description ?? 'New Arrival Property' }}">
                                    </div>
                                    <div class="property-details-small">
                                        <div class="district-small">{{ $property->district ?? 'Unknown' }}</div>
                                        <div class="size-type-line-small">
                                            <span class="property-size-small">
                                                @if($property->property_type === 'land')
                                                    {{ number_format($property->land_area ?? 0, 2) }} {{ $property->land_unit ?? 'Perches' }}
                                                @else
                                                    {{ number_format($property->floor_area ?? 0, 2) }} sq ft
                                                @endif
                                            </span>
                                            <span class="property-type-small">{{ ucfirst($property->property_type ?? 'Property') }}</span>
                                        </div>
                                        <div class="property-price-small">
                                            Rs. {{ number_format($property->price ?? 0, 2) }}
                                            <span class="price-unit-small">
                                                @if($property->price_type === 'per_month') /month
                                                @elseif($property->price_type === 'per_year') /year
                                                @elseif($property->price_type === 'per_week') /week
                                                @else negot
                                                @endif
                                            </span>
                                        </div>
                                        <p class="property-location-small">
                                            @if($property->property_type === 'land')
                                                for sale in {{ $property->district ?? 'Unknown' }} bare land
                                            @else
                                                House in {{ $property->district ?? 'Unknown' }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            @if(empty($slideProps))
                                <div class="no-properties-small">No new arrivals available</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button class="carousel-next" id="newNext">&gt;</button>
            </div>
            <div class="carousel-dots-new" id="newDots">
                @for($i = 0; $i < count($slides); $i++)
                    <span class="dot @if($i === 0) active @endif" data-slide="{{ $i }}"></span>
                @endfor
            </div>
            <div class="new-arrivals-footer">
                <a href="{{ route('sales.index') }}" class="view-all-link">View All New Arrivals <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="container">
    <div class="search-section">
        <div class="search-tabs">
            <div class="search-tab active" data-tab="sales">SALES</div>
            <div class="search-tab" data-tab="rentals">RENTALS</div>
            <div class="search-tab" data-tab="land">LAND</div>
            <div class="search-tab" data-tab="newdev">NEW DEVELOPMENT</div>
        </div>

        <!-- Sales Form (default visible) -->
        <div class="search-form active" id="sales">
            <div class="search-row">
            <input type="text" class="search-input" placeholder="Type a city name" 
       style="background-color:#ffffff; color:#000000; border:1px solid #ddd; width: 70%;">
                <button class="search-button">Search <i class="fas fa-search"></i></button>
            </div>
            <div class="search-row" style="display: flex; gap: 159px; align-items: center;">
                <select class="search-input">
                    <option>Property Type</option>
                    <option>House</option>
                    <option>Apartment</option>
                    <option>Commercial</option>
                    <option>Land</option>
                </select>
                <select class="search-input">
                    <option>Max Bedroom</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4+</option>
                </select>
                <select class="search-input">
                    <option>Radius</option>
                    <option>1 km</option>
                    <option>5 km</option>
                    <option>10 km</option>
                    <option>20 km</option>
                </select>
                <select class="search-input">
                    <option>Max Price</option>
                    <option>Rs. 5,000,000</option>
                    <option>Rs. 10,000,000</option>
                    <option>Rs. 20,000,000</option>
                    <option>Rs. 50,000,000</option>
                </select>
            </div>
        </div>

        <!-- Other forms (hidden by default) -->
        
    <!-- RENTALS Form -->
    <div class="search-form" id="rentals">
      <div class="search-row">
        <input type="text" class="search-input"
          placeholder="Enter city or area name"
          style="background-color:#ffffff; color:#000000; border:1px solid #ddd; width: 70%;">
        <button class="search-button">Search <i class="fas fa-search"></i></button>
      </div>
      <div class="search-row" style="display: flex; gap: 159px; align-items: center;">
        <select class="search-input">
          <option>Property Type</option>
          <option>Apartment</option>
          <option>House</option>
          <option>Annex</option>
          <option>Commercial</option>
        </select>
        <select class="search-input">
          <option>Max Bedroom</option>
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4+</option>
        </select>
        <select class="search-input">
          <option>Monthly Rent (Max)</option>
          <option>Rs. 25,000</option>
          <option>Rs. 50,000</option>
          <option>Rs. 100,000</option>
          <option>Rs. 200,000</option>
        </select>
        <select class="search-input">
          <option>Distance</option>
          <option>1 km</option>
          <option>5 km</option>
          <option>10 km</option>
          <option>20 km</option>
        </select>
      </div>
    </div>

        <!-- LAND Form -->
    <div class="search-form" id="land">
      <div class="search-row">
        <input type="text" class="search-input"
          placeholder="Enter city name"
          style="background-color:#ffffff; color:#000000; border:1px solid #ddd; width: 70%;">
        <button class="search-button">Search <i class="fas fa-search"></i></button>
      </div>
      <div class="search-row" style="display: flex; gap: 159px; align-items: center;">
        <select class="search-input">
          <option>Land Type</option>
          <option>Residential</option>
          <option>Commercial</option>
          <option>Agricultural</option>
        </select>
        <select class="search-input">
          <option>Min Size</option>
          <option>5 perches</option>
          <option>10 perches</option>
          <option>20 perches</option>
        </select>
        <select class="search-input">
          <option>Max Size</option>
          <option>50 perches</option>
          <option>100 perches</option>
          <option>200 perches</option>
        </select>
        <select class="search-input">
          <option>Max Price</option>
          <option>Rs. 1,000,000</option>
          <option>Rs. 5,000,000</option>
          <option>Rs. 10,000,000</option>
        </select>
      </div>
    </div>

         <!-- NEW DEVELOPMENT Form -->
    <div class="search-form" id="newdev">
      <div class="search-row">
        <input type="text" class="search-input"
          placeholder="Enter project name or area"
          style="background-color:#ffffff; color:#000000; border:1px solid #ddd; width: 70%;">
        <button class="search-button">Search <i class="fas fa-search"></i></button>
      </div>
      <div class="search-row" style="display: flex; gap: 159px; align-items: center;">
        <select class="search-input">
          <option>Project Type</option>
          <option>Apartment</option>
          <option>Housing Scheme</option>
          <option>Mixed Development</option>
        </select>
        <select class="search-input">
          <option>Status</option>
          <option>Ongoing</option>
          <option>Completed</option>
          <option>Upcoming</option>
        </select>
        <select class="search-input">
          <option>Price Range</option>
          <option>Rs. 5M - 10M</option>
          <option>Rs. 10M - 20M</option>
          <option>Rs. 20M+</option>
        </select>
        <select class="search-input">
          <option>City</option>
          <option>Colombo</option>
          <option>Kandy</option>
          <option>Galle</option>
        </select>
      </div>
    </div>
  
    </div>
</section>
<!-- horizontal line -->
  <hr class="feature-line">
<!-- Featured Projects Section -->
<section class="featured-projects">
    <div class="container">
        <h2 class="section-title">Featured Projects</h2>

        <div class="slider-wrapper">
            <!-- Left Arrow -->
<div class="arrow-circle" id="prevArrow">
    <div class="arrow-left"></div>
</div>

            <!-- Main Image Display -->
          <div class="main-image" id="mainImage" style="background-image: url('/images/home2.jpg')">
    <!-- Overlay Box -->
    <div class="overlay-box">
       
        <h3>40%<br>Down Payment</h3>
    </div>
<!-- Right Bottom Overlay Box -->
<div class="overlay-box-right">
    <!-- Small Green Box on top with text -->
    <div class="top-accent">
        STARTING AT
    </div>

    <h3 class="overlay-price"><span>LKR</span> 20M</h3>
</div>


    <!-- Circles overlay at bottom -->
    <div class="image-selector">
        <div class="circle active" data-image="/images/home2.jpg"></div>
        <div class="circle" data-image="/images/home3.jpg"></div>
        <div class="circle" data-image="/images/home4.jpg"></div>
        <div class="circle" data-image="/images/home5.jpg"></div>
    </div>
</div>
<!-- Right Arrow -->
<div class="arrow-circle" id="nextArrow">
    <div class="arrow-right"></div>
</div>
        </div>
    </div>
</section>


<!-- horizontal line -->
<hr class="feature-line">

<!-- Showcase Properties Section -->
<section class="showcase-section" id="showcaseSection">
    <div class="container">
        <h2 class="section-title" style="font-size: 2.5rem; font-weight: bold;">Showcase Properties</h2>

        <!-- Line 1: Normal Properties -->
        <div class="properties-line">
           
            <div class="properties-grid">
                @forelse($normalProperties as $property)
                    <!-- Copy and paste your entire property-card HTML here -->
                    <div class="property-card" data-district="{{ $property->district ?? 'Unknown' }}">
                        <div class="property-image">
                            @php
                                $images = $property->images;
                                $imageUrl = null;
                                
                                if (!empty($images) && is_array($images) && !empty($images[0])) {
                                    $imageUrl = 'http://localhost:8000/storage/' . $images[0];
                                }
                            @endphp

                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" alt="Property Image" style="width: 150%; height: auto; border: 2px ;">
                            @else
                                <div style="background: lightgray; padding: 50px; text-align: center;">NO IMAGE</div>
                            @endif

                            <div class="district-overlay">{{ $property->district ?? 'Unknown' }}</div>
                            
                            @if($property->is_hot_deal_calculated)
                                <div class="property-badge-overlay hot-deal-auto"><i class="fas fa-bolt"></i> AUTO HOT DEAL</div>
                            @elseif($property->is_trending_calculated)
                                <div class="property-badge-overlay trending-auto"><i class="fas fa-chart-line"></i> AUTO TRENDING</div>
                            @endif

                            @if($property->is_urgent)
                                <div class="property-badge-overlay urgent" id="urgent-badge-{{ $property->id }}">
                                    <i class="fas fa-bolt"></i> URGENT 
                                    <span class="urgent-timer" data-expires="{{ $property->urgent_expires ?? now()->addDays(7)->toISOString() }}"></span>
                                </div>
                            @elseif($property->is_hot_deal)
                                <div class="property-badge-overlay hot-deal"><i class="fas fa-fire"></i> HOT DEAL</div>
                            @elseif($property->is_featured)
                                <div class="property-badge-overlay featured"><i class="fas fa-star"></i> FEATURED</div>
                            @endif
                        </div>

                        <div class="property-details">
                            <div class="size-type-line">
                                <span class="property-size" style="font-size: 1.1rem;">
                                    @if($property->property_type === 'land')
                                        {{ number_format($property->land_area ?? 0, 2) }} {{ $property->land_unit ?? 'Perches' }}
                                    @else
                                        {{ number_format($property->floor_area ?? 0, 2) }} sq ft
                                    @endif
                                </span>
                                <span class="property-type" style="font-size: 1.1rem;">{{ ucfirst($property->property_type ?? 'Property') }}</span>
                                <i class="fas fa-star favorite-icon" data-property-id="{{ $property->id }}"></i>
                            </div>

                            <div class="property-price" style="font-size: 1.5rem; font-weight: bold;">
                                Rs. {{ number_format($property->price ?? 0, 2) }} 
                                <span class="price-unit">
                                    @if($property->price_type === 'per_month') /month
                                    @elseif($property->price_type === 'per_year') /year
                                    @elseif($property->price_type === 'per_week') /week
                                    @else {{ $property->price_type ?? '' }}
                                    @endif
                                </span>
                            </div>

                            <div class="property-description-container">
                                <p class="property-description" id="desc-{{ $property->id }}" style="font-size: 1rem;">
                                    <a href="{{ route('sales.property-details', ['id' => $property->id]) }}" class="property-link">
                                        {{ Str::limit($property->ad_description ?? 'No description available', 100) }}
                                    </a>
                                </p>
                                @if(strlen($property->ad_description ?? '') > 100)
                                    <button class="read-more-btn" data-target="desc-{{ $property->id }}" data-full-text="{{ $property->ad_description }}">Read More</button>
                                @endif
                            </div>      
                            
                            <hr class="description-line" style="margin: 8px 0;">

                            <div class="property-features blue-features" style="margin-bottom: 5px; color: #007bff;">
                                @if($property->bedrooms)
                                    <span class="feature blue-feature" style="font-size: 1rem;"><i class="fas fa-bed"></i> {{ $property->bedrooms }} Bed</span>
                                @endif
                                @if($property->bathrooms)
                                    <span class="feature blue-feature" style="font-size: 1rem;"><i class="fas fa-bath"></i> {{ $property->bathrooms }} Bath</span>
                                @endif
                            </div>
                        </div>

                        <div class="property-footer" style="margin-top: 5px; padding-top: 0;">
                            @if($property->property_type !== 'house')
                                <div class="property-location" style="margin-bottom: 3px; color: #007bff;">
                                    <div class="street-line" style="font-size: 1rem;">
                                        <i class="fas fa-map-marker-alt"></i> {{ $property->street ?? 'Street not specified' }}
                                    </div>
                                </div>
                            @endif
                            
                            <div class="property-features-list" style="margin-top: 2px; color: #007bff;"> 
                                @if($property->features && is_array($property->features) && count($property->features) > 0)
                                    <div class="features-tags">
                                        <span class="feature-icon"><i class="fas fa-building"></i></span>
                                        <span class="features-text" style="font-size: 0.95rem;">
                                            {{ implode(', ', array_slice($property->features, 0, 3)) }}
                                            @if(count($property->features) > 3), +{{ count($property->features) - 3 }} more @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-properties">No regular properties available</div>
                @endforelse
            </div>
        </div>

        <!-- Line 2: Hot Deal Properties -->
      <div class="properties-line" style="margin-top: 20px;">
    <div class="properties-grid">
                @forelse($hotDealProperties as $property)
                    <!-- Same property-card HTML structure as above -->
                    <div class="property-card" data-district="{{ $property->district ?? 'Unknown' }}">
                             <div class="property-image">
                            @php
                                $images = $property->images;
                                $imageUrl = null;
                                
                                if (!empty($images) && is_array($images) && !empty($images[0])) {
                                    $imageUrl = 'http://localhost:8000/storage/' . $images[0];
                                }
                            @endphp

                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" alt="Property Image" style="width: 150%; height: auto; border: 2px ;">
                            @else
                                <div style="background: lightgray; padding: 50px; text-align: center;">NO IMAGE</div>
                            @endif

                            <div class="district-overlay">{{ $property->district ?? 'Unknown' }}</div>
                            
                            @if($property->is_hot_deal_calculated)
                                <div class="property-badge-overlay hot-deal-auto"><i class="fas fa-bolt"></i> AUTO HOT DEAL</div>
                            @elseif($property->is_trending_calculated)
                                <div class="property-badge-overlay trending-auto"><i class="fas fa-chart-line"></i> AUTO TRENDING</div>
                            @endif

                            @if($property->is_urgent)
                                <div class="property-badge-overlay urgent" id="urgent-badge-{{ $property->id }}">
                                    <i class="fas fa-bolt"></i> URGENT 
                                    <span class="urgent-timer" data-expires="{{ $property->urgent_expires ?? now()->addDays(7)->toISOString() }}"></span>
                                </div>
                            @elseif($property->is_hot_deal)
                                <div class="property-badge-overlay hot-deal"><i class="fas fa-fire"></i> HOT DEAL</div>
                            @elseif($property->is_featured)
                                <div class="property-badge-overlay featured"><i class="fas fa-star"></i> FEATURED</div>
                            @endif
                        </div>

                        <div class="property-details">
                            <div class="size-type-line">
                                <span class="property-size" style="font-size: 1.1rem;">
                                    @if($property->property_type === 'land')
                                        {{ number_format($property->land_area ?? 0, 2) }} {{ $property->land_unit ?? 'Perches' }}
                                    @else
                                        {{ number_format($property->floor_area ?? 0, 2) }} sq ft
                                    @endif
                                </span>
                                <span class="property-type" style="font-size: 1.1rem;">{{ ucfirst($property->property_type ?? 'Property') }}</span>
                                <i class="fas fa-star favorite-icon" data-property-id="{{ $property->id }}"></i>
                            </div>

                            <div class="property-price" style="font-size: 1.5rem; font-weight: bold;">
                                Rs. {{ number_format($property->price ?? 0, 2) }} 
                                <span class="price-unit">
                                    @if($property->price_type === 'per_month') /month
                                    @elseif($property->price_type === 'per_year') /year
                                    @elseif($property->price_type === 'per_week') /week
                                    @else {{ $property->price_type ?? '' }}
                                    @endif
                                </span>
                            </div>

                            <div class="property-description-container">
                                <p class="property-description" id="desc-{{ $property->id }}" style="font-size: 1rem;">
                                    <a href="{{ route('sales.property-details', ['id' => $property->id]) }}" class="property-link">
                                        {{ Str::limit($property->ad_description ?? 'No description available', 100) }}
                                    </a>
                                </p>
                                @if(strlen($property->ad_description ?? '') > 100)
                                    <button class="read-more-btn" data-target="desc-{{ $property->id }}" data-full-text="{{ $property->ad_description }}">Read More</button>
                                @endif
                            </div>      
                            
                            <hr class="description-line" style="margin: 8px 0;">

                            <div class="property-features blue-features" style="margin-bottom: 5px; color: #007bff;">
                                @if($property->bedrooms)
                                    <span class="feature blue-feature" style="font-size: 1rem;"><i class="fas fa-bed"></i> {{ $property->bedrooms }} Bed</span>
                                @endif
                                @if($property->bathrooms)
                                    <span class="feature blue-feature" style="font-size: 1rem;"><i class="fas fa-bath"></i> {{ $property->bathrooms }} Bath</span>
                                @endif
                            </div>
                        </div>

                        <div class="property-footer" style="margin-top: 5px; padding-top: 0;">
                            @if($property->property_type !== 'house')
                                <div class="property-location" style="margin-bottom: 3px; color: #007bff;">
                                    <div class="street-line" style="font-size: 1rem;">
                                        <i class="fas fa-map-marker-alt"></i> {{ $property->street ?? 'Street not specified' }}
                                    </div>
                                </div>
                            @endif
                            
                            <div class="property-features-list" style="margin-top: 2px; color: #007bff;"> 
                                @if($property->features && is_array($property->features) && count($property->features) > 0)
                                    <div class="features-tags">
                                        <span class="feature-icon"><i class="fas fa-building"></i></span>
                                        <span class="features-text" style="font-size: 0.95rem;">
                                            {{ implode(', ', array_slice($property->features, 0, 3)) }}
                                            @if(count($property->features) > 3), +{{ count($property->features) - 3 }} more @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
               
                    </div>
                @empty
                    <div class="no-properties">No hot deal properties available</div>
                @endforelse
            </div>
        </div>

        <!-- Line 3: Trending Properties -->
        <div class="properties-line" style="margin-top: 20px;">
            
            <div class="properties-grid">
                @forelse($trendingProperties as $property)
                    <!-- Same property-card HTML structure as above -->
                    <div class="property-card" data-district="{{ $property->district ?? 'Unknown' }}">
                             <div class="property-image">
                            @php
                                $images = $property->images;
                                $imageUrl = null;
                                
                                if (!empty($images) && is_array($images) && !empty($images[0])) {
                                    $imageUrl = 'http://localhost:8000/storage/' . $images[0];
                                }
                            @endphp

                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" alt="Property Image" style="width: 150%; height: auto; border: 2px ;">
                            @else
                                <div style="background: lightgray; padding: 50px; text-align: center;">NO IMAGE</div>
                            @endif

                            <div class="district-overlay">{{ $property->district ?? 'Unknown' }}</div>
                            
                            @if($property->is_hot_deal_calculated)
                                <div class="property-badge-overlay hot-deal-auto"><i class="fas fa-bolt"></i> AUTO HOT DEAL</div>
                            @elseif($property->is_trending_calculated)
                                <div class="property-badge-overlay trending-auto"><i class="fas fa-chart-line"></i> AUTO TRENDING</div>
                            @endif

                            @if($property->is_urgent)
                                <div class="property-badge-overlay urgent" id="urgent-badge-{{ $property->id }}">
                                    <i class="fas fa-bolt"></i> URGENT 
                                    <span class="urgent-timer" data-expires="{{ $property->urgent_expires ?? now()->addDays(7)->toISOString() }}"></span>
                                </div>
                            @elseif($property->is_hot_deal)
                                <div class="property-badge-overlay hot-deal"><i class="fas fa-fire"></i> HOT DEAL</div>
                            @elseif($property->is_featured)
                                <div class="property-badge-overlay featured"><i class="fas fa-star"></i> FEATURED</div>
                            @endif
                        </div>

                        <div class="property-details">
                            <div class="size-type-line">
                                <span class="property-size" style="font-size: 1.1rem;">
                                    @if($property->property_type === 'land')
                                        {{ number_format($property->land_area ?? 0, 2) }} {{ $property->land_unit ?? 'Perches' }}
                                    @else
                                        {{ number_format($property->floor_area ?? 0, 2) }} sq ft
                                    @endif
                                </span>
                                <span class="property-type" style="font-size: 1.1rem;">{{ ucfirst($property->property_type ?? 'Property') }}</span>
                                <i class="fas fa-star favorite-icon" data-property-id="{{ $property->id }}"></i>
                            </div>

                            <div class="property-price" style="font-size: 1.5rem; font-weight: bold;">
                                Rs. {{ number_format($property->price ?? 0, 2) }} 
                                <span class="price-unit">
                                    @if($property->price_type === 'per_month') /month
                                    @elseif($property->price_type === 'per_year') /year
                                    @elseif($property->price_type === 'per_week') /week
                                    @else {{ $property->price_type ?? '' }}
                                    @endif
                                </span>
                            </div>

                            <div class="property-description-container">
                                <p class="property-description" id="desc-{{ $property->id }}" style="font-size: 1rem;">
                                    <a href="{{ route('sales.property-details', ['id' => $property->id]) }}" class="property-link">
                                        {{ Str::limit($property->ad_description ?? 'No description available', 100) }}
                                    </a>
                                </p>
                                @if(strlen($property->ad_description ?? '') > 100)
                                    <button class="read-more-btn" data-target="desc-{{ $property->id }}" data-full-text="{{ $property->ad_description }}">Read More</button>
                                @endif
                            </div>      
                            
                            <hr class="description-line" style="margin: 8px 0;">

                            <div class="property-features blue-features" style="margin-bottom: 5px; color: #007bff;">
                                @if($property->bedrooms)
                                    <span class="feature blue-feature" style="font-size: 1rem;"><i class="fas fa-bed"></i> {{ $property->bedrooms }} Bed</span>
                                @endif
                                @if($property->bathrooms)
                                    <span class="feature blue-feature" style="font-size: 1rem;"><i class="fas fa-bath"></i> {{ $property->bathrooms }} Bath</span>
                                @endif
                            </div>
                        </div>

                        <div class="property-footer" style="margin-top: 5px; padding-top: 0;">
                            @if($property->property_type !== 'house')
                                <div class="property-location" style="margin-bottom: 3px; color: #007bff;">
                                    <div class="street-line" style="font-size: 1rem;">
                                        <i class="fas fa-map-marker-alt"></i> {{ $property->street ?? 'Street not specified' }}
                                    </div>
                                </div>
                            @endif
                            
                            <div class="property-features-list" style="margin-top: 2px; color: #007bff;"> 
                                @if($property->features && is_array($property->features) && count($property->features) > 0)
                                    <div class="features-tags">
                                        <span class="feature-icon"><i class="fas fa-building"></i></span>
                                        <span class="features-text" style="font-size: 0.95rem;">
                                            {{ implode(', ', array_slice($property->features, 0, 3)) }}
                                            @if(count($property->features) > 3), +{{ count($property->features) - 3 }} more @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-properties">No trending properties available</div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<hr class="feature-line">

<!-- Hot Deal Properties Section - UPDATED -->
<section class="property-section hot-deal" id="hotDealSection">
    <div class="container">
        <div class="section-header">
            <h2><i class="fas fa-fire"></i> Hot Deal Properties</h2>
            <a href="{{ route('dashboard.hot-deal') }}" class="view-more">
                View more <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="property-tabs">
            <a href="#" class="active" data-tab="hot-sales">Sales</a>
            <a href="#" data-tab="hot-rentals">Rentals</a>
            <a href="#" data-tab="hot-land">Land</a>
        </div>

        <!-- Sales Tab - Now uses $hotDealSales -->
        <div class="property-cards active" id="hot-sales">
            @forelse($hotDealSales as $property)
                <div class="property-card-mini" data-district="{{ $property->district }}" data-hot-deal="true">
                    <div class="property-img">
                        @php
                            $images = $property->images;
                            $imageUrl = null;
                            
                            if (!empty($images) && is_array($images) && !empty($images[0])) {
                                $imageUrl = 'http://localhost:8000/storage/' . $images[0];
                            } else {
                                $imageUrl = asset('images/placeholder.jpg');
                            }
                        @endphp
                        
                        <img src="{{ $imageUrl }}" alt="Hot Deal Property in {{ $property->district }}">
                        <!-- Show both manual and auto badges -->
                        @if($property->is_hot_deal)
                            <div class="badge hot"><i class="fas fa-fire"></i> HOT DEAL</div>
                        @elseif($property->is_hot_deal_calculated)
                            <div class="badge hot-auto"><i class="fas fa-bolt"></i> AUTO HOT DEAL</div>
                        @endif
                    </div>
                    <div class="property-details">
                        <div class="size-type-line">
                            <span class="property-size">
                                @if($property->property_type === 'land')
                                    {{ number_format($property->land_area ?? 0, 2) }} {{ $property->land_unit ?? 'Perches' }}
                                @else
                                    {{ number_format($property->floor_area ?? 0, 2) }} sq ft
                                @endif
                            </span>
                            <span class="property-type">{{ ucfirst($property->property_type) }}</span>
                            <i class="fas fa-star favorite-icon" data-property-id="{{ $property->id }}"></i>
                        </div>
                        <div class="property-price">
                            Rs. {{ number_format($property->price ?? 0, 2) }}
                            <span class="price-unit">Total Price</span>
                        </div>
                        <p class="property-description">
                            <a href="{{ route('sales.property-details', ['id' => $property->id]) }}">
                                {{ Str::limit($property->ad_description ?? 'No description', 80) }}
                            </a>
                        </p>
                    </div>
                </div>
            @empty
                <div class="no-properties" style="text-align: center; padding: 2rem; width: 100%;">
                    <p>No hot deal sales properties available</p>
                </div>
            @endforelse
        </div>

        <!-- Rentals Tab - Now uses $hotDealRentals -->
        <div class="property-cards" id="hot-rentals">
            @forelse($hotDealRentals as $property)
                <div class="property-card-mini" data-district="{{ $property->district }}" data-hot-deal="true">
                    <div class="property-img">
                        @php
                            $images = $property->images;
                            $imageUrl = null;
                            
                            if (!empty($images) && is_array($images) && !empty($images[0])) {
                                $imageUrl = 'http://localhost:8000/storage/' . $images[0];
                            } else {
                                $imageUrl = asset('images/placeholder.jpg');
                            }
                        @endphp
                        
                        <img src="{{ $imageUrl }}" alt="Hot Deal Property in {{ $property->district }}">
                        <!-- Show both manual and auto badges -->
                        @if($property->is_hot_deal)
                            <div class="badge hot"><i class="fas fa-fire"></i> HOT DEAL</div>
                        @elseif($property->is_hot_deal_calculated)
                            <div class="badge hot-auto"><i class="fas fa-bolt"></i> AUTO HOT DEAL</div>
                        @endif
                    </div>
                    <div class="property-details">
                        <div class="size-type-line">
                            <span class="property-size">
                                @if($property->property_type === 'land')
                                    {{ number_format($property->land_area ?? 0, 2) }} {{ $property->land_unit ?? 'Perches' }}
                                @else
                                    {{ number_format($property->floor_area ?? 0, 2) }} sq ft
                                @endif
                            </span>
                            <span class="property-type">{{ ucfirst($property->property_type) }}</span>
                            <i class="fas fa-star favorite-icon" data-property-id="{{ $property->id }}"></i>
                        </div>
                        <div class="property-price">
                            Rs. {{ number_format($property->price ?? 0, 2) }}
                            <span class="price-unit">
                                @if(in_array(strtolower($property->price_type ?? ''), ['per_month', 'monthly']))
                                    /month
                                @elseif(in_array(strtolower($property->price_type ?? ''), ['per_year', 'yearly']))
                                    /year
                                @else
                                    {{ $property->price_type ?? 'Total Price' }}
                                @endif
                            </span>
                        </div>
                        <p class="property-description">
                            <a href="{{ route('sales.property-details', ['id' => $property->id]) }}">
                                {{ Str::limit($property->ad_description ?? 'No description', 80) }}
                            </a>
                        </p>
                    </div>
                </div>
            @empty
                <div class="no-properties" style="text-align: center; padding: 2rem; width: 100%;">
                    <p>No hot deal rental properties available</p>
                </div>
            @endforelse
        </div>

        <!-- Land Tab - Now uses $hotDealLands -->
        <div class="property-cards" id="hot-land">
            @forelse($hotDealLands as $property)
                <div class="property-card-mini" data-district="{{ $property->district }}" data-hot-deal="true">
                    <div class="property-img">
                        @php
                            $images = $property->images;
                            $imageUrl = null;
                            
                            if (!empty($images) && is_array($images) && !empty($images[0])) {
                                $imageUrl = 'http://localhost:8000/storage/' . $images[0];
                            } else {
                                $imageUrl = asset('images/placeholder.jpg');
                            }
                        @endphp
                        
                        <img src="{{ $imageUrl }}" alt="Hot Deal Property in {{ $property->district }}">
                        <!-- Show both manual and auto badges -->
                        @if($property->is_hot_deal)
                            <div class="badge hot"><i class="fas fa-fire"></i> HOT DEAL</div>
                        @elseif($property->is_hot_deal_calculated)
                            <div class="badge hot-auto"><i class="fas fa-bolt"></i> AUTO HOT DEAL</div>
                        @endif
                    </div>
                    <div class="property-details">
                        <div class="size-type-line">
                            <span class="property-size">
                                {{ number_format($property->land_area ?? 0, 2) }} {{ $property->land_unit ?? 'Perches' }}
                            </span>
                            <span class="property-type">{{ ucfirst($property->property_type) }}</span>
                            <i class="fas fa-star favorite-icon" data-property-id="{{ $property->id }}"></i>
                        </div>
                        <div class="property-price">
                            Rs. {{ number_format($property->price ?? 0, 2) }}
                            <span class="price-unit">
                                @php
                                    $offerType = strtolower($property->offer_type ?? '');
                                    $priceType = strtolower($property->price_type ?? '');
                                    
                                    if (in_array($offerType, ['rent', 'rental', 'for rent']) || 
                                        in_array($priceType, ['per_month', 'monthly'])) {
                                        echo 'Per Month';
                                    } elseif (in_array($priceType, ['per_year', 'yearly'])) {
                                        echo 'Per Year';
                                    } else {
                                        echo 'Total Price';
                                    }
                                @endphp
                            </span>
                        </div>
                        <p class="property-description">
                            <a href="{{ route('sales.property-details', ['id' => $property->id]) }}">
                                {{ Str::limit($property->ad_description ?? 'No description', 80) }}
                            </a>
                        </p>
                    </div>
                </div>
            @empty
                <div class="no-properties" style="text-align: center; padding: 2rem; width: 100%;">
                    <p>No hot deal land properties available</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- Trending Properties Section - AUTO CALCULATED -->
<section class="property-section trending" id="trendingSection">
    <div class="container">
        <div class="section-header">
            <h2><i class="fas fa-chart-line"></i> Trending Properties</h2>
            <a href="{{ route('dashboard.trending') }}" class="view-more">View more <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="property-cards">
            @forelse($trendingProperties as $property)
                <div class="property-card-mini-trend" data-district="{{ $property->district }}" data-trending="true">
                    <div class="property-img">
                        @php
                            $images = $property->images;
                            $imageUrl = null;
                            
                            if (!empty($images) && is_array($images) && !empty($images[0])) {
                                $imageUrl = 'http://localhost:8000/storage/' . $images[0];
                            } else {
                                $imageUrl = asset('images/placeholder.jpg');
                            }
                        @endphp
                        
                        <img src="{{ $imageUrl }}" alt="Trending Property in {{ $property->district }}">
                        <!-- Show both manual and auto badges -->
                        @if($property->is_trending)
                            <div class="badge trending"><i class="fas fa-chart-line"></i> TRENDING</div>
                        @elseif($property->is_trending_calculated)
                            <div class="badge trending-auto"><i class="fas fa-bolt"></i> AUTO TRENDING</div>
                        @endif
                    </div>
                    <div class="property-details">
                        <div class="size-type-line">
                            <span class="property-size">
                                @if($property->property_type === 'land')
                                    {{ number_format($property->land_area ?? 0, 2) }} {{ $property->land_unit ?? 'Perches' }}
                                @else
                                    {{ number_format($property->floor_area ?? 0, 2) }} sq ft
                                @endif
                            </span>
                            <span class="property-type">{{ ucfirst($property->property_type) }}</span>
                            <i class="fas fa-star favorite-icon" data-property-id="{{ $property->id }}"></i>
                        </div>
                        <div class="property-price">
                            Rs. {{ number_format($property->price ?? 0, 2) }}
                            <span class="price-unit">
                                @php
                                    $offerType = strtolower($property->offer_type ?? '');
                                    $priceType = strtolower($property->price_type ?? '');
                                    
                                    if (in_array($offerType, ['rent', 'rental', 'for rent']) || 
                                        in_array($priceType, ['per_month', 'monthly'])) {
                                        echo 'Per Month';
                                    } elseif (in_array($priceType, ['per_year', 'yearly'])) {
                                        echo 'Per Year';
                                    } else {
                                        echo 'Total Price';
                                    }
                                @endphp
                            </span>
                        </div>
                        <p class="property-description">
                            <a href="{{ route('sales.property-details', ['id' => $property->id]) }}">
                                {{ Str::limit($property->ad_description ?? 'No description', 80) }}
                            </a>
                        </p>
                    </div>
                </div>
            @empty
                <div class="no-properties" style="text-align: center; padding: 2rem; width: 100%;">
                    <p>No trending properties available at the moment</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Top Districts Section -->
<section class="top-districts py-5">
  <div class="container">
    <div class="section-header text-center mb-4">
      <h2 class="fw-bold fs-2">Top Districts</h2>
   
    </div>

    <div class="district-grid">
      <a href="{{ route('destric.index', ['district' => 'Colombo']) }}" class="district-card">
        <span>Colombo</span>
      </a>
      <a href="{{ route('destric.index', ['district' => 'Gampaha']) }}" class="district-card">
        <span>Gampaha</span>
      </a>
      <a href="{{ route('destric.index', ['district' => 'Kaluthara']) }}" class="district-card">
        <span>Kaluthara</span>
      </a>
      <a href="{{ route('destric.index', ['district' => 'Kandy']) }}" class="district-card">
        <span>Kandy</span>
      </a>
      <a href="{{ route('destric.index', ['district' => 'Kegalle']) }}" class="district-card">
        <span>Kegalle</span>
      </a>

      @foreach(['Galle', 'Jaffna', 'Matara', 'Kurunegala', 'Negombo', 'Hambantota', 'Kilinochchi', 'Mannar', 'Matale', 'Anuradhapura', 'Polonnaruwa', 'Vavuniya', 'Puttalam', 'Rathnapura', 'Nuwara Eliya', 'Batticaloa', 'Badulla', 'Ampara', 'Mullaitivu', 'Trincomalee'] as $district)
        <a href="{{ route('destric.index', ['district' => $district]) }}" class="district-card">
          <span>{{ $district }}</span>
        </a>
      @endforeach
    </div>
  </div>
</section>

<!-- horizontal line -->
<hr class="feature-line">

<!-- About Section -->
<section class="about-section">
  <div class="container">
    <h2>About RALankaProperty</h2>
<p class="about-text">
  Established in 2007, LankaPropertyWeb.com (LPW) is currently Sri Lanka's number one and most visited property and apartment listing website /
  real estate platform with the highest number of <a href="#">Sri Lanka ads</a> for properties listed in the market.
  It has also been recognized as one of the best house sale and apartment rental sites in Sri Lanka by the large loyal home and apartment finder
  customer base.Following almost a decade in operation of house and property for sale in Sri Lanka, we have become the most popular place for Sri Lankans
  to buy, rent, and sell their properties. The site features a wide range of properties including houses, apartments, annexes, and lands
  for both rent and sale across all corners of the island.
  The website is open to anyone to submit their <a href="#">property for sale</a>, <a href="#">property for rent</a>, or <a href="#">land sales</a>.
  Detailed information on each property helps customers make informed decisions on housing choices all in one platform.
</p>


  </div>
</section>



<script>
document.addEventListener('DOMContentLoaded', function () {
    /* -----------------------
       Existing UI interactions
       ----------------------- */
    // Simple tab switching functionality
    document.querySelectorAll('.search-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.search-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });

//image circle
const images = [
    '/images/home2.jpg',
    '/images/home3.jpg',
    '/images/home4.jpg',
    '/images/home5.jpg'
];

let currentIndex = 0;

const mainImage = document.getElementById('mainImage');
const circles = document.querySelectorAll('.circle');

function updateImage(index) {
    mainImage.style.backgroundImage = `url('${images[index]}')`;
    // Update active circle
    circles.forEach(c => c.classList.remove('active'));
    if (circles[index]) circles[index].classList.add('active');
}

// Arrow events
document.getElementById('prevArrow').addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateImage(currentIndex);
});

document.getElementById('nextArrow').addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % images.length;
    updateImage(currentIndex);
});

// Circle click events
circles.forEach((circle, index) => {
    circle.addEventListener('click', () => {
        currentIndex = index;
        updateImage(currentIndex);
    });
});
    // Tab functionality for search forms
    const tabs = document.querySelectorAll('.search-tab');
    const forms = document.querySelectorAll('.search-form');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            forms.forEach(f => f.classList.remove('active'));
            const activeForm = document.getElementById(tab.dataset.tab);
            if (activeForm) activeForm.classList.add('active');
        });
    });

    // Hamburger Menu Toggle
    const menuToggle = document.getElementById('menuToggle');
    const heroNav = document.getElementById('heroNav');

    if (menuToggle) {
        menuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            heroNav.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!heroNav.contains(e.target) && !menuToggle.contains(e.target)) {
                heroNav.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        });

        // Close menu when clicking a nav link
        if (heroNav) {
            heroNav.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    heroNav.classList.remove('active');
                    menuToggle.classList.remove('active');
                });
            });
        }
    }

    // Side menu functionality
    const sideMenu = document.getElementById('sideMenu');
    const closeMenu = document.getElementById('closeMenu');

    if (menuToggle && sideMenu) {
        menuToggle.addEventListener('click', () => {
            sideMenu.classList.add('active');
        });
    }

    if (closeMenu) {
        closeMenu.addEventListener('click', () => {
            sideMenu.classList.remove('active');
        });
    }

    document.addEventListener('click', (e) => {
        if (sideMenu && !sideMenu.contains(e.target) && !menuToggle.contains(e.target) && sideMenu.classList.contains('active')) {
            sideMenu.classList.remove('active');
        }
    });

    // Hot Deal Tabs Functionality
    const hotDealTabs = document.querySelectorAll(".hot-deal .property-tabs a");
    const hotDealSections = document.querySelectorAll(".hot-deal .property-cards");

    hotDealTabs.forEach(tab => {
      tab.addEventListener("click", function(e) {
        e.preventDefault();

        hotDealTabs.forEach(t => t.classList.remove("active"));
        hotDealSections.forEach(sec => sec.classList.remove("active"));

        this.classList.add("active");

        const target = this.getAttribute("data-tab");
        const targetSection = document.getElementById(target);
        if (targetSection) {
          targetSection.classList.add("active");
        }
      });
    });

    // New Arrivals Carousel Functionality
    const newTrack = document.getElementById('newTrack');
    const newSlides = document.querySelectorAll('.new-arrivals-carousel .carousel-slide');
    const newPrev = document.getElementById('newPrev');
    const newNext = document.getElementById('newNext');
    const newDots = document.querySelectorAll('.carousel-dots-new .dot');

    let newCurrentSlide = 0;

    function updateNewCarousel(slideIndex) {
        if (newTrack && newSlides.length > 0) {
            newTrack.style.transform = `translateX(-${slideIndex * 100}%)`;
            newSlides.forEach(s => s.classList.remove('active'));
            if (newSlides[slideIndex]) newSlides[slideIndex].classList.add('active');
            newDots.forEach(d => d.classList.remove('active'));
            if (newDots[slideIndex]) newDots[slideIndex].classList.add('active');
        }
    }

    if (newPrev) {
        newPrev.addEventListener('click', () => {
            newCurrentSlide = (newCurrentSlide - 1 + newSlides.length) % newSlides.length;
            updateNewCarousel(newCurrentSlide);
        });
    }

    if (newNext) {
        newNext.addEventListener('click', () => {
            newCurrentSlide = (newCurrentSlide + 1) % newSlides.length;
            updateNewCarousel(newCurrentSlide);
        });
    }

    newDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            newCurrentSlide = index;
            updateNewCarousel(newCurrentSlide);
        });
    });

    // Close floating window
    const newArrivalsFloating = document.querySelector('.new-arrivals-floating');
    const closeFloating = document.querySelector('.close-floating');

    if (closeFloating) {
        closeFloating.addEventListener('click', () => {
            newArrivalsFloating.style.display = 'none';
        });
    }

    /* ---------------------------------------
       New: Top-districts -> link & filter
       --------------------------------------- */

    const districtButtons = document.querySelectorAll('.top-districts .district-grid button');
    const showcaseCards = document.querySelectorAll('#showcaseSection .property-card');
    const hotDealCards = document.querySelectorAll('#hotDealSection .property-card-mini');
    const trendingCards = document.querySelectorAll('#trendingSection .property-card-mini-trend');

    function normalizeDistrictName(name) {
      return name.trim().toLowerCase();
    }

    function filterByDistrict(districtName) {
      if (!districtName) return;

      const norm = normalizeDistrictName(districtName);

      function toggleList(list) {
        list.forEach(card => {
          const cardDistrict = card.getAttribute('data-district') || '';
          if (normalizeDistrictName(cardDistrict) === norm) {
            card.style.display = '';
          } else {
            card.style.display = 'none';
          }
        });
      }

      toggleList(showcaseCards);
      toggleList(hotDealCards);
      toggleList(trendingCards);
    }

    function clearDistrictFilter() {
      [...showcaseCards, ...hotDealCards, ...trendingCards].forEach(c => c.style.display = '');
      districtButtons.forEach(b => b.classList.remove('active'));
    }

    districtButtons.forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const district = button.getAttribute('data-district');
        if (!district) return;

        districtButtons.forEach(b => b.classList.remove('active'));
        button.classList.add('active');

        const showcase = document.getElementById('showcaseSection');
        if (showcase) {
          showcase.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        filterByDistrict(district);
      });
    });

    const districtFilterSelect = document.getElementById('districtFilterSelect');
    if (districtFilterSelect) {
      districtFilterSelect.addEventListener('change', () => {
        clearDistrictFilter();
      });
    }

});

/**
 * Client-side search/filter
 */

document.addEventListener('DOMContentLoaded', function () {
  const parseNumber = (str = '') => {
    const n = Number(String(str).replace(/[^0-9.-]+/g, '')) || 0;
    return n;
  };

  const normalize = (s = '') => String(s || '').toLowerCase().trim();

  const getCardData = (card) => {
    const district = normalize(card.getAttribute('data-district') || card.querySelector('.district-overlay')?.innerText);
    const typeEl = card.querySelector('.property-type') || card.querySelector('.size-type-line');
    const type = normalize(typeEl?.innerText || '');
    const size = normalize(card.querySelector('.property-size')?.innerText || '');
    const priceText = card.querySelector('.property-price')?.innerText || '';
    const price = parseNumber(priceText);
    const desc = normalize(card.querySelector('.property-description a')?.innerText || card.querySelector('.property-description')?.innerText || '');
    return { district, type, size, price, desc };
  };

  const allCardsSelector = '.property-card, .property-card-mini, .property-card-mini-trend';
  const allCards = () => Array.from(document.querySelectorAll(allCardsSelector));

  function getNoResultsBox(container) {
    let el = container.querySelector('#searchNoResults');
    if (!el) {
      el = document.createElement('div');
      el.id = 'searchNoResults';
      el.className = 'no-results';
      el.style.padding = '1rem';
      el.style.textAlign = 'center';
      el.style.color = '#333';
      el.style.display = 'none';
      container.appendChild(el);
    }
    return el;
  }

  function parseSelectedPrice(value) {
    if (!value) return null;
    const n = parseNumber(value);
    return n > 0 ? n : null;
  }

  function runSearch(form) {
    if (!form) return;
    const container = form.closest('.search-section') || form.parentNode;
    const noResults = getNoResultsBox(container);

    const textInput = form.querySelector('input.search-input[type="text"]');
    const text = normalize(textInput?.value);

    const selects = Array.from(form.querySelectorAll('select.search-input'));
    const selValues = selects.map(s => {
      const idx = s.selectedIndex;
      if (idx <= 0) return '';
      return s.options[idx].text || s.value || '';
    });

    const maybeMaxPrice = selValues.map(v => parseSelectedPrice(v)).find(v => v !== null) || null;
    const bedroomsSel = selValues.find(v => /\b[0-9]\+?\b/.test(v) && !/perch|sqft|sq\.ft/i.test(v)) || '';
    const typeSel = selValues.find(v => v && !/\b[0-9]/.test(v)) || '';

    const cards = allCards();
    let matched = [];

    cards.forEach(card => {
      const { district, type, size, price, desc } = getCardData(card);
      let ok = true;

      if (text) {
        ok = ok && (district.includes(text) || desc.includes(text) || type.includes(text));
      }

      if (typeSel) {
        const normType = normalize(typeSel);
        ok = ok && (type.includes(normType) || desc.includes(normType));
      }

      if (bedroomsSel) {
        const normBed = normalize(bedroomsSel);
        ok = ok && (size.includes(normBed) || desc.includes(normBed));
      }

      if (maybeMaxPrice) {
        if (price > 0) {
          ok = ok && (price <= maybeMaxPrice);
        }
      }

      if (ok) {
        matched.push(card);
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });

    if (matched.length === 0) {
      noResults.innerText = 'No results found. Try adjusting your filters.';
      noResults.style.display = 'block';
    } else {
      noResults.style.display = 'none';
      matched[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  }

  document.querySelectorAll('.search-form').forEach(form => {
    const btn = form.querySelector('.search-button');
    if (btn) {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        runSearch(form);
      });
    }

    form.querySelectorAll('input.search-input[type="text"]').forEach(inp => {
      inp.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
          e.preventDefault();
          runSearch(form);
        }
      });
    });
  });

  window.clearClientSearchFilters = function () {
    allCards().forEach(c => c.style.display = '');
    const boxes = document.querySelectorAll('#searchNoResults');
    boxes.forEach(b => b.style.display = 'none');
  };
});
// Auto-updating urgent badges
function updateUrgentTimers() {
    document.querySelectorAll('.urgent-timer').forEach(timer => {
        const expires = new Date(timer.dataset.expires);
        const now = new Date();
        const diff = expires - now;
        
        if (diff > 0) {
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            timer.textContent = `${hours}h ${minutes}m`;
        } else {
            timer.textContent = 'Expired';
            timer.parentElement.style.opacity = '0.6';
        }
    });
}

// Read more functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('read-more-btn')) {
        const targetId = e.target.dataset.target;
        const fullText = e.target.dataset.fullText;
        const descElement = document.getElementById(targetId);
        
        descElement.textContent = fullText;
        e.target.style.display = 'none';
    }
    
    // Toggle favorite
    if (e.target.classList.contains('favorite-icon')) {
        e.target.classList.toggle('active');
        const propertyId = e.target.dataset.propertyId;
        // Add your favorite toggle logic here
        console.log('Toggled favorite for property:', propertyId);
    }
    
    // Show all features when clicking "more features"
    if (e.target.classList.contains('more-features')) {
        const propertyCard = e.target.closest('.property-card');
        const featuresTags = propertyCard.querySelector('.features-tags');
        const features = @json($property->features ?? []); // This needs to be handled differently
        alert('All Features:\n' + features.join('\n'));
    }
});

// Update timers every minute
setInterval(updateUrgentTimers, 60000);
updateUrgentTimers(); // Initial call

// Click to expand description
document.querySelectorAll('.property-description').forEach(desc => {
    desc.addEventListener('click', function() {
        const container = this.closest('.property-description-container');
        const readMoreBtn = container.querySelector('.read-more-btn');
        if (readMoreBtn) {
            readMoreBtn.click();
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Initialize favorite icons
    initializeFavorites();
    
    function initializeFavorites() {
        const favoriteIcons = document.querySelectorAll('.favorite-icon');
        
        favoriteIcons.forEach(icon => {
            // Set initial state based on class
            if (icon.classList.contains('active')) {
                icon.style.color = '#ffd700';
                icon.setAttribute('title', 'Remove from favorites');
            } else {
                icon.style.color = '#ddd';
                icon.setAttribute('title', 'Add to favorites');
            }

            icon.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const propertyId = this.getAttribute('data-property-id');
                const icon = this;
                
                toggleFavorite(propertyId, icon);
            });
        });
    }
    
    function toggleFavorite(propertyId, icon) {
        // Check if user is logged in
        if (!isUserLoggedIn()) {
            showLoginAlert();
            return;
        }
        
        // Show loading state
        icon.classList.add('loading');
        icon.style.pointerEvents = 'none';
        
        // Make AJAX request to toggle favorite
        fetch('/favorites/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                property_id: propertyId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Remove loading state
            icon.classList.remove('loading');
            icon.style.pointerEvents = 'auto';
            
            if (data.success) {
                // Update icon state
                if (data.is_favorited) {
                    icon.classList.add('active');
                    icon.style.color = '#ffd700';
                    icon.setAttribute('title', 'Remove from favorites');
                    showToast('✓ Added to favorites!', 'success');
                } else {
                    icon.classList.remove('active');
                    icon.style.color = '#ddd';
                    icon.setAttribute('title', 'Add to favorites');
                    showToast('Removed from favorites', 'info');
                }
            } else {
                showToast(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            icon.classList.remove('loading');
            icon.style.pointerEvents = 'auto';
            showToast('Network error. Please try again.', 'error');
        });
    }
    
    function isUserLoggedIn() {
        // Check if user is logged in
        const userLoggedInMeta = document.querySelector('meta[name="user-logged-in"]');
        return userLoggedInMeta && userLoggedInMeta.getAttribute('content') === 'true';
    }
    
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }
    
    function showLoginAlert() {
        // SweetAlert or basic confirm
        if (confirm('You need to be logged in to save favorites. Would you like to log in now?')) {
            window.location.href = '/login?redirect=' + encodeURIComponent(window.location.href);
        }
    }
    
    function showToast(message, type = 'info') {
        // Remove existing toasts
        const existingToasts = document.querySelectorAll('.favorite-toast');
        existingToasts.forEach(toast => toast.remove());
        
        // Create new toast
        const toast = document.createElement('div');
        toast.className = `favorite-toast toast-${type}`;
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${getToastColor(type)};
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            z-index: 10000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideInRight 0.3s ease;
            font-size: 14px;
            max-width: 300px;
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }
        }, 3000);
    }
    
    function getToastColor(type) {
        const colors = {
            success: '#4CAF50',
            error: '#f44336',
            info: '#2196F3',
            warning: '#ff9800'
        };
        return colors[type] || colors.info;
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .favorite-icon.loading {
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    /* New Arrivals Floating Window Styles - Updated for Slideshow */
    .new-arrivals-floating {
        position: absolute;
        top: 20%;
        right: 5%;
        width: 320px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        z-index: 100;
        overflow: hidden;
        display: block;
    }

    .new-arrivals-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #007bff;
        color: white;
        font-weight: bold;
    }

    .close-floating {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }

    .new-arrivals-carousel {
        position: relative;
        height: 300px;
        overflow: hidden;
        display: flex;
        align-items: center;
    }

    .carousel-prev, .carousel-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.5);
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 2;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .carousel-prev {
        left: 10px;
    }

    .carousel-next {
        right: 10px;
    }

    .carousel-track {
        display: flex;
        transition: transform 0.3s ease;
        width: 100%;
        height: 100%;
    }

    .carousel-slide {
        min-width: 100%;
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 10px;
        box-sizing: border-box;
    }

    .new-arrival-card {
        display: flex;
        flex-direction: column;
        width: 45%;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
    }

    .property-image-small {
        margin-bottom: 8px;
    }

    .property-image-small img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
    }

    .district-small {
        font-size: 0.8rem;
        color: #007bff;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .size-type-line-small {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
        font-size: 0.8rem;
    }

    .property-price-small {
        font-weight: bold;
        color: #007bff;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .price-unit-small {
        font-size: 0.7rem;
        color: #666;
    }

    .property-location-small {
        color: #666;
        font-size: 0.75rem;
        margin: 0;
    }

    .carousel-dots-new {
        display: flex;
        justify-content: center;
        gap: 5px;
        padding: 10px;
        background: #f8f9fa;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ddd;
        cursor: pointer;
    }

    .dot.active {
        background: #007bff;
    }

    .new-arrivals-footer {
        padding: 10px 15px;
        text-align: center;
        border-top: 1px solid #eee;
    }

    .view-all-link {
        color: #007bff;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .view-all-link:hover {
        text-decoration: underline;
    }

    .no-properties-small {
        text-align: center;
        color: #999;
        font-style: italic;
        padding: 20px;
        width: 100%;
    }

    /* Mobile Responsiveness for Floating Window */
    @media (max-width: 768px) {
        .new-arrivals-floating {
            position: relative;
            width: 100%;
            top: auto;
            right: auto;
            margin: 20px 0;
        }

        .carousel-slide {
            flex-direction: column;
            gap: 10px;
        }

        .new-arrival-card {
            width: 100%;
        }
    }
`;
document.head.appendChild(style);

document.addEventListener('DOMContentLoaded', function() {
    const backgrounds = @json($activeBackgrounds);
    const heroOverlay = document.querySelector('.hero-overlay');
    let currentBg = 0;
    const changeTime = 3000; // 1 second

    function changeBackground() {
        if (backgrounds.length > 1) {
            currentBg = (currentBg + 1) % backgrounds.length;
            heroOverlay.style.backgroundImage = 
                `linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('${backgrounds[currentBg]}')`;
        }
    }
    
    // Start auto change every 1 second
    setInterval(changeBackground, changeTime);
});
</script>
@endsection