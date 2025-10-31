@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/contactus.css') }}">
@endpush

@section('content')

<!-- Blue Navbar -->
<nav class="navbar">
    <div class="container">
       
        <ul class="nav-links">
            <li><a href="#">Sale</a></li>
            <li><a href="#">Rental</a></li>
            <li><a href="#">Land</a></li>
            <li><a href="#">Our Services</a></li>
            <li><a href="#">Wanted</a></li>
        </ul>
    </div>
</nav>
<div class="contact-container">
    <h2 class="page-title">Contact Us</h2>

    <div class="contact-wrapper">

        <!-- Left: Contact Information -->
        <div class="contact-info-box">
            <h3>Contact Information</h3>

            <p><i class="fa fa-map-marker"></i> No. 8/6, Kurunegala, Kurunegala, Sri Lanka</p>
            <p><i class="fa fa-envelope"></i> propertylanka@gmail.com</p>
            <p><i class="fa fa-phone"></i> +94 70234567</p>

            <a href="https://wa.me/9470234567" class="chat-btn" target="_blank">
                 <i class="fa fa-comments chat-icon" style="color: blue;"></i>
</i> Chat With Us
            </a>

            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31682.687405180573!2d80.341933!3d7.486925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2b0d71abbde01%3A0xe1cfe1abdfd0f2!2sKurunegala!5e0!3m2!1sen!2slk!4v1698767890123" 
                    width="100%" 
                    height="260" 
                    frameborder="0" 
                    style="border:0;" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="contact-form-box">
            <h3>Send us a Message</h3>

            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                <div class="form-group">
                    <h6>FullName</h6>
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>

                <div class="form-group">
                    <h6>Email Address</h6>
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>

                <div class="form-group">
                    <h6>Subjects</h6>
                    <input type="text" name="subject" placeholder="Subject" required>
                </div>

                <div class="form-group">
                    <h6>Massage</h6>
                    <textarea name="message" placeholder="Message" rows="5" required></textarea>
                </div>

                <button type="submit" class="send-btn">Send Message</button>
                <p class="response-text">We’ll get back to you within 24 hours</p>
            </form>
        </div>
    </div>
</div>

@endsection



