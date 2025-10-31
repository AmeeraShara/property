<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details</title>

    {{--  Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{--  Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #ffffff !important;
            color: #000000 !important;
            padding: 20px;
        }
        h2 {
            font-weight: 700 !important;
            color: #000 !important;
        }
        h6 {
            font-weight: 600;
            color: #000;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
            margin-bottom: 0.8rem;
        }
        p, li {
            font-size: 0.9rem;
            color: #000 !important;
            margin-bottom: 0.3rem;
        }
        .box {
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            padding: 1rem;
            background-color: #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        .image-grid img {
            width: 100%;
            max-width: 200px;
            height: 150px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 0.4rem;
        }
        .btn-outline-dark:hover {
            background-color: #000;
            color: #fff;
        }
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container-fluid bg-white text-black">
    <main class="col-md-10 ms-sm-auto col-lg-10 px-4 mt-4">

        {{-- Title --}}
        <h2 class="text-center mb-4 fw-bold text-black">Property Details</h2>

        <div class="row g-4">

            {{-- 🏠 Column 1 --}}
            <div class="col-md-4">
                <div class="box">
                    <h6>Basic Information</h6>
                    <p><strong>Title:</strong> {{ $property->title }}</p>
                    <p><strong>Type:</strong> {{ ucfirst($property->type) }}</p>
                    <p><strong>Category:</strong> {{ ucfirst($property->category) }}</p>
                    <p><strong>District:</strong> {{ $property->district }}</p>
                    <p><strong>City:</strong> {{ $property->city }}</p>
                    <p><strong>Location:</strong> {{ $property->location }}</p>
                </div>

                <div class="box">
                    <h6>Pricing & Size</h6>
                    <p><strong>Price:</strong> {{ number_format($property->price, 2) }} {{ $property->price_unit }}</p>
                    <p><strong>Size:</strong> {{ $property->size }}</p>
                </div>
            </div>

            {{-- 🏡 Column 2 --}}
            <div class="col-md-4">
                <div class="box">
                    <h6>Rooms & Status</h6>
                    <p><strong>Bedrooms:</strong> {{ $property->bedrooms }}</p>
                    <p><strong>Bathrooms:</strong> {{ $property->bathrooms }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($property->status) }}</p>
                </div>

                <div class="box">
                    <h6>Description</h6>
                    <p>{{ $property->description }}</p>
                </div>

                <div class="box">
                    <h6>Features</h6>
                    <p><strong>Featured:</strong> {{ $property->is_featured ? 'Yes' : 'No' }}</p>
                    <p><strong>Hot Deal:</strong> {{ $property->is_hot_deal ? 'Yes' : 'No' }}</p>
                    <p><strong>Trending:</strong> {{ $property->is_trending ? 'Yes' : 'No' }}</p>
                    <p><strong>Urgent:</strong> {{ $property->is_urgent ? 'Yes' : 'No' }}</p>
                </div>
            </div>

            {{-- 🏘️ Column 3 --}}
            <div class="col-md-4">
                <div class="box">
                    <h6>Amenities</h6>
                    @php $amenities = json_decode($property->amenities, true); @endphp
                    <ul class="mb-0">
                        @if(is_array($amenities) && count($amenities) > 0)
                            @foreach($amenities as $amenity)
                                <li>{{ $amenity }}</li>
                            @endforeach
                        @else
                            <li>No amenities listed.</li>
                        @endif
                    </ul>
                </div>

                <div class="box">
                    <h6>Images</h6>
                    @php $images = json_decode($property->images, true); @endphp
                    @if(is_array($images) && count($images) > 0)
                        <div class="d-flex flex-wrap gap-3 image-grid">
                            @foreach($images as $image)
                                <img src="{{ asset('images/' . $image) }}" alt="Property Image">
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No images available.</p>
                    @endif
                </div>
            </div>
        </div>



    </main>
</div>

{{--  Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
