@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/post-house.css') }}">
@endsection


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
<div class="post-house-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="">Dashboard</a>
        <span class="separator">></span>
        <span>Post Ad</span>
    </div>

    <!-- Back to List Button -->
    <div class="back-button-container">
        <a href="" class="back-button">
            <span>←</span> Back to List
        </a>
    </div>

    <!-- Progress Steps -->
    <div class="progress-steps">
        <div class="step completed">
            <div class="step-circle">1</div>
        </div>
        <div class="step-line completed"></div>
        <div class="step active">
            <div class="step-circle">2</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">3</div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('posts.storehousepost') }}" method="POST">
        @csrf
        
        <!-- Basic Details of the House -->
        <div class="form-section">
            <h2 class="section-title">Basic Details of the House</h2>
            
            <div class="form-row three-col">
                <div class="field-group">
                    <label for="bedrooms">Number of Bedrooms</label>
                    <select id="bedrooms" name="bedrooms" class="custom-select">
                        <option value="">E.g. 3</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6+">6+</option>
                    </select>
                </div>
                
                <div class="field-group">
                    <label for="bathrooms">Number of Bathrooms</label>
                    <select id="bathrooms" name="bathrooms" class="custom-select">
                        <option value="">E.g. 3</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5+">5+</option>
                    </select>
                </div>
                
                <div class="field-group">
                    <label for="land_area">Size of Land Area</label>
                    <select id="land_area" name="land_area" class="custom-select">
                        <option value="">E.g. 35</option>
                        <option value="5">5 Perches</option>
                        <option value="10">10 Perches</option>
                        <option value="15">15 Perches</option>
                        <option value="20">20 Perches</option>
                        <option value="25">25 Perches</option>
                        <option value="30">30 Perches</option>
                        <option value="35">35 Perches</option>
                        <option value="40">40 Perches</option>
                    </select>
                </div>
            </div>

            <div class="form-row two-col">
                <div class="field-group">
                    <label for="floor_area">Floor Area</label>
                    <div class="input-with-unit">
                        <input type="text" id="floor_area" name="floor_area" placeholder="E.g. 1234">
                        <span class="unit">sqft</span>
                    </div>
                </div>
                
                <div class="field-group">
                    <label for="num_floors">Number of Floor</label>
                    <select id="num_floors" name="num_floors" class="custom-select">
                        <option value="">E.g. 1</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4+">4+</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Price Details -->
        <div class="form-section">
            <h2 class="section-title">Price Details</h2>
            
            <div class="form-row price-row">
                <div class="field-group">
                    <label for="price">Expected Price in Rs</label>
                    <input type="text" id="price" name="price" placeholder="E.g. 230,000">
                </div>
                
                <div class="field-group price-type">
                    <select id="price_type" name="price_type" class="custom-select">
                        <option value="fixed">Fixed Price</option>
                        <option value="negotiable">Negotiable</option>
                        <option value="call">Call for Price</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Property Features -->
        <div class="form-section">
            <h2 class="section-title">Property Features</h2>
            
            <div class="features-grid">
                <button type="button" class="feature-btn" data-value="ac_rooms">
                    <span class="feature-icon">❄️</span>
                    <span>AC Rooms</span>
                </button>
                
                <button type="button" class="feature-btn" data-value="swimming_pool">
                    <span class="feature-icon">🏊</span>
                    <span>Swimming POOL</span>
                </button>
                
                <button type="button" class="feature-btn" data-value="attached_toilets">
                    <span class="feature-icon">🚿</span>
                    <span>Attached toilets</span>
                </button>
                
                <button type="button" class="feature-btn" data-value="hot_water">
                    <span class="feature-icon">💧</span>
                    <span>Hot Water</span>
                </button>
                
                <button type="button" class="feature-btn" data-value="indoor_garden">
                    <span class="feature-icon">🌿</span>
                    <span>Indoor Garden</span>
                </button>
                
                <button type="button" class="feature-btn" data-value="roof_top_garden">
                    <span class="feature-icon">🏡</span>
                    <span>Roof Top Garden</span>
                </button>
                
                <button type="button" class="feature-btn" data-value="main_line_water">
                    <span class="feature-icon">💧</span>
                    <span>Main Line water</span>
                </button>
                
                <button type="button" class="feature-btn" data-value="brand_new">
                    <span class="feature-icon">🏠</span>
                    <span>Brand New</span>
                </button>
                
                <button type="button" class="feature-btn" data-value="servant_room">
                    <span class="feature-icon">🚪</span>
                    <span>Servant Room</span>
                </button>
                
                <button type="button" class="feature-btn" data-value="servant_toilet">
                    <span class="feature-icon">🚽</span>
                    <span>Servant Toilet</span>
                </button>
            </div>
            <input type="hidden" name="features" id="features" value="">
        </div>

        <!-- Ad Details -->
        <div class="form-section">
            <h2 class="section-title">Ad Details</h2>
            
            <div class="field-group full-width">
                <label for="ad_title">Ad Title</label>
                <input type="text" id="ad_title" name="ad_title" placeholder="E.g. Brand new house">
            </div>
            
            <div class="field-group full-width">
                <label for="ad_description">Ad Description</label>
                <textarea id="ad_description" name="ad_description" rows="6" placeholder="E.g. Brand new house"></textarea>
            </div>
        </div>

        <!-- Page Counter and Buttons -->
        <div class="form-footer">
            <span class="page-counter">2/3</span>
            <div class="button-group">
                <button type="button" class="back-btn">BACK</button>
                <button type="submit" class="continue-button">CONTINUE</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Property Features buttons
    const featureBtns = document.querySelectorAll('.feature-btn');
    const featuresInput = document.getElementById('features');
    let selectedFeatures = [];
    
    featureBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('active');
            const value = this.dataset.value;
            
            if (this.classList.contains('active')) {
                if (!selectedFeatures.includes(value)) {
                    selectedFeatures.push(value);
                }
            } else {
                selectedFeatures = selectedFeatures.filter(f => f !== value);
            }
            
            featuresInput.value = selectedFeatures.join(',');
        });
    });
    
    // Back button
    const backBtn = document.querySelector('.back-btn');
    if (backBtn) {
        backBtn.addEventListener('click', function() {
            window.history.back();
        });
    }
});
</script>
@endsection