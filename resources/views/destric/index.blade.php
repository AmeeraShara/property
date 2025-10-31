@extends('layouts.app')

@section('title', 'Properties in ' . $district . ' - RALankaProperty')

@section('content')
<link rel="stylesheet" href="{{ asset('css/destric.css') }}">

<div class="destric-container">
    <!-- Header Section -->
    <div class="destric-header">
        <div class="container">
            <div class="breadcrumb-section">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Home</a> 
                > 
                <span class="breadcrumb-current">Properties in {{ $district }}</span>
            </div>
            
            <h1 class="page-title">
                Properties in {{ $district }}
                <span class="property-count">({{ $counts['all'] }} properties found)</span>
            </h1>
            
            <p class="district-description">
                Discover the best properties for sale and rent in {{ $district }} district
            </p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="destric-tabs">
        <div class="container">
            <div class="tab-nav">
                <a href="{{ route('destric.index', ['district' => $district, 'offer_type' => 'all']) }}" 
                   class="tab-link {{ $offerType == 'all' ? 'active' : '' }}">
                    All Properties <span class="tab-count">({{ $counts['all'] }})</span>
                </a>
                <a href="{{ route('destric.index', ['district' => $district, 'offer_type' => 'sale']) }}" 
                   class="tab-link {{ $offerType == 'sale' ? 'active' : '' }}">
                    For Sale <span class="tab-count">({{ $counts['sale'] }})</span>
                </a>
                <a href="{{ route('destric.index', ['district' => $district, 'offer_type' => 'rent']) }}" 
                   class="tab-link {{ $offerType == 'rent' ? 'active' : '' }}">
                    For Rent <span class="tab-count">({{ $counts['rent'] }})</span>
                </a>
                <a href="{{ route('destric.index', ['district' => $district, 'offer_type' => 'land']) }}" 
                   class="tab-link {{ $offerType == 'land' ? 'active' : '' }}">
                    Land <span class="tab-count">({{ $counts['land'] }})</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container main-content">
        <div class="content-wrapper">
            <!-- Main Properties Grid -->
            <main class="properties-main">
                @if($properties->count() > 0)
                    <div class="properties-info-bar">
                        <p class="showing-text">
                            Showing {{ $properties->firstItem() }} - {{ $properties->lastItem() }} of {{ $properties->total() }} properties
                            @if($offerType != 'all')
                                for {{ $offerType }}
                            @endif
                            in {{ $district }}
                        </p>
                    </div>

                    <div class="properties-grid">
                        @foreach($properties as $property)
                            <div class="property-card {{ $property->property_type == 'land' ? 'land-property' : '' }}">
                                <div class="property-image">
                                    @php
                                        $images = $property->images;
                                        $imageUrl = null;
                                        
                                        if (!empty($images) && is_array($images) && !empty($images[0])) {
                                            $imageUrl = 'http://localhost:8000/storage/' . $images[0];
                                        }
                                    @endphp

                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="Property in {{ $property->district }}">
                                    @else
                                        <div class="no-image {{ $property->property_type == 'land' ? 'land-icon' : '' }}">
                                            <i class="fas {{ $property->property_type == 'land' ? 'fa-mountain' : 'fa-home' }}"></i>
                                            <span>{{ $property->property_type == 'land' ? 'No Land Image' : 'No Image' }}</span>
                                        </div>
                                    @endif

                                    <div class="property-badges">
                                        <div class="district-badge">{{ $property->district }}</div>
                                        @if($property->property_type == 'land')
                                            <div class="land-badge">Land</div>
                                        @endif
                                        @if($property->is_hot_deal)
                                            <div class="hot-deal-badge">Hot Deal</div>
                                        @endif
                                        @if($property->is_featured)
                                            <div class="featured-badge">Featured</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="property-content">
                                    <div class="property-header">
                                        <h3 class="property-title">
                                            <a href="{{ route('sales.property-details', ['id' => $property->id]) }}">
                                                {{ $property->ad_title ?? 'No Title' }}
                                            </a>
                                        </h3>
                                        <div class="property-price">
                                            Rs. {{ number_format($property->price, 2) }}
                                            @if($property->price_type == 'per_month')
                                                <span class="price-period">/month</span>
                                            @elseif($property->price_type == 'per_year')
                                                <span class="price-period">/year</span>
                                            @elseif($property->price_type == 'per_perch')
                                                <span class="price-period">/perch</span>
                                            @elseif($property->price_type == 'per_acre')
                                                <span class="price-period">/acre</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="property-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $property->city ?? 'Unknown City' }}, {{ $property->district }}
                                    </div>

                                    <div class="property-description">
                                        {{ Str::limit($property->ad_description, 120) }}
                                    </div>

                                    <div class="property-features">
                                        @if($property->property_type == 'land')
                                            <!-- Land Specific Features -->
                                            @if($property->land_size)
                                                <div class="feature">
                                                    <i class="fas fa-arrows-alt"></i>
                                                    <span>{{ number_format($property->land_size) }} 
                                                        @if($property->land_unit)
                                                            {{ $property->land_unit }}
                                                        @else
                                                            perch
                                                        @endif
                                                    </span>
                                                </div>
                                            @elseif($property->floor_area)
                                                <div class="feature">
                                                    <i class="fas fa-arrows-alt"></i>
                                                    <span>{{ number_format($property->floor_area) }} 
                                                        @if($property->land_unit)
                                                            {{ $property->land_unit }}
                                                        @else
                                                            perch
                                                        @endif
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            @if($property->property_subtype)
                                                <div class="feature">
                                                    <i class="fas fa-tag"></i>
                                                    <span>{{ ucfirst($property->property_subtype) }}</span>
                                                </div>
                                            @endif
                                        @else
                                            <!-- House/Apartment Features -->
                                            @if($property->bedrooms)
                                                <div class="feature">
                                                    <i class="fas fa-bed"></i>
                                                    <span>{{ $property->bedrooms }} Bed</span>
                                                </div>
                                            @endif
                                            @if($property->bathrooms)
                                                <div class="feature">
                                                    <i class="fas fa-bath"></i>
                                                    <span>{{ $property->bathrooms }} Bath</span>
                                                </div>
                                            @endif
                                            @if($property->floor_area)
                                                <div class="feature">
                                                    <i class="fas fa-arrows-alt"></i>
                                                    <span>{{ number_format($property->floor_area) }} sq ft</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="property-footer">
                                        <div class="property-type">
                                            @if($property->property_type == 'land')
                                                <i class="fas fa-mountain"></i>
                                                Land
                                                @if($property->property_subtype)
                                                    - {{ ucfirst($property->property_subtype) }}
                                                @endif
                                            @else
                                                <i class="fas fa-home"></i>
                                                {{ ucfirst($property->property_type) }}
                                                @if($property->property_subtype)
                                                    - {{ $property->property_subtype }}
                                                @endif
                                            @endif
                                        </div>
                                        <div class="property-offer-type {{ $property->offer_type }}">
                                            {{ ucfirst($property->offer_type) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $properties->appends(['offer_type' => $offerType])->links() }}
                    </div>
                @else
                    <div class="no-properties">
                        <div class="no-properties-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h3>No Properties Found in {{ $district }}</h3>
                        <p>
                            @if($offerType != 'all')
                                There are currently no properties for {{ $offerType }} in {{ $district }} district.
                            @else
                                There are currently no properties available in {{ $district }} district.
                            @endif
                        </p>
                      
                        <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Home
                        </a>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection