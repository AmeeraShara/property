{{-- resources/views/rent/index.blade.php --}}
@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/rent.css') }}">
@endpush

@section('content')

<!-- Search Header Section -->
<div class="search-header-section">
    <div class="search-header-container">
        <div class="search-wrapper">
            <input type="text" class="main-search-input" placeholder="Type in the name" id="searchInput">
            
            <div class="search-dropdown-group">
                <select class="header-dropdown" id="locationDropdown">
                    <option value="">All Locations</option>
                    <option>Badulla</option>
                    <option>Colombo</option>
                    <option>Kandy</option>
                    <option>Galle</option>
                    <option>Negombo</option>
                    <option>Kurunegala</option>
                </select>
                
                <select class="header-dropdown" id="propertyTypeDropdown">
                    <option value="">Property Type</option>
                     <option value="BareLand">Bare Land</option>
    <option value="LandWithHouse">Land with House</option>
    <option value="CoconutLand">Coconut Land</option>
    <option value="TeaLand">Tea Land</option>
    <option value="RubberLand">Rubber Land</option>
                </select>
                
                <select class="header-dropdown" id="priceRangeDropdown">
                    <option value="">Price Range</option>
                    <option>Under 50K</option>
                    <option>50K - 100K</option>
                    <option>100K - 200K</option>
                    <option>200K+</option>
                </select>
            </div>
            
            <button class="header-search-button" id="searchButton">
                Search
                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </div>
    </div>
</div>

<div class="page-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <span class="breadcrumb-link">
    <a href="{{ route('dashboard.index') }}">Home</a>
</span> 
> 
<span class="breadcrumb-link">
    <a href="{{ route('rent.index') }}">Rent</a>
</span>

        </div>
    </div>

    <!-- Page Title -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title" id="pageTitle">Properties for Land in Sri Lanka (856 properties)</h1>
        </div>
    </div>

    <div class="container">
        <div class="content-wrapper">
            <!-- Left Sidebar -->
            <aside class="sidebar-filter">
                <div class="filter-header">
                    <h3>Filter by</h3>
                    <button class="reset-filters" id="resetFilters" style="background: none; border: none; color: #fff; font-size: 12px; cursor: pointer; text-decoration: underline;">Reset</button>
                </div>

                <!-- All Properties -->
                <div class="filter-group">
                    <div class="filter-item active" data-filter-type="all">All</div>
                </div>

                <!-- Property Types -->
                <div class="filter-group">
       <div class="filter-item" data-filter-type="property" data-filter-value="BareLand">Bare Land - 2800</div>
