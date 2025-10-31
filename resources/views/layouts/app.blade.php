<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Existing meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RALankaProperty')</title>
    
    <!-- ✅ ADD THESE TWO LINES -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-logged-in" content="{{ auth()->check() ? 'true' : 'false' }}">
    
    <!-- Your existing CSS links -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
    @yield('styles')
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <div class="top-bar">
                <div style="display: flex; align-items: center;">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
                    <div class="logo">RALanka<span>Property</span></div>
                </div>
                <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
                <nav>
    <ul id="navMenu" class="d-flex align-items-center mb-0">
        <!-- Conditional Auth Links -->
        @auth
            <!-- Show user name and profile link for logged-in users -->
            <li>
                <a href="{{ route('profile') }}">
                    <i class="fas fa-user"></i> {{ Auth::user()->name ?? Auth::user()->full_name ?? 'User' }}
                </a>
            </li>

            <!-- ✅ NEW: Super Admin Dashboard Button (only for super admins) -->
           @if(Auth::user()->role === 'super_admin')
    <li>
        <a href="{{ route('superadmin.dashboard') }}" 
           class="btn-dashboard {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-1"></i> Go to the Dashboard
        </a>
    </li>
@endif

            <!-- Logout: Native button form (no JS) -->
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display: inline-block; margin: 0;">
                    @csrf
                    <button type="submit" 
                            class="btn btn-link nav-link p-0 text-decoration-none" 
                            style="color: inherit; border: none; background: none; cursor: pointer;">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </li>
        @else
            <!-- Show Sign In for guests -->
            <li><a href="{{ route('login') }}"><i class="fas fa-user"></i> Sign in</a></li>
        @endauth

        <li><a href="#"><i class="fas fa-question-circle me-2"></i> Help</a></li>

        <!-- Conditional Post Your Ad Link -->
        <li>
            @auth
                {{-- For logged-in users: Link to posts.index --}}
                <a href="{{ route('posts.index') }}" class="post-ad-btn">
                    Post Your Ad
                </a>
            @else
                {{-- For guests: Link to register --}}
                <a href="{{ route('register') }}" class="post-ad-btn">Post Your Ad</a>
            @endauth
        </li>

        <!-- Fixed dropdown: Added notranslate -->
        <li class="nav-item dropdown notranslate">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="languageBtn" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-globe"></i> English
            </button>
            <ul class="dropdown-menu notranslate" id="languageMenu">
                <li><a class="dropdown-item" href="#" data-lang="English">English</a></li>
                <li><a class="dropdown-item" href="#" data-lang="සිංහල">සිංහල</a></li>
                <li><a class="dropdown-item" href="#" data-lang="தமிழ்">தமிழ்</a></li>
            </ul>
        </li>
    </ul>
</nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

<!-- Updated Newsletter Section in your layout -->
<section class="newsletter-section">
    <hr class="newsletter-line">
    <h2>JOIN OUR NEWSLETTER</h2>
    <p>Subscribe to receive updates, access to exclusive deals, and more.</p>
    
    <form class="newsletter-form" id="newsletterForm" role="form">
        @csrf
        <input type="email" name="email" placeholder="Enter your email" class="newsletter-input" aria-label="Email address" required>
        <button type="submit" class="newsletter-btn" id="subscribeBtn">
            <span id="subscribeText">SUBSCRIBE</span>
            <div id="subscribeSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </button>
    </form>
    
    <div id="newsletterMessage" class="mt-2" style="min-height: 20px;"></div>
    
    <hr class="newsletter-line">
    <p class="copyright-text">©copyright RALankaProperty.com, lpw jk 2025 | All rights reserved</p>
