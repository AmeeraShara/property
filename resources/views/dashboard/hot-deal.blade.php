{{-- resources/views/dashboard/hot-deal.blade.php --}}
@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/hot-deal.css') }}">
@endpush

@section('content')

<!-- Navbar -->
<nav class="hero-nav" id="heroNav">
    <ul>
        <li><a href="{{ route('sales.index') }}">Sales</a></li>
        <li><a href="{{ route('rent.index') }}">Rentals</a></li>
        <li><a href="{{ route('land.index') }}">Land</a></li>   
        <li><a href="#">Our Services</a></li> 
        <li><a href="#">Wanted</a></li>
    </ul>
</nav>

<div class="page-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <span class="breadcrumb-link">
                <a href="{{ route('dashboard.index') }}">Home</a>
            </span> 
            > 
            <span class="breadcrumb-link">
                <a href="{{ route('dashboard.hot-deal') }}">Hot Deal Properties</a>
            </span>
        </div>
    </div>

    <!-- Page Title -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title" id="pageTitle">
                <i class="fas fa-fire" style="color: #ff4500;"></i> Hot Deal Properties
            </h1>
        </div>
    </div>

  

    <div class="container">
        <div class="content-wrapper">
            <!-- Hot Deal Properties Section -->
            <section class="property-section hot-deal" id="hotDealSection">
                <div class="container">
                    <!-- AUTO CALCULATED HOT DEALS -->
                    <div class="property-cards active" id="all-tab">
                        @forelse($hotDealProperties as $property)
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
                                    <div class="badge hot"><i class="fas fa-fire"></i> HOT DEAL</div>
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
                                        <i class="fas fa-star"></i>
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
                                <p>No hot deal properties available at the moment</p>
                            </div>
                        @endforelse
                    </div>

                   
            </section>
   <!-- Pagination -->
@if(method_exists($hotDealProperties, 'hasPages') && $hotDealProperties->hasPages())
    <div class="pagination-container">
        {{ $hotDealProperties->links() }}
    </div>
@endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.filter-tabs .tab');
    const propertyCards = document.querySelectorAll('.property-cards');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            tab.classList.add('active');
            
            // Hide all property cards
            propertyCards.forEach(card => {
                card.classList.remove('active');
            });
            
            // Show the corresponding property cards
            const tabName = tab.getAttribute('data-tab');
            const targetElement = document.getElementById(tabName + '-tab');
            if (targetElement) {
                targetElement.classList.add('active');
            }
        });
    });
});
</script>
@endpush