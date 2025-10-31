<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | RALankaProperty</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
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


    <!-- Right Side - Registration Form -->
    <div class="right-section">
        <div class="form-wrapper">
            <div class="form-card">
                <div class="form-header">
                    <h2 class="form-title">Create Account</h2>
                </div>
                <div class="form-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST" id="registerForm">
                        @csrf

                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" id="full_name" name="full_name" 
                                   class="form-control @error('full_name') is-invalid @enderror" 
                                   placeholder="Enter your name" 
                                   value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="Enter your email" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Enter your password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   class="form-control" 
                                   placeholder="Confirm your password" required>
                            <span class="step-indicator"></span>
                        </div>

                        <div class="form-group">
                            <label for="userType">Select the relevant category</label>
                            <select id="userType" name="userType" class="form-control" required>
                                <option value="">Select category</option>
                                <option value="super_admin" {{ old('userType') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="owner" {{ old('userType') == 'owner' ? 'selected' : '' }} selected>Owner</option>
                                <option value="tenant" {{ old('userType') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                                <option value="agent" {{ old('userType') == 'agent' ? 'selected' : '' }}>Agent</option>
                            </select>
                        </div>

                        <!-- Access Code for Super Admin -->
                        <div class="form-group" id="accessCodeSection" style="display: none;">
                            <label for="access_code">Access Code <span class="text-danger">*</span></label>
                            <input type="password" id="access_code" name="access_code" 
                                   class="form-control" 
                                   placeholder="Enter super admin access code">
                            <small class="text-muted">Required for Super Admin registration</small>
                        </div>

                        <button type="submit" class="btn-register">Register</button>

                        <div class="login-link">
                            Already have an account? <a href="{{ route('login') }}">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

  <form class="p-4" style="background-color: #fafafaff; border-radius: 10px;">
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
                        <div class="feature-box d-flex align-items-center p-2  rounded shadow-sm" style="background: rgba(217, 217, 217, 0.5);">
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
</form>

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

   

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Show/hide access code field based on user type selection
        const userTypeSelect = document.getElementById('userType');
        const accessCodeSection = document.getElementById('accessCodeSection');
        const accessCodeInput = document.getElementById('access_code');

        userTypeSelect.addEventListener('change', function() {
            if (this.value === 'super_admin') {
                accessCodeSection.style.display = 'block';
                accessCodeInput.required = true;
            } else {
                accessCodeSection.style.display = 'none';
                accessCodeInput.required = false;
                accessCodeInput.value = '';
            }
        });

        // Trigger change event on page load to handle old input
        if (userTypeSelect.value === 'super_admin') {
            accessCodeSection.style.display = 'block';
            accessCodeInput.required = true;
        }
    </script>
</body>
</html>