<div class="filter-item" data-filter-type="property" data-filter-value="LandWithHouse">Land with House - 1500</div>
<div class="filter-item" data-filter-type="property" data-filter-value="CoconutLand">Coconut Land - 500</div>
<div class="filter-item" data-filter-type="property" data-filter-value="TeaLand">Tea Land - 200</div>
<div class="filter-item" data-filter-type="property" data-filter-value="RubberLand">Rubber Land - 180</div>


                </div>

                <!-- Filter by District -->
                <div class="filter-section">
                    <h4 class="filter-section-title">Filter by District</h4>
                    <div class="filter-list">
                        <div class="filter-item" data-filter-type="district" data-filter-value="Ampara">Ampara</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Colombo">Colombo</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Gampaha">Gampaha</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Kalutara">Kalutara</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Kandy">Kandy</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Kurunegala">Kurunegala</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Kaluthara">Kaluthara</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Ratnapura">Ratnapura</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Galle">Galle</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Jaffna">Jaffna</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Kilinochchi">Kilinochchi</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Puttalam">Puttalam</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Matara">Matara</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Kegalle">Kegalle</div>
                        <div class="filter-item" data-filter-type="district" data-filter-value="Vavuniya">Vavuniya</div>
                    </div>
                </div>
            </aside>

           <!-- Main Content -->
            <main class="main-content">
                <div class="properties-grid" id="propertiesGrid">
                    @forelse($posts as $post)
                        <div class="property-card" 
                             data-location="{{ $post->district }}" 
                             data-type="{{ $post->property_subtype }}" 
                             data-price="{{ $post->price }}"
                             data-hot-deal="{{ $post->is_hot_deal ? 'true' : 'false' }}"
                             data-trending="{{ $post->is_trending ? 'true' : 'false' }}"
                             data-auto-hot-deal="{{ $post->is_hot_deal_calculated ? 'true' : 'false' }}"
                             data-auto-trending="{{ $post->is_trending_calculated ? 'true' : 'false' }}">
                            
                        <div class="property-image-wrapper" style="position: relative;">
    @php
        // Access images correctly - assuming your Post model has images relationship/field
        $images = $post->images ?? []; // Changed from $property to $post
        $imageUrl = null;

        if (!empty($images) && is_array($images) && !empty($images[0])) {
            $imageUrl = asset('storage/' . $images[0]);
        }
    @endphp

    @if($imageUrl)
        <img src="{{ $imageUrl }}" 
             alt="{{ $post->ad_title ?? 'Property Image' }}" 
             class="property-image"
             style="width: 150%; height: auto; border-radius: 8px;">
    @else
        <div class="no-image-placeholder" 
             style="background: #f0f0f0; padding: 50px; text-align: center; border-radius: 8px;">
            NO IMAGE
        </div>
    @endif

    <!-- AUTO CALCULATED BADGES - Add these lines -->
    @if($post->is_hot_deal_calculated)
        <span class="badge-auto-hot-deal" style="position: absolute; top: 10px; left: 10px; background: linear-gradient(45deg, #FF6B35, #FF8E53); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: bold; z-index: 10;">
            <i class="fas fa-bolt"></i> AUTO HOT
        </span>
    @elseif($post->is_trending_calculated)
        <span class="badge-auto-trending" style="position: absolute; top: 10px; left: 10px; background: linear-gradient(45deg, #9C27B0, #E040FB); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: bold; z-index: 10;">
            <i class="fas fa-chart-line"></i> AUTO TRENDING
        </span>
    @endif

    <!-- Existing manual badges -->
    @if($post->is_hot_deal)
        <span class="badge-hot-deal" style="position: absolute; 
            @if($post->is_hot_deal_calculated) top: 40px; left: 10px; 
            @else top: 10px; left: 10px; @endif 
            background: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: bold; z-index: 10;">
            <i class="fas fa-fire"></i> HOT DEAL
        </span>
    @endif

    @if($post->is_trending)
        <span class="badge-trending" style="position: absolute; 
            @if($post->is_trending_calculated || $post->is_hot_deal_calculated) top: 40px; 
            @else top: 10px; @endif 
            left: @if($post->is_hot_deal) 100px; @else 10px; @endif 
            background: #ffc107; color: #000; padding: 4px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: bold; z-index: 10;">
            <i class="fas fa-star"></i> TRENDING
        </span>
    @endif

    @if($post->is_urgent)
        <span class="badge-urgent" style="position: absolute; 
            @if($post->is_hot_deal_calculated || $post->is_trending_calculated || $post->is_hot_deal || $post->is_trending) top: 70px; 
            @else top: 10px; @endif 
            left: 10px; background: #17a2b8; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: bold; z-index: 10;">
            <i class="fas fa-bolt"></i> URGENT
        </span>
    @endif

    <span class="badge-location" style="position: absolute; bottom: 10px; left: 10px; background: rgba(0,0,0,0.6); color: #fff; padding: 4px 8px; border-radius: 4px;">
        {{ $post->district }}
    </span>
