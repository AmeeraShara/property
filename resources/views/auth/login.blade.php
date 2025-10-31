<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RALankaProperty | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

  <div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Left Section -->
        <div class="col-lg-6 d-flex flex-column justify-content-center px-5">
            <div class="brand-logo mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <div class="brand-text">
                    <h5>RALanka<span>Property</span></h5>
                    <small>LANDS & HOMES</small>
                </div>
            </div>

            <h2 class="section-heading mb-4">
                YOUR<br>
                GATEWAY TO A<br>
                <span class="highlight">RICHER LIFE</span>
            </h2>
            
            <p class="description">
                <strong>RALanka<span>Property</span></strong> connects buyers and sellers across Sri<br>
                Lanka with a simple, secure, and trusted platform for all your<br>
                real estate needs.
            </p>
        </div>

        <!-- Login Section -->
        <div class="col-lg-6 p-0">
            <div class="login-container">
                <!-- Background Image -->
                <img src="{{ asset('images/img2.jpg') }}" class="login-image" alt="Property Image">

                <!-- Login Form Overlay -->
                <div class="login-card">
                    <h4 class="text-center mb-4 fw-bold">Login</h4>
                    
                    <!-- Display logout success message -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- Display any authentication errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label d-block fw-semibold">
                                <i class="fas fa-envelope me-1"></i>Email
                            </label>
                            <input 
                                type="email" 
                                id="email"
                                name="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                placeholder="Enter your email"
                                value="{{ old('email') }}"
                                required 
                                autofocus
                            >
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label d-block fw-semibold">
                                <i class="fas fa-lock me-1"></i>Password
                            </label>
                            <input 
                                type="password" 
                                id="password"
                                name="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Enter your password"
                                required
                            >
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="text-start mb-3">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-primary text-decoration-none small">
                                    <i class="fas fa-key me-1"></i>Forgot password?
                                </a>
                            @endif
                        </div>
                        
                        <button type="submit" class="btn btn-login w-100 fw-semibold">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                        
                        <p class="text-center mt-3 mb-0">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-danger text-decoration-none fw-semibold">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section (Fixed: Changed stray <form> to <div>) -->
<div class="p-4" style="background-color: #fafafaff; border-radius: 10px;">
    <div class="container py-5">
        <div class="row justify-content-center align-items-start">
            <!-- Image Section -->
            <div class="col-md-6 position-relative text-center mb-4 mb-md-0">
                <!-- Main Image -->
                <img src="{{ asset('images/img1.jpg') }}" class="img-fluid rounded shadow" alt="Property Image">

                <!-- Overlay Feature Boxes - Positioned on Right Side of Image -->
                <div class="overlay-features position-absolute" style="top: 325px; right: 100px; width: 320px;">
                    <div class="feature-box d-flex align-items-center mb-3 mt-5 p-3 rounded shadow" style="background: rgba(217, 217, 217, 0.5);">
                        <div class="icon-box p-3 rounded me-3" style="background-color: #97572B;">
                            <i class="fas fa-money-bill-wave text-white"></i>
                        </div>
                        <span class="fw-bold" style="font-size: 13px;">EASY PAYMENT METHODS</span>
                    </div>
                    <div class="feature-box d-flex align-items-center mb-3 mt-5 p-3 rounded shadow" style="background: rgba(217, 217, 217, 0.5);">
                        <div class="icon-box p-3 rounded me-3" style="background-color: #97572B;">
                            <i class="fas fa-hammer text-white"></i>
                        </div>
                        <span class="fw-bold" style="font-size: 13px;">PROPERTY DEVELOPMENT</span>
                    </div>
                    <div class="feature-box d-flex align-items-center p-3 mt-5 rounded shadow" style="background: rgba(217, 217, 217, 0.5);">
                        <div class="icon-box p-3 rounded me-3" style="background-color: #97572B;">
                            <i class="fas fa-road text-white"></i>
                        </div>
                        <span class="fw-bold" style="font-size: 13px;">INTERLOCK PAVING ROADS</span>
                    </div>
                </div>
            </div>

            <!-- Text and Feature List Section -->
            <div class="col-md-6 ps-4">
                <section class="text-md-start">
                    <h3 class="fw-bold mb-3 text-center" style="font-size: 28px;">WE ARE LIKE NO OTHER!</h3>
                    <p class="mb-4" style="color: #000000; font-size: 15px; text-align: left;">
                        <strong>RALanka<span style="color: #1167B2;">Property</span></strong> stands apart with unmatched trust, innovation, and customer care — redefining real estate as Sri Lanka's leading property brand.
                    </p>
                    <div class="features-list" style="margin-top: 80px; padding-left: 270px;">
                        <div class="feature-box d-flex align-items-center mb-3 mt-4 p-3 rounded shadow-sm" style="background: rgba(217, 217, 217, 0.5);">
                            <div class="icon-box p-3 rounded me-3" style="background-color: #97572B;">
                                <i class="fas fa-file-contract text-white"></i>
                            </div>
                            <span class="fw-bold" style="font-size: 13px;">LEGAL SERVICES</span>
                        </div>
                        <div class="feature-box d-flex align-items-center mb-3 mt-5 p-3 rounded shadow-sm" style="background: rgba(217, 217, 217, 0.5);">
                            <div class="icon-box p-3 rounded me-3" style="background-color: #97572B;">
                                <i class="fas fa-check-square text-white"></i>
                            </div>
                            <span class="fw-bold" style="font-size: 13px;">MINIMUM REQUIREMENTS IN PURCHASE</span>
                        </div>
                        <div class="feature-box d-flex align-items-center p-2 rounded shadow-sm" style="background: rgba(217, 217, 217, 0.5);">
                            <div class="icon-box p-3 rounded me-3" style="background-color: #97572B;">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                            <span class="fw-bold" style="font-size: 13px;">ZERO DOCUMENTATION</span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Awards Section -->
<div class="awards">
    <div class="container d-flex justify-content-center align-items-center gap-4 flex-wrap">
        <!-- Award 1 -->
        <div class="award-item text-center position-relative">
            <img src="{{ asset('images/award.png') }}" alt="Award Leaves Icon" class="award-icon">
            <div class="award-text-wrapper">
                <img src="{{ asset('images/award2.png') }}" alt="Award Leaves Icon" class="award-icon">
            </div>
        </div>

        <!-- Award 2 -->
        <div class="award-item text-center position-relative">
            <img src="{{ asset('images/award.png') }}" alt="Award Leaves Icon" class="award-icon">
            <div class="award-text-wrapper">
                <img src="{{ asset('images/award1.png') }}" alt="Award Leaves Icon" class="award-icon">
            </div>
        </div>

        <!-- Award 3 -->
        <div class="award-item text-center position-relative">
            <img src="{{ asset('images/award.png') }}" alt="Award Leaves Icon" class="award-icon">
            <div class="award-text-wrapper">
                <img src="{{ asset('images/award1.png') }}" alt="Award Leaves Icon" class="award-icon">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>