</section>
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Navigation</h3>
                    <ul>
                        <li><a href="#">Home</a></li>
                        
                        
                        <li><a href="{{ route('posts.index') }}">Post Your Ad</a></li>
                        <li><a href="#">Contact</a></li>
                      
                        <li><a href="{{ route('sales.index') }}">Sales</a></li>
                        <li><a href="{{ route('rent.index') }}">Rent</a></li>
                       
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>More Links</h3>
                    <ul>
                     
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                        {{-- Removed duplicate "Rent" and "Our Services" --}}
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>About</h3>
                    <ul>
                        <li><a href="#">Help</a></li>
                
                        <li><a href="#">Terms and Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                       
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Follow Us On Social Media</h3>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/lankapropertyweb/" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/lankaproperty" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/lankapropertyweb/" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/c/Lankapropertyweb" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
                    </div>
                    <div class="logo-text">
                        <img src="{{ asset('images/logo3.jpg') }}" alt="Logo" class="footer-logo">
                        <span class="highlight">RALanka </span><span>Property</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Hidden container for Google Translate -->
    <div id="google_translate_element" style="display: none;"></div>

    <!-- Google Translate Script -->
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <!-- Custom JS with Auto-Translate -->
    <script>
        // Language code mapping
        const langMap = {
            'English': 'en',
            'සිංහල': 'si',
            'தமிழ்': 'ta'
        };
        const reverseLangMap = {
            'en': 'English',
            'si': 'සිංහල',
            'ta': 'தமிழ්'
        };

        function getCurrentLang() {
            const hashMatch = window.location.hash.match(/#googtrans\([^|]+\|(\w+)\)/);
            if (hashMatch) return hashMatch[1];
            const cookieMatch = document.cookie.match(/googtrans\s*\=\s*\/(\w+)\/(\w+)/);
            if (cookieMatch) return cookieMatch[2];
            return 'en';
        }

        function setGoogleTranslateCookie(langCode) {
            document.cookie = `googtrans=/en/${langCode}; path=/; max-age=31536000`;
        }

        function clearTranslateCookie() {
            document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        }

        function triggerGoogleTranslate(targetLangCode) {
            if (targetLangCode === 'en') {
                // Switch back to English
                clearTranslateCookie();
                window.location.hash = '';
                
                // Find and click the "Show original" button if it exists
                const frame = document.querySelector('.goog-te-banner-frame');
                if (frame && frame.contentWindow) {
                    const showOriginalBtn = frame.contentWindow.document.querySelector('.goog-te-button button');
                    if (showOriginalBtn) {
                        showOriginalBtn.click();
                    }
                }
                
                // Force reload as fallback
                setTimeout(() => {
                    location.reload();
                }, 100);
            } else {
                // Set cookie and hash
                setGoogleTranslateCookie(targetLangCode);
                window.location.hash = `googtrans(en|${targetLangCode})`;
                
                // Wait for Google Translate to initialize, then trigger translation
                const checkAndTranslate = setInterval(() => {
                    const selectElem = document.querySelector('.goog-te-combo');
                    if (selectElem) {
                        selectElem.value = targetLangCode;
                        selectElem.dispatchEvent(new Event('change'));
                        clearInterval(checkAndTranslate);
                    }
                }, 100);
                
                // Clear interval after 3 seconds if not found
                setTimeout(() => clearInterval(checkAndTranslate), 3000);
            }
        }

        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,si,ta',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const navMenu = document.getElementById('navMenu');
            const header = document.querySelector('header');
            const languageMenu = document.getElementById('languageMenu');
            const languageBtn = document.getElementById('languageBtn');

            // Set initial button text
            const currentLangCode = getCurrentLang();
            const currentLangName = reverseLangMap[currentLangCode] || 'English';
            if (currentLangName !== 'English') {
                const icon = languageBtn.querySelector('i');
                languageBtn.innerHTML = '';
                languageBtn.appendChild(icon.cloneNode(true));
                languageBtn.appendChild(document.createTextNode(' ' + currentLangName));
            }

            // Mobile menu
            if (mobileMenuBtn && navMenu) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    navMenu.classList.toggle('show');
                    const icon = this.querySelector('i');
                    if (navMenu.classList.contains('show')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!header.contains(e.target) && navMenu.classList.contains('show')) {
                        navMenu.classList.remove('show');
                        const icon = mobileMenuBtn.querySelector('i');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });

                const menuLinks = navMenu.querySelectorAll('li a:not(.dropdown-toggle)');
                menuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth <= 768) {
                            navMenu.classList.remove('show');
                            const icon = mobileMenuBtn.querySelector('i');
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    });
                });

                let resizeTimer;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function() {
                        if (window.innerWidth > 768) {
                            navMenu.classList.remove('show');
                            const icon = mobileMenuBtn.querySelector('i');
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }, 250);
                });
            }

            // Language dropdown + auto translation
            if (languageMenu && languageBtn) {
                languageMenu.addEventListener('click', function(e) {
                    if (e.target.classList.contains('dropdown-item')) {
                        e.preventDefault();
                        const selectedLang = e.target.getAttribute('data-lang');
                        const targetLangCode = langMap[selectedLang];

                        // Update button text
                        const icon = languageBtn.querySelector('i');
                        languageBtn.innerHTML = '';
                        languageBtn.appendChild(icon.cloneNode(true));
                        languageBtn.appendChild(document.createTextNode(' ' + selectedLang));

                        // Close dropdown
                        const dropdown = bootstrap ? bootstrap.Dropdown.getInstance(languageBtn) : null;
                        if (dropdown) {
                            dropdown.hide();
                        } else {
                            languageMenu.classList.remove('show');
                        }

                        // Trigger translation automatically
                        triggerGoogleTranslate(targetLangCode);
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!languageBtn.contains(e.target) && !languageMenu.contains(e.target)) {
                        languageMenu.classList.remove('show');
                    }
                });
            }
        });
    </script>
    <script>
// Newsletter subscription with AJAX
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.getElementById('newsletterForm');
    const subscribeBtn = document.getElementById('subscribeBtn');
    const subscribeText = document.getElementById('subscribeText');
    const subscribeSpinner = document.getElementById('subscribeSpinner');
    const newsletterMessage = document.getElementById('newsletterMessage');

    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const email = formData.get('email');
            
            // Show loading state
            subscribeText.textContent = 'SUBSCRIBING...';
            subscribeSpinner.classList.remove('d-none');
            subscribeBtn.disabled = true;
            newsletterMessage.textContent = '';
            
            // AJAX request
            fetch('{{ route("newsletter.subscribe") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    newsletterMessage.style.color = 'green';
                    newsletterMessage.textContent = data.message;
                    newsletterForm.reset();
                } else {
                    newsletterMessage.style.color = 'red';
                    newsletterMessage.textContent = data.message;
                }
            })
            .catch(error => {
                newsletterMessage.style.color = 'red';
                newsletterMessage.textContent = 'An error occurred. Please try again.';
            })
            .finally(() => {
                // Reset button state
                subscribeText.textContent = 'SUBSCRIBE';
                subscribeSpinner.classList.add('d-none');
                subscribeBtn.disabled = false;
                
                // Clear message after 5 seconds
                setTimeout(() => {
                    newsletterMessage.textContent = '';
                }, 5000);
            });
        });
    }
});
</script>


    @stack('scripts')
</body>
</html>