</div>

                            
                            <div class="property-content">
                                <div class="property-meta">
                                    <span class="meta-badge">{{ $post->formatted_land_area }}</span>
                                    <button class="meta-badge">{{ ucfirst(str_replace('_', ' ', $post->property_subtype)) }}</button>
                                    <button class="btn-favorite">★</button>
                                </div>
                                
                                <div class="property-price-section">
                                    <span class="property-price">Rs. {{ number_format($post->price, 2) }}</span>
                                    <span class="property-price-unit">{{ $post->price_type }}</span>
                                    
                                    @if(($post->is_hot_deal || $post->is_hot_deal_calculated) && $post->original_price_calculated)
                                        <div class="price-discount">
                                            <span class="original-price">Rs. {{ number_format($post->original_price_calculated, 2) }}</span>
                                            <span class="discount-badge">{{ $post->discount_percentage_calculated }}% OFF</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <h3 class="property-title">{{ $post->ad_title }}</h3>
                       <p class="property-description">
    <a href="{{ route('sales.property-details', ['id' => $post->id]) }}" class="property-link">
        {{ Str::limit($post->ad_description ?? 'No description available', 120) }}
    </a>
</p>

                                
                                <div class="property-footer">
                                    @if($post->street)
                                        <span class="property-icon">📍 {{ $post->street }}</span>
                                    @endif
                                    
                                    @if($post->features_array)
                                        @foreach(array_slice($post->features_array, 0, 2) as $feature)
                                            <span class="property-icon">{{ $feature }}</span>
                                        @endforeach
                                    @endif
                                </div>

                                {{-- Debug info for development --}}
                                @if(app()->environment('local'))
                                <div style="font-size: 0.6rem; color: #888; margin-top: 5px; border-top: 1px dashed #ddd; padding-top: 3px;">
                                    Auto: {{ $post->dynamic_status ?? 'N/A' }} | 
                                    Hot: {{ $post->is_hot_deal_calculated ? 'Yes' : 'No' }} | 
                                    Trend: {{ $post->is_trending_calculated ? 'Yes' : 'No' }}
                                </div>
                                @endif
                                
                               <div class="property-actions">
    <a href="{{ route('sales.property-details', $post->id) }}" class="btn-view-details">
        View Details
    </a>
</div>

                            </div>
                        </div>
                    @empty
                        <div id="noResultsMessage" style="text-align: center; padding: 60px 20px; background: #fff; border-radius: 8px; margin: 20px 0; display: block;">
                            <svg style="width: 80px; height: 80px; margin: 0 auto 20px; opacity: 0.3; display: block;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <h3 style="font-size: 20px; margin-bottom: 10px; color: #333;">No Land Properties Found</h3>
                            <p style="color: #666; font-size: 14px;">Try adjusting your search filters to find more properties.</p>
                            <a href="{{ route('land.index') }}" class="btn-view-details" style="margin-top: 15px; display: inline-block;">Show All Properties</a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                    <div class="pagination-wrapper" id="paginationWrapper">
                        {{ $posts->links('vendor.pagination.custom') }}
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>

