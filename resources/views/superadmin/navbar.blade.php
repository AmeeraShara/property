<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
}

.navbar .hamburger span {
    height: 3px;
    width: 25px;
    background-color: #fff;
    margin: 4px 0;
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
        position: relative; 
        top: 0;
        left: 0;
        z-index: 1000;
    }
    .navbar .nav-links.show {
        display: flex;
    }
    .navbar .nav-links a {
        text-align: center;
        padding: 0.75rem 0;
        border-top: 1px solid rgba(255,255,255,0.2);
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

    <div class="hamburger" id="hamburger">
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
    </ul>
</nav>

<script>
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('show');
});
</script>

</body>
</html>
