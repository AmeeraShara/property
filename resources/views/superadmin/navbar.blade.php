<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>SuperAdmin Navbar</title>
<style>
/* Navbar container */
.navbar {
    background-color: #1167B1;
    padding: 0.5rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    position: relative;
}

/* Brand */
.navbar .brand {
    color: #fff;
    font-weight: bold;
    font-size: 1.5rem;
    text-decoration: none;
}

/* Menu items container */
.navbar .nav-links {
    display: flex;
    gap: 1rem;
    list-style: none;
    padding: 0;
    margin: 0;
}

/* Links */
.navbar .nav-links a {
    color: #fff;
    text-decoration: none;
    padding: 0.5rem 0.75rem;
    transition: 0.3s;
}

.navbar .nav-links a:hover {
    color: #ffdd57;
    text-decoration: underline;
}

.navbar .nav-links a.active {
    color: #ffdd57;
    font-weight: 600;
}

/* Hamburger button */
.navbar .hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
    padding: 10px; /* easier tap */
    user-select: none;
}

.navbar .hamburger span {
    height: 3px;
    width: 30px; /* bigger bars */
    background-color: #fff;
    margin: 5px 0;
    border-radius: 2px;
    transition: 0.3s;
}

/* Mobile styles */
@media (max-width: 768px) {
    .navbar .nav-links {
        display: none;
        width: 100%;
        flex-direction: column;
        margin-top: 0.5rem;
        background-color: #1167B1;
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: max-height 0.3s ease-in-out;
        overflow: hidden;
        max-height: 0;
    }
    .navbar .nav-links.show {
        display: flex;
        max-height: 500px;
    }
    .navbar .nav-links a {
        text-align: center;
        padding: 0.3rem 0; /* reduced vertical padding */
        border-top: 1px solid rgba(255,255,255,0.2);
        font-size: 0.9rem; /* smaller font */
        width: 100%;
        display: block;
        line-height: 1.2; /* tighter line height */
    }
    .navbar .hamburger {
        display: flex;
    }
}
</style>
</head>
<body>

<nav class="navbar">
    <a href="#" class="brand">SuperAdmin</a>

    <div class="hamburger" id="hamburger" aria-label="Toggle navigation" role="button" tabindex="0">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <ul class="nav-links" id="navLinks">
        <li><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('superadmin.posts') }}">Posts</a></li>
        <li><a href="{{ route('superadmin.users') }}">Users</a></li>
        <li><a href="{{ route('superadmin.properties') }}">Properties</a></li>
        <li><a href="{{ route('superadmin.subscribers') }}">Subscribers</a></li>
        <li><a href="{{ route('superadmin.inquiries') }}">Inquiries</a></li>
        <li><a href="{{ route('superadmin.advertisers') }}">Advertisers</a></li>
        <li><a href="{{ route('superadmin.premium.index') }}">Premium</a></li>
    </ul>
</nav>

<script>
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('show');
});

// Accessibility: toggle on Enter/Space keys
hamburger.addEventListener('keydown', e => {
    if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        navLinks.classList.toggle('show');
    }
});
</script>

</body>
</html>
