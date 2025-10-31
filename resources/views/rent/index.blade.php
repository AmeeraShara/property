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
                    <option>House</option>
                    <option>Apartment</option>
                    <option>Villa</option>
                    <option>Room</option>
                    <option>Commercial</option>
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
            <h1 class="page-title" id="pageTitle">Properties for Rent in Sri Lanka (856 properties)</h1>
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
                    <div class="filter-item" data-filter-type="property" data-filter-value="BareLand">Houses - 2800</div>
                    <div class="filter-item" data-filter-type="property" data-filter-value="Apartment">Apartment - 3200</div>
                    <div class="filter-item" data-filter-type="property" data-filter-value="Villa">Villas - 180</div>
                    <div class="filter-item" data-filter-type="property" data-filter-value="Room">Rooms - 1500</div>
                    <div class="filter-item" data-filter-type="property" data-filter-value="Commercial">Commercial - 156</div>
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
        <!-- Dynamic Properties from Database -->
        @forelse($posts as $post)
        <div class="property-card" 
             data-location="{{ $post->city }}" 
             data-type="{{ $post->property_type }}" 
             data-price="{{ $post->price }}"
             data-hot-deal="{{ $post->is_hot_deal ? 'true' : 'false' }}"
             data-trending="{{ $post->is_trending ? 'true' : 'false' }}"
             data-auto-hot-deal="{{ $post->is_hot_deal_calculated ? 'true' : 'false' }}"
             data-auto-trending="{{ $post->is_trending_calculated ? 'true' : 'false' }}">
            
           <div class="property-image-wrapper" style="position: relative;">
    @php
        // Determine the correct image URL
        if(!empty($post->images) && is_array($post->images) && !empty($post->images[0])) {
            $imageUrl = asset('storage/' . $post->images[0]);
        } else {
            $imageUrl = asset('images/rent/default-property.jpg');
        }
    @endphp

    <img src="{{ $imageUrl }}" 
         alt="{{ $post->ad_title ?? 'Property Image' }}" 
         class="property-image" 
         style="width: 100%; height: auto; border-radius: 8px;">

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
        {{ $post->city }}
    </span>
</div>

            
            <div class="property-content">
                <div class="property-meta">
                    <span class="meta-badge">
                        @if($post->floor_area)
                            {{ $post->floor_area }} sqft
                        @elseif($post->land_area)
                            {{ $post->land_area }} {{ $post->land_unit ?? 'Perches' }}
                        @else
                            N/A
                        @endif
                    </span>
                    <button class="meta-badge">{{ ucfirst($post->property_type) }}</button>
                    <button class="btn-favorite">★</button>
                </div>
                
                <div class="property-price-section">
                    <span class="property-price">Rs. {{ number_format($post->price, 0) }}</span>
                    <span class="property-price-unit">Per Month</span>
                    
                    @if($post->is_hot_deal || $post->is_hot_deal_calculated)
                        <div class="price-discount">
                            @php
                                $originalPrice = $post->price * 1.3; // 30% higher for demo
                            @endphp
                            <span class="original-price">Rs. {{ number_format($originalPrice, 0) }}</span>
                            <span class="discount-badge">23% OFF</span>
                        </div>
                    @endif
                </div>
                
               <p class="property-description">
    <a href="{{ route('sales.property-details', ['id' => $post->id]) }}" class="property-link">
        {{ $post->ad_title ?? 'No title available' }}
    </a>
</p>

                
                <div class="property-footer">
                    @if($post->bedrooms)
                        <span class="property-icon">👥 {{ $post->bedrooms }} Bedrooms</span>
                    @endif
                    @if($post->bathrooms)
                        <span class="property-icon">🚿 {{ $post->bathrooms }} Bathrooms</span>
                    @endif
                </div>

                {{-- Debug info for development --}}
                @if(app()->environment('local'))
                <div style="font-size: 0.6rem; color: #888; margin-top: 5px; border-top: 1px dashed #ddd; padding-top: 3px;">
                    Auto: {{ $post->dynamic_status }} | 
                    Hot: {{ $post->is_hot_deal_calculated ? 'Yes' : 'No' }} | 
                    Trend: {{ $post->is_trending_calculated ? 'Yes' : 'No' }}
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="no-properties-message">
            <h3>No rental properties found</h3>
            <p>There are currently no properties available for rent.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="pagination-wrapper">
        {{ $posts->links() }}
    </div>
    @endif
</main>
        </div>
    </div>
</div>

<!-- Properties Description Section -->
<div class="description-section">
    <div class="container">
        <h2 class="description-title">Properties for Rent in Sri Lanka</h2>
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
        performSearch();
    });

    propertyTypeDropdown.addEventListener('change', function() {
        currentFilters.propertyType = this.value;
        performSearch();
    });

    priceRangeDropdown.addEventListener('change', function() {
        currentFilters.priceRange = this.value;
        performSearch();
    });

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
            } else if (filterType === 'district') {
                document.querySelectorAll('[data-filter-type="district"]').forEach(f => {
                    f.classList.remove('active');
                });
                document.querySelector('[data-filter-type="all"]').classList.remove('active');
                currentFilters.district = filterValue;
                currentFilters.propertyType = '';
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

    // Check if card matches all current filters
    function matchesFilters(card) {
        const description = card.querySelector('.property-description').textContent.toLowerCase();
        const location = card.getAttribute('data-location').toLowerCase();
        const propertyType = card.getAttribute('data-type').toLowerCase();
        const price = parseFloat(card.getAttribute('data-price'));
        const isHotDeal = card.getAttribute('data-hot-deal') === 'true';
        const isTrending = card.getAttribute('data-trending') === 'true';
        const isAutoHotDeal = card.getAttribute('data-auto-hot-deal') === 'true';
        const isAutoTrending = card.getAttribute('data-auto-trending') === 'true';
        
        // Search text filter
        if (currentFilters.searchText && !description.includes(currentFilters.searchText) && 
            !location.includes(currentFilters.searchText) && !propertyType.includes(currentFilters.searchText)) {
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
        
        // Property type filter
        if (currentFilters.propertyType) {
            const filterType = currentFilters.propertyType.toLowerCase();
            if (!propertyType.includes(filterType)) {
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
        
        if (count === 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'noResultsMessage';
                noResultsMsg.style.cssText = 'text-align: center; padding: 60px 20px; background: #fff; border-radius: 8px; margin: 20px 0;';
                noResultsMsg.innerHTML = `
                    <svg style="width: 80px; height: 80px; margin: 0 auto 20px; opacity: 0.3; display: block;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <h3 style="font-size: 20px; margin-bottom: 10px; color: #333;">No Properties Found</h3>
                    <p style="color: #666; font-size: 14px;">Try adjusting your search filters to find more properties.</p>
                `;
                propertiesGrid.parentElement.insertBefore(noResultsMsg, document.getElementById('paginationWrapper'));
            }
            noResultsMsg.style.display = 'block';
            document.getElementById('paginationWrapper').style.display = 'none';
        } else {
            if (noResultsMsg) {
                noResultsMsg.style.display = 'none';
            }
            document.getElementById('paginationWrapper').style.display = 'flex';
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

    // Initial count on page load
    updateResultsCount(propertyCards.length);
});
</script>
@endpush