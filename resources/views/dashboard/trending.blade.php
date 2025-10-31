{{-- resources/views/dashboard/trending.blade.php --}}
@extends('layouts.app')

@push('styles')
<style>
    .trending-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .property-card-mini-trend {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: 1px solid #e8e8e8;
    }

    .property-card-mini-trend:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .property-img {
        width: 100%;
        height: 220px;
        position: relative;
        overflow: hidden;
    }

    .property-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .property-card-mini-trend:hover .property-img img {
        transform: scale(1.05);
    }

    .badge.trending {
        position: absolute;
        top: 12px;
        left: 12px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 8px 14px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
        animation: trendingPulse 2s ease-in-out infinite;
        z-index: 2;
    }

    @keyframes trendingPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .property-details {
        padding: 20px;
    }

    .size-type-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        font-size: 0.9rem;
        color: #666;
    }

    .property-price {
        font-size: 1.4rem;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 12px;
    }

    .price-unit {
        font-size: 0.8rem;
        color: #7f8c8d;
        font-weight: normal;
    }

    .property-description {
        color: #5d6d7e;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .property-description a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .property-description a:hover {
        color: #1167b1;
    }

    /* Pagination Styles */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 40px;
        padding: 20px 0;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 8px;
    }

    .pagination li {
        margin: 0;
    }

    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 10px 16px;
        border: 1px solid #ddd;
        border-radius: 6px;
        text-decoration: none;
        color: #1167b1;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .pagination li a:hover {
        background: #1167b1;
        color: white;
        border-color: #1167b1;
    }

    .pagination li.active span {
        background: #1167b1;
        color: white;
        border-color: #1167b1;
    }

    .pagination li.disabled span {
        color: #6c757d;
        background: #f8f9fa;
        border-color: #dee2e6;
        cursor: not-allowed;
    }

    .results-count {
        text-align: center;
        color: #6c757d;
        margin-bottom: 30px;
        font-size: 1rem;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .trending-container {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .trending-container {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .property-img {
            height: 200px;
        }
    }

    @media (max-width: 480px) {
        .property-details {
            padding: 15px;
        }
        
        .property-price {
            font-size: 1.2rem;
        }
        
        .size-type-line {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
    }
</style>
@endpush

@section('content')

<!-- Include Bootstrap CSS in <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg" style="background-color: #1167b1;">
  <div class="container justify-content-center">
    <ul class="navbar-nav">
      <li class="nav-item mx-3">
        <a class="nav-link text-white text-center" href="{{ route('sales.index') }}">Sales</a>
      </li>
      <li class="nav-item mx-3">
        <a class="nav-link text-white text-center" href="{{ route('rent.index') }}">Rentals</a>
      </li>
      <li class="nav-item mx-3">
        <a class="nav-link text-white text-center" href="{{ route('land.index') }}">Land</a>
      </li>
      <li class="nav-item mx-3">
        <a class="nav-link text-white text-center" href="#">Our Services</a>
      </li>
      <li class="nav-item mx-3">
        <a class="nav-link text-white text-center" href="#">Wanted</a>
      </li>
    </ul>
  </div>
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
                <a href="{{ route('dashboard.trending') }}">Trending Properties</a>
            </span>
        </div>
    </div>

  <!-- Page Title -->
<div class="page-header text-center py-4">
    <div class="container">
        <h1 class="page-title" id="pageTitle">
            <i class="fas fa-chart-line" style="color: #28a745;"></i> Trending Properties
        </h1>
        
    </div>
</div>


    <div class="container">
        <div class="content-wrapper">
            <!-- Trending Properties Section -->
            <section class="property-section trending" id="trendingSection">
                <div class="container">
                    
                    <!-- Trending Properties Grid -->
                    <div class="trending-container">
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
                                    <div class="badge trending"><i class="fas fa-chart-line"></i> TRENDING</div>
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
                                        <span class="offer-type">{{ ucfirst($property->offer_type ?? 'sale') }}</span>
                                    </div>
                                    <div class="property-price">
                                        Rs. {{ number_format($property->price ?? 0, 2) }}
                                        <span class="price-unit">Total Price</span>
                                    </div>
                                    <h3 class="property-title">{{ $property->title ?? 'Property' }}</h3>
                                    <p class="property-description">
                                        <a href="{{ route('sales.property-details', ['id' => $property->id]) }}">
                                            {{ Str::limit($property->ad_description ?? 'No description available', 80) }}
                                        </a>
                                    </p>
                                    <div class="property-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $property->district ?? 'Unknown Location' }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-properties" style="text-align: center; padding: 3rem; width: 100%; grid-column: 1 / -1;">
                                <i class="fas fa-chart-line" style="font-size: 4rem; color: #ddd; margin-bottom: 1rem;"></i>
                                <h3>No Trending Properties Available</h3>
                                <p>Check back later for trending properties</p>
                                <a href="{{ route('sales.index') }}" class="btn btn-primary" style="margin-top: 1rem;">Browse All Properties</a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Links -->
                    @if($trendingProperties->hasPages())
                    <div class="pagination-container">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if($trendingProperties->onFirstPage())
                                <li class="disabled"><span>&laquo; Previous</span></li>
                            @else
                                <li><a href="{{ $trendingProperties->previousPageUrl() }}" rel="prev">&laquo; Previous</a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach($trendingProperties->getUrlRange(1, $trendingProperties->lastPage()) as $page => $url)
                                @if($page == $trendingProperties->currentPage())
                                    <li class="active"><span>{{ $page }}</span></li>
                                @else
                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if($trendingProperties->hasMorePages())
                                <li><a href="{{ $trendingProperties->nextPageUrl() }}" rel="next">Next &raquo;</a></li>
                            @else
                                <li class="disabled"><span>Next &raquo;</span></li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Simple script for any additional functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Trending page loaded');
});
</script>
@endpush