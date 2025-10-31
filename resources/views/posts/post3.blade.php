@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/post3.css') }}">
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
<div class="contact-container">

  <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('dashboard.index') }}">Dashboard</a> {{-- Updated: Link to dashboard --}}
        <span class="separator">></span>
        <span>Post Ad</span>
    </div>

    <!-- Back to List Button -->
    <div class="back-button-container">
        <a href="{{ route('posts.index') }}" class="back-button"> {{-- Updated: Link to posts index --}}
            <span>←</span> Back to List
        </a>
    </div>
    <!-- Progress Steps -->
    <div class="progress-steps">
        <div class="step active">
            <div class="step-circle">1</div>
        </div>
        <div class="step-line"></div>
        <div class="step active">
            <div class="step-circle">2</div>
        </div>
        <div class="step-line"></div>
        <div class="step active">
            <div class="step-circle">3</div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('posts.final.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if (isset($isSuperAdmin) && $isSuperAdmin)
            <input type="hidden" name="payment_option" value="free">
        @endif
        
        <!-- Contact Details -->
        <div class="form-section">
            <h2 class="section-title">Your Contact Details</h2>
            <div class="contact-details-grid">
                <div class="field-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Name" required>
                </div>
                <div class="field-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="field-group">
                    <label for="contact_tel">Contact Tel Number</label>
                    <div class="phone-input">
                        <select id="contact_country_code" name="contact_country_code">
                            <option value="+94">+94</option>
                            <!-- Add more country codes if needed -->
                        </select>
                        <input type="tel" id="contact_tel" name="contact_tel" placeholder="Enter number">
                    </div>
                </div>
                <div class="field-group">
                    <label for="whatsapp_tel">WhatsApp Tel Number</label>
                    <div class="phone-input">
                        <select id="whatsapp_country_code" name="whatsapp_country_code">
                            <option value="+94">+94</option>
                            <!-- Add more country codes if needed -->
                        </select>
                        <input type="tel" id="whatsapp_tel" name="whatsapp_tel" placeholder="Enter number">
                    </div>
                </div>
            </div>
        </div>

    <!-- Upload Images -->
<div class="form-section">
    <h2 class="section-title">Upload Images</h2>
    <div class="upload-images-grid" id="uploadContainer">

        <!-- First Upload Box -->
        <div class="upload-area" id="image-upload-1">
            <div class="upload-placeholder">
                <span class="upload-icon">📷</span>
                <p>Drop your photo here or click to upload</p>
            </div>
            <input type="file" name="images[]" accept="image/*" class="file-input" style="display:none;">
        </div>

        <!-- Add More Button -->
        <div class="upload-area add-more" id="addMoreBtn">
            <div class="upload-placeholder">
                <span class="upload-icon">+</span>
                <p>Add more image</p>
            </div>
        </div>
    </div>
</div>

        <!-- Upload Video -->
        <div class="form-section">
            <h2 class="section-title">Upload Video</h2>
            <div class="upload-video-area">
                <div class="upload-placeholder">
                    <span class="upload-icon">▶️</span>
                    <p>Upload Property's Video file here.</p>
                </div>
                <input type="file" id="video" name="video" accept="video/*" class="file-input">
            </div>
        </div>

      <!-- Payment Options Section - FIXED -->
@if (!isset($isSuperAdmin) || !$isSuperAdmin)
<div class="form-section">
    <h2 class="section-title">Select Payment Option</h2>
    <p class="section-subtitle">Choose your listing type and duration</p>
    
    <div class="payment-options-grid">
        <!-- Free Option -->
        <div class="payment-option">
            <input type="radio" id="free" name="payment_option" value="free" required 
                   onchange="toggleDurationOptions('free')" {{ old('payment_option') == 'free' ? 'checked' : '' }}>
            <label for="free" class="option-card free-option">
                <div class="option-header">
                    <h3>Free Listing</h3>
                    <span class="price">LKR 0</span>
                </div>
                <ul class="features">
                    <li>Basic visibility</li>
                    <li>Up to 5 images</li>
                    <li>1 Month Duration</li>
                    <li>Standard support</li>
                </ul>
            </label>
        </div>
        
        <!-- Premium Option -->
        <div class="payment-option">
            <input type="radio" id="premium" name="payment_option" value="premium"
                   onchange="toggleDurationOptions('premium')" {{ old('payment_option') == 'premium' ? 'checked' : '' }}>
            <label for="premium" class="option-card premium-option">
                <div class="option-header">
                    <h3>Premium Listing</h3>
                    <span class="price">From LKR 300</span>
                </div>
                <ul class="features">
                    <li>Featured on top</li>
                    <li>Unlimited images</li>
                    <li>Choose duration</li>
                    <li>Priority support</li>
                </ul>
            </label>
        </div>
    </div>
    
    <!-- Duration Selection -->
    <div id="durationOptions" class="duration-options" style="display: none;">
        <h3 class="duration-title">Select Duration</h3>
        <div class="duration-grid">
            <div class="duration-option">
                <input type="radio" id="1_month" name="subscription_duration" value="1_month" 
                       {{ old('subscription_duration') == '1_month' ? 'checked' : '' }}>
                <label for="1_month" class="duration-card">
                    <span class="duration">1 Month</span>
                    <span class="price">LKR 300</span>
                </label>
            </div>
            <div class="duration-option">
                <input type="radio" id="3_months" name="subscription_duration" value="3_months"
                       {{ old('subscription_duration') == '3_months' ? 'checked' : '' }}>
                <label for="3_months" class="duration-card">
                    <span class="duration">3 Months</span>
                    <span class="price">LKR 800</span>
                    <span class="save-badge">Save 11%</span>
                </label>
            </div>
            <div class="duration-option">
                <input type="radio" id="6_months" name="subscription_duration" value="6_months"
                       {{ old('subscription_duration') == '6_months' ? 'checked' : '' }}>
                <label for="6_months" class="duration-card">
                    <span class="duration">6 Months</span>
                    <span class="price">LKR 1,500</span>
                    <span class="save-badge">Save 17%</span>
                </label>
            </div>
            <div class="duration-option">
                <input type="radio" id="1_year" name="subscription_duration" value="1_year"
                       {{ old('subscription_duration') == '1_year' ? 'checked' : '' }}>
                <label for="1_year" class="duration-card">
                    <span class="duration">1 Year</span>
                    <span class="price">LKR 2,500</span>
                    <span class="save-badge">Save 30%</span>
                </label>
            </div>
        </div>
        @error('subscription_duration')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
    
    @error('payment_option')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>
@else
<!-- Super Admin ට payment options display නොකරන්න -->
<input type="hidden" name="payment_option" value="free">
<input type="hidden" name="subscription_duration" value="1_month">
@endif
    

        <!-- Form Footer -->
        <div class="form-footer">
            <button type="button" class="preview-button" onclick="previewAd()">PREVIEW</button>
            <span class="page-counter">3/3</span>
            <button type="submit" class="continue-button">CONTINUE</button>
        </div>
    </form>
</div>

<script>
function previewAd() {
    // Implement preview logic, e.g., open modal or new tab with form data
    alert('Preview functionality: Implement modal or redirect with current form data.');
    // Example: Collect form data and show in a modal
}

document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('.file-input');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const uploadArea = e.target.closest('.upload-area');
            const placeholder = uploadArea.querySelector('.upload-placeholder');
            if (e.target.files.length > 0) {
                placeholder.innerHTML = `<span class="file-selected">${e.target.files[0].name}</span>`;
            } else {
                // Reset placeholder
                if (uploadArea.id === 'image-upload-1') {
                    placeholder.innerHTML = '<span class="upload-icon">📷</span><p>Drop your photo here or click to upload</p>';
                } else if (uploadArea.classList.contains('add-more')) {
                    placeholder.innerHTML = '<span class="upload-icon">+</span><p>Add more image</p>';
                } else {
                    placeholder.innerHTML = '<span class="upload-icon">▶️</span><p>Upload Property\'s Video file here.</p>';
                }
            }
        });
    });

    // Drag and drop for image upload
    const imageUpload = document.getElementById('image-upload-1');
    imageUpload.addEventListener('dragover', (e) => e.preventDefault());
    imageUpload.addEventListener('drop', (e) => {
        e.preventDefault();
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            // For multiple files, append to the first input or handle accordingly
            const firstInput = document.querySelector('input[name="images[]"]');
            if (firstInput) {
                firstInput.files = files;
                firstInput.dispatchEvent(new Event('change'));
            }
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const uploadContainer = document.getElementById("uploadContainer");
    const addMoreBtn = document.getElementById("addMoreBtn");
    let imageCount = 1;
    const maxImages = 5;

    // Function to create a new upload box
    function createUploadBox(count) {
        const newUpload = document.createElement("div");
        newUpload.classList.add("upload-area");
        newUpload.innerHTML = `
            <div class="upload-placeholder">
                <span class="upload-icon">📷</span>
                <p>Click to upload image ${count}</p>
            </div>
            <input type="file" name="images[]" accept="image/*" class="file-input" style="display:none;">
        `;

        uploadContainer.insertBefore(newUpload, addMoreBtn);

        const input = newUpload.querySelector(".file-input");
        const placeholder = newUpload.querySelector(".upload-placeholder");

        // Open file selector when clicked
        newUpload.addEventListener("click", () => input.click());

        // Show preview when image selected
        input.addEventListener("change", (event) => {
            const file = event.target.files[0];
            if (file) {
                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '8px';
                placeholder.innerHTML = "";
                placeholder.appendChild(img);
            }
        });
    }

    // Add click event to add more button
    addMoreBtn.addEventListener("click", function () {
        if (imageCount >= maxImages) {
            alert(`You can upload only up to ${maxImages} images.`);
            return;
        }
        imageCount++;
        createUploadBox(imageCount);
    });

    // Setup first upload box
    const firstUpload = document.getElementById("image-upload-1");
    const firstInput = firstUpload.querySelector(".file-input");
    const firstPlaceholder = firstUpload.querySelector(".upload-placeholder");

    firstUpload.addEventListener("click", () => firstInput.click());
    firstInput.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (file) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '8px';
            firstPlaceholder.innerHTML = "";
            firstPlaceholder.appendChild(img);
        }
    });
});
function toggleDurationOptions(selectedOption) {
    const durationDiv = document.getElementById('durationOptions');
    const durationInputs = document.querySelectorAll('input[name="subscription_duration"]');
    
    if (selectedOption === 'premium') {
        durationDiv.style.display = 'block';
        // Make duration required only for premium
        durationInputs.forEach(input => input.required = true);
    } else {
        durationDiv.style.display = 'none';
        // Remove required and clear values for free
        durationInputs.forEach(input => {
            input.required = false;
            input.checked = false;
        });
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    // Check initial state
    const selectedPayment = document.querySelector('input[name="payment_option"]:checked');
    if (selectedPayment) {
        toggleDurationOptions(selectedPayment.value);
    }
    
    // Form submission
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const paymentSelected = document.querySelector('input[name="payment_option"]:checked');
        if (!paymentSelected) {
            e.preventDefault();
            alert('Please select a payment option.');
            return false;
        }
        
        if (paymentSelected.value === 'premium') {
            const durationSelected = document.querySelector('input[name="subscription_duration"]:checked');
            if (!durationSelected) {
                e.preventDefault();
                alert('Please select a subscription duration for premium option.');
                return false;
            }
        }
    });
});
</script>
@endsection