<!-- Properties Description Section -->
<div class="description-section">
    <div class="container">
        <h2 class="description-title">Properties for Land in Sri Lanka</h2>
        <p class="description-text">
            Finding the perfect rental property in Sri Lanka has never been easier. Whether you're looking for a cozy apartment in Colombo, a spacious house in Kandy, a luxurious villa in Galle, or a simple room in Negombo, we have a wide range of rental options to suit every need and budget. Our rental properties come fully equipped with modern amenities and are located in prime areas across the country. From short-term rentals for tourists to long-term leases for residents, we offer flexible rental terms to accommodate your specific requirements. Browse through our extensive collection of houses for rent, apartments for rent, rooms for rent, and commercial spaces for rent in Sri Lanka's most sought-after locations.
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all filter elements
    const searchInput = document.getElementById('searchInput');
    const locationDropdown = document.getElementById('locationDropdown');
    const propertyTypeDropdown = document.getElementById('propertyTypeDropdown');
    const priceRangeDropdown = document.getElementById('priceRangeDropdown');
    const searchButton = document.getElementById('searchButton');
    const resetButton = document.getElementById('resetFilters');
    
    const sidebarFilters = document.querySelectorAll('.filter-item');
    const propertyCards = document.querySelectorAll('.property-card');
    const pageTitle = document.getElementById('pageTitle');
    const propertiesGrid = document.getElementById('propertiesGrid');
    
    // Store current filters
    let currentFilters = {
        searchText: '',
        location: '',
        propertyType: '',
        priceRange: '',
        district: '',
        hotDeal: '',
        trending: ''
    };

    // Price range mapping (monthly rent)
    const priceRanges = {
        'Under 50K': { min: 0, max: 50000 },
        '50K - 100K': { min: 50000, max: 100000 },
        '100K - 200K': { min: 100000, max: 200000 },
        '200K+': { min: 200000, max: Infinity }
    };

    // Property type mapping - FIXED VERSION
    const propertyTypeMapping = {
        'BareLand': ['BareLand', 'bare land', 'bare', 'land'],
        'LandWithHouse': ['LandWithHouse', 'land with house', 'house with land'],
        'CoconutLand': ['CoconutLand', 'coconut land', 'coconut'],
        'TeaLand': ['TeaLand', 'tea land', 'tea'],
        'RubberLand': ['RubberLand', 'rubber land', 'rubber']
    };

    // Search button click handler
    searchButton.addEventListener('click', function(e) {
        e.preventDefault();
        performSearch();
    });

    // Enter key on search input
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch();
        }
    });

    // Dropdown change handlers
    locationDropdown.addEventListener('change', function() {
        currentFilters.location = this.value;
        // Update sidebar district filter
        updateSidebarFilter('district', this.value);
        performSearch();
    });

    propertyTypeDropdown.addEventListener('change', function() {
        currentFilters.propertyType = this.value;
        // Update sidebar property type filter
        updateSidebarFilter('property', this.value);
        performSearch();
    });

    priceRangeDropdown.addEventListener('change', function() {
        currentFilters.priceRange = this.value;
        performSearch();
    });

    // Function to update sidebar filters when dropdowns change
    function updateSidebarFilter(filterType, value) {
        if (filterType === 'district' && value) {
            document.querySelectorAll('[data-filter-type="district"]').forEach(f => {
                f.classList.remove('active');
                if (f.getAttribute('data-filter-value') === value) {
                    f.classList.add('active');
                }
            });
            document.querySelector('[data-filter-type="all"]').classList.remove('active');
            currentFilters.district = value;
        } else if (filterType === 'property' && value) {
            document.querySelectorAll('[data-filter-type="property"]').forEach(f => {
                f.classList.remove('active');
                if (f.getAttribute('data-filter-value') === value) {
                    f.classList.add('active');
                }
            });
            document.querySelector('[data-filter-type="all"]').classList.remove('active');
            currentFilters.propertyType = value;
        }
    }

    // Sidebar filter handlers
    sidebarFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            const filterType = this.getAttribute('data-filter-type');
            const filterValue = this.getAttribute('data-filter-value');
            
            // Handle "All" filter
            if (filterType === 'all') {
                // Remove active from all sidebar filters
                sidebarFilters.forEach(f => f.classList.remove('active'));
                this.classList.add('active');
                currentFilters.propertyType = '';
                currentFilters.district = '';
                
                // Reset dropdowns
                locationDropdown.selectedIndex = 0;
                propertyTypeDropdown.selectedIndex = 0;
                priceRangeDropdown.selectedIndex = 0;
                
                performSearch();
                return;
            }
            
            // Remove active class from filters in the same group
            if (filterType === 'property') {
                document.querySelectorAll('[data-filter-type="property"]').forEach(f => {
                    f.classList.remove('active');
                });
                document.querySelector('[data-filter-type="all"]').classList.remove('active');
                currentFilters.propertyType = filterValue;
                currentFilters.district = '';
                
                // Also update the header dropdown to match
                propertyTypeDropdown.value = filterValue;
            } else if (filterType === 'district') {
                document.querySelectorAll('[data-filter-type="district"]').forEach(f => {
                    f.classList.remove('active');
                });
                document.querySelector('[data-filter-type="all"]').classList.remove('active');
                currentFilters.district = filterValue;
                currentFilters.propertyType = '';
                
                // Also update the location dropdown to match
                locationDropdown.value = filterValue;
            }
            
            // Add active class to clicked filter
            this.classList.add('active');
            
            performSearch();
        });
    });

    // Reset filters
    resetButton.addEventListener('click', function(e) {
        e.preventDefault();
        resetFilters();
    });

    // Main search function
    function performSearch() {
        currentFilters.searchText = searchInput.value.toLowerCase().trim();
        
        let visibleCount = 0;
        
        propertyCards.forEach(card => {
            if (matchesFilters(card)) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update page title with count
        updateResultsCount(visibleCount);
        
        // Show no results message if needed
        showNoResultsMessage(visibleCount);
    }

    // Check if card matches all current filters - COMPLETELY FIXED VERSION
    function matchesFilters(card) {
        const title = card.querySelector('.property-title')?.textContent.toLowerCase() || '';
        const description = card.querySelector('.property-description')?.textContent.toLowerCase() || '';
        const location = card.getAttribute('data-location')?.toLowerCase() || '';
        const propertyType = card.getAttribute('data-type')?.toLowerCase() || '';
        const price = parseFloat(card.getAttribute('data-price')) || 0;
        const isHotDeal = card.getAttribute('data-hot-deal') === 'true';
        const isTrending = card.getAttribute('data-trending') === 'true';
        const isAutoHotDeal = card.getAttribute('data-auto-hot-deal') === 'true';
        const isAutoTrending = card.getAttribute('data-auto-trending') === 'true';
        
        // Combine searchable text
        const searchableText = title + ' ' + description + ' ' + location + ' ' + propertyType;
        
        // Search text filter
        if (currentFilters.searchText && !searchableText.includes(currentFilters.searchText)) {
            return false;
        }
        
        // Location filter (header dropdown)
        if (currentFilters.location && !location.includes(currentFilters.location.toLowerCase())) {
            return false;
        }
        
        // District filter (sidebar)
        if (currentFilters.district && !location.includes(currentFilters.district.toLowerCase())) {
            return false;
        }
        
        // Property type filter - COMPLETELY FIXED
        if (currentFilters.propertyType) {
            const filterType = currentFilters.propertyType.toLowerCase();
            const cardPropertyType = card.getAttribute('data-type')?.toLowerCase() || '';
            
            // Use property type mapping for flexible matching
            let matches = false;
            
            // Check if card property type matches any of the mapped values
            Object.keys(propertyTypeMapping).forEach(key => {
                if (propertyTypeMapping[key].includes(filterType) || 
                    propertyTypeMapping[key].includes(cardPropertyType)) {
                    if (filterType === key.toLowerCase() || 
                        cardPropertyType === key.toLowerCase() ||
                        propertyTypeMapping[key].includes(filterType)) {
                        matches = true;
                    }
                }
            });
            
            // Direct match as fallback
            if (!matches && filterType !== cardPropertyType) {
                return false;
            }
        }
        
        // Price range filter
        if (currentFilters.priceRange && priceRanges[currentFilters.priceRange]) {
            const range = priceRanges[currentFilters.priceRange];
            if (price < range.min || price > range.max) {
                return false;
            }
        }
        
        // Hot deal filter (if you want to add this feature)
        if (currentFilters.hotDeal && !isHotDeal && !isAutoHotDeal) {
            return false;
        }
        
        // Trending filter (if you want to add this feature)
        if (currentFilters.trending && !isTrending && !isAutoTrending) {
            return false;
        }
        
        return true;
    }

    // Update results count in page title
    function updateResultsCount(count) {
        if (pageTitle) {
            const baseText = 'Properties for Rent in Sri Lanka';
            pageTitle.textContent = `${baseText} (${count} ${count === 1 ? 'property' : 'properties'})`;
        }
    }

    // Show/hide no results message
    function showNoResultsMessage(count) {
        let noResultsMsg = document.getElementById('noResultsMessage');
        const paginationWrapper = document.getElementById('paginationWrapper');
        
        if (count === 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'noResultsMessage';
                noResultsMsg.style.cssText = 'text-align: center; padding: 60px 20px; background: #fff; border-radius: 8px; margin: 20px 0; display: block;';
                noResultsMsg.innerHTML = `
                    <svg style="width: 80px; height: 80px; margin: 0 auto 20px; opacity: 0.3; display: block;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <h3 style="font-size: 20px; margin-bottom: 10px; color: #333;">No Properties Found</h3>
                    <p style="color: #666; font-size: 14px;">Try adjusting your search filters to find more properties.</p>
                    <button class="btn-view-details" style="margin-top: 15px; display: inline-block; cursor: pointer;" id="resetFiltersBtn">Reset All Filters</button>
                `;
                propertiesGrid.parentElement.insertBefore(noResultsMsg, paginationWrapper);
                
                // Add event listener to reset button in no results message
                document.getElementById('resetFiltersBtn').addEventListener('click', resetFilters);
            }
            noResultsMsg.style.display = 'block';
            if (paginationWrapper) {
                paginationWrapper.style.display = 'none';
            }
        } else {
            if (noResultsMsg) {
                noResultsMsg.style.display = 'none';
            }
            if (paginationWrapper) {
                paginationWrapper.style.display = 'flex';
            }
        }
    }

    // Reset filters function
    function resetFilters() {
        currentFilters = {
            searchText: '',
            location: '',
            propertyType: '',
            priceRange: '',
            district: '',
            hotDeal: '',
            trending: ''
        };
        
        searchInput.value = '';
        locationDropdown.selectedIndex = 0;
        propertyTypeDropdown.selectedIndex = 0;
        priceRangeDropdown.selectedIndex = 0;
        
        sidebarFilters.forEach(f => f.classList.remove('active'));
        document.querySelector('[data-filter-type="all"]').classList.add('active');
        
        performSearch();
    }

    // Favorite button functionality
    document.querySelectorAll('.btn-favorite').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('favorited');
            if (this.classList.contains('favorited')) {
                this.style.backgroundColor = '#ff6b6b';
                this.style.color = '#fff';
                this.style.borderColor = '#ff6b6b';
            } else {
                this.style.backgroundColor = '';
                this.style.color = '';
                this.style.borderColor = '#ddd';
            }
        });
    });

    // Enhanced property type filtering with better matching
    function enhancePropertyTypeFiltering() {
        // Add data attributes for better filtering
        propertyCards.forEach(card => {
            const propertyType = card.getAttribute('data-type');
            const metaBadge = card.querySelector('.meta-badge');
            
            // Ensure data-type attribute is properly set
            if (!propertyType && metaBadge) {
                const badgeText = metaBadge.textContent.toLowerCase().trim();
                let dataType = '';
                
                if (badgeText.includes('bare')) dataType = 'BareLand';
                else if (badgeText.includes('house')) dataType = 'LandWithHouse';
                else if (badgeText.includes('coconut')) dataType = 'CoconutLand';
                else if (badgeText.includes('tea')) dataType = 'TeaLand';
                else if (badgeText.includes('rubber')) dataType = 'RubberLand';
                
                if (dataType) {
                    card.setAttribute('data-type', dataType);
                }
            }
        });
    }

    // Debug function to check all property types
    function debugPropertyTypes() {
        console.log('=== PROPERTY TYPE DEBUG ===');
        propertyCards.forEach((card, index) => {
            const type = card.getAttribute('data-type');
            const title = card.querySelector('.property-title')?.textContent;
            const badge = card.querySelector('.meta-badge')?.textContent;
            console.log(`Card ${index + 1}:`, {
                dataType: type,
                title: title,
                badge: badge
            });
        });
        console.log('=== END DEBUG ===');
    }

    // Initialize
    enhancePropertyTypeFiltering();
    updateResultsCount(propertyCards.length);
    
    // Debug function to check filter values
    window.debugFilters = function() {
        console.log('Current Filters:', currentFilters);
        console.log('Property Types:', Array.from(propertyCards).map(card => card.getAttribute('data-type')));
        debugPropertyTypes();
    };

    // Auto debug on load
    setTimeout(debugPropertyTypes, 1000);
});
</script>
@endpush