<style>
    body {
        background-color: #fff;
        color: #000;
        font-size: 0.85rem;
    }

    .card {
        border: 1px solid #000;
        background-color: #fff;
        color: #000;
        margin-bottom: 0.5rem;
    }

    .card-header {
        font-weight: 700;
        background-color: #f8f9fa;
        color: #000;
        padding: 0.35rem 0.75rem;
        font-size: 0.9rem;
    }

    .card-body {
        padding: 0.5rem 0.75rem;
    }

    h4,
    .form-label {
        color: #000;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .form-control,
    .form-select {
        background-color: #f9f9f9;
        color: #000;
        border: 1px solid #ccc;
        font-size: 0.85rem;
        padding: 0.25rem 0.5rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #000;
        box-shadow: none;
    }

    .btn-outline-primary,
    .btn-outline-secondary {
        border-color: #000;
        color: #000;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    .btn-outline-primary.active,
    .btn-outline-secondary.active,
    .btn-outline-primary:hover,
    .btn-outline-secondary:hover {
        background-color: #000;
        color: #fff;
    }

    .btn-primary {
        background-color: #000;
        border: none;
        color: #fff;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.25rem 0.5rem;
    }

    .btn-primary:hover {
        background-color: #333;
    }

    .btn-secondary {
        background-color: #e0e0e0;
        color: #000;
        border: none;
        font-size: 0.85rem;
        padding: 0.25rem 0.5rem;
    }

    .btn-secondary:hover {
        background-color: #ccc;
    }

    .dropdown-menu {
        background-color: #fff;
        border: 1px solid #000;
        font-size: 0.85rem;
    }

    .dropdown-item {
        color: #000;
        font-size: 0.85rem;
        padding: 0.25rem 0.5rem;
    }

    .dropdown-item:hover {
        background-color: #000;
        color: #fff;
    }

    .offer-btn,
    .property-btn {
        white-space: nowrap;
        margin-bottom: 0.25rem;
    }

    .property-type-container {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        max-height: 75px;
        overflow-y: auto;
    }

    .form-check-label {
        font-size: 0.85rem;
        font-weight: 600;
    }

    .form-check-input {
        margin-top: 0.2rem;
        width: 1rem;
        height: 1rem;
    }

    /* Adjust spacing for compact layout */
    .mb-1 {
        margin-bottom: 0.25rem !important;
    }

    .mt-1 {
        margin-top: 0.25rem !important;
    }

    .g-2>* {
        margin-bottom: 0.25rem;
    }
</style>

<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('superadmin.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-2">

                    {{-- Offer Type --}}
                    <div class="col-12 col-md-4">
                        <label class="form-label">Offer Type</label>
                        <div class="d-flex flex-wrap gap-1 mb-1">
                            @foreach(['sale'=>'Sale','rent'=>'Rent','wanted'=>'Wanted','professionals'=>'Professionals & Services'] as $value => $label)
                            <button type="button"
                                class="offer-btn btn btn-outline-primary btn-sm {{ $post->offer_type == $label ? 'active' : '' }}"
                                data-label="{{ $label }}">
                                {{ $label }}
                            </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="offer_type" id="offer_type" value="{{ $post->offer_type }}">
                        @error('offer_type')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Property Type --}}
                    <div class="col-12 col-md-8">
                        <label class="form-label">Property Type</label>
                        <div class="property-type-container mb-1">
                            @foreach(['House','Apartment','Villa','Room','Annex','Land','Commercial'] as $type)
                            <button type="button"
                                class="property-btn btn btn-outline-secondary btn-sm {{ $post->property_type == $type ? 'active' : '' }}"
                                data-label="{{ $type }}">{{ $type }}</button>
                            @endforeach
                        </div>
                        <input type="hidden" name="property_type" id="property_type" value="{{ $post->property_type }}">
                        @error('property_type')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    
                    {{-- Property Subtype --}}
                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Property Subtype</label>
                        <input type="text" name="property_subtype" class="form-control form-control-sm"
                            value="{{ $post->property_subtype }}">
                        @error('property_subtype')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- District --}}
                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">District</label>
                        <input type="text" name="district" class="form-control form-control-sm"
                            placeholder="Enter District" value="{{ $post->district }}">
                        @error('district')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control form-control-sm"
                            placeholder="Enter City" value="{{ $post->city }}">
                        @error('city')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Street</label>
                        <input type="text" name="street" class="form-control form-control-sm"
                            placeholder="Enter Street" value="{{ $post->street }}">
                        @error('street')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Ad Title</label>
                        <input type="text" name="ad_title" class="form-control form-control-sm"
                            placeholder="Enter Ad Title" value="{{ $post->ad_title }}">
                        @error('ad_title')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Description</label>
                        <textarea name="ad_description" class="form-control form-control-sm"
                            placeholder="Enter Description">{{ $post->ad_description }}</textarea>
                        @error('ad_description')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control form-control-sm"
                            placeholder="Enter Price" value="{{ $post->price }}">
                        @error('price')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-12 col-md-4 mt-1 price-section">
                        <label class="form-label">Price Type</label>
                        <select name="price_type" id="price_type" class="form-select form-select-sm">
                            <option value="">Select Price Type</option>
                            <option value="fixed" {{ $post->price_type == 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                            <option value="negotiable" {{ $post->price_type == 'negotiable' ? 'selected' : '' }}>Negotiable</option>
                            <option value="call" {{ $post->price_type == 'call' ? 'selected' : '' }}>Call for Price</option>
                        </select>
                        @error('price_type')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Bedrooms</label>
                        <input type="number" name="bedrooms" class="form-control form-control-sm"
                            placeholder="Enter Bedrooms" value="{{ $post->bedrooms }}">
                        @error('bedrooms')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Bathrooms</label>
                        <input type="number" name="bathrooms" class="form-control form-control-sm"
                            placeholder="Enter Bathrooms" value="{{ $post->bathrooms }}">
                        @error('bathrooms')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Area</label>
                        <input type="text" name="area" class="form-control form-control-sm"
                            placeholder="Enter Area" value="{{ $post->area }}">
                        @error('area')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                                        <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Land Area</label>
                        <select name="land_area" class="form-select form-select-sm">
                            <option value="">Select Land Area</option>
                            @foreach([5,10,15,20,25,30,35,40] as $area)
                            <option value="{{ $area }}" {{ $post->land_area == $area ? 'selected' : '' }}>
                                {{ $area }} Perches
                            </option>
                            @endforeach
                        </select>
                        @error('land_area')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Floor Area</label>
                        <input type="text" name="floor_area" class="form-control form-control-sm"
                            placeholder="Enter Floor Area" value="{{ $post->floor_area }}">
                        @error('floor_area')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Number of Floors</label>
                        <input type="number" name="num_floors" class="form-control form-control-sm"
                            placeholder="Enter Floors" value="{{ $post->num_floors }}">
                        @error('num_floors')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                                        {{-- Status --}}
                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            @foreach(['draft','pending','published','rejected','active'] as $status)
                            <option value="{{ $status }}" {{ $post->status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- Features --}}
                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Features</label>
                        <textarea name="features" class="form-control form-control-sm" placeholder="Enter Features">{{ old('features', $post->features) }}</textarea>
                        @error('features')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>


                                        <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Contact Name</label>
                        <input type="text" name="contact_name" class="form-control form-control-sm"
                            placeholder="Enter Name" value="{{ $post->contact_name }}">
                        @error('contact_name')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Contact Email</label>
                        <input type="email" name="contact_email" class="form-control form-control-sm"
                            placeholder="Enter Email" value="{{ $post->contact_email }}">
                        @error('contact_email')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control form-control-sm"
                            placeholder="Enter Phone" value="{{ $post->contact_phone }}">
                        @error('contact_phone')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Whatsapp Phone</label>
                        <input type="text" name="whatsapp_phone" class="form-control form-control-sm"
                            placeholder="Enter Whatsapp" value="{{ $post->whatsapp_phone }}">
                        @error('whatsapp_phone')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    
                    {{-- Images Section --}}
                    <div class="col-12 mt-3">
                        <label class="form-label fw-bold">Images</label>

                        {{-- Existing Images Preview --}}
                        <div class="row g-2" id="imagePreviewContainer">
                            @php
                            $images = json_decode($post->images, true) ?? [];
                            if (!is_array($images)) {
                            $images = [];
                            }
                            @endphp

                            @foreach($images as $index => $img)
                            <div class="col-6 col-md-3 position-relative image-wrapper">
                                <img src="{{ asset($img) }}" class="img-thumbnail w-100"
                                    style="height:150px;object-fit:cover;" alt="Image">
                                <button type="button"
                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image-btn"
                                    data-index="{{ $index }}">&times;</button>
                            </div>
                            @endforeach
                        </div>

                        {{-- Hidden input to store existing images --}}
                        <input type="hidden" name="existing_images" id="existing_images" value='@json($images)'>

                        {{-- New Image Uploader --}}
                        <input type="file" name="images[]" id="newImagesInput" class="form-control mt-2" multiple accept="image/*">
                        <small class="text-muted">You can upload multiple images.</small>

                        {{-- New Images Preview --}}
                        <div class="row g-2 mt-2" id="newImagesPreview"></div>
                    </div>

                    {{-- Videos Section --}}
                    <div class="col-12 mt-3">
                        <label class="form-label fw-bold">Videos</label>

                        {{-- Existing Videos Preview --}}
                        <div class="row g-2" id="videoPreviewContainer">
                            @php
                            $videos = $post->videos ?? [];
                            if (!is_array($videos)) {
                            $videos = $videos ? [$videos] : [];
                            }
                            @endphp

                            @foreach($videos as $index => $video)
                            @if($video)
                            <div class="col-12 col-md-6 position-relative video-wrapper">
                                <video controls class="w-100" style="max-height:200px;">
                                    <source src="{{ asset($video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <button type="button"
                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-video-btn"
                                    data-index="{{ $index }}">&times;</button>
                            </div>
                            @endif
                            @endforeach
                        </div>

                        {{-- Hidden input to store existing videos --}}
                        <input type="hidden" name="existing_videos" id="existing_videos" value='@json($videos)'>

                        {{-- New Video Uploader --}}
                        <input type="file" name="videos[]" id="newVideosInput" class="form-control mt-2" multiple accept="video/*">
                        <small class="text-muted">You can upload multiple videos.</small>

                        {{-- New Videos Preview --}}
                        <div class="row g-2 mt-2" id="newVideosPreview"></div>
                    </div>







                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Commercial Type</label>
                        <input type="text" name="commercial_type" class="form-control form-control-sm"
                            placeholder="Enter Type" value="{{ $post->commercial_type }}">
                        @error('commercial_type')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                                        <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Floor Level</label>
                        <input type="text" name="floor_level" class="form-control form-control-sm"
                            placeholder="Enter Floor Level" value="{{ $post->floor_level }}">
                        @error('floor_level')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Size</label>
                        <input type="text" name="size" class="form-control form-control-sm"
                            placeholder="Enter Size" value="{{ $post->size }}">
                        @error('size')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control form-control-sm"
                            placeholder="Enter Location" value="{{ $post->location }}">
                        @error('location')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                   {{-- Amenities --}}
                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Amenities</label>
                        <textarea name="amenities" class="form-control form-control-sm" placeholder="Enter Amenities">{{ old('amenities', $post->amenities) }}</textarea>
                        @error('amenities')
                        <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>




                                        {{-- Price Unit --}}
                    <div class="col-12 col-md-4 mt-1">
                        <label class="form-label">Price Unit</label>
                        <select name="price_unit" class="form-select form-select-sm">
                            @foreach(['LKR','USD','EUR'] as $unit)
                            <option value="{{ $unit }}" {{ $post->price_unit == $unit ? 'selected' : '' }}>
                                {{ $unit }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Checkboxes --}}
                    <div class="col-12 d-flex flex-wrap gap-3 mt-2">
                        @foreach(['is_featured'=>'Featured','is_hot_deal'=>'Hot Deal','is_trending'=>'Trending','is_urgent'=>'Urgent'] as $name => $label)
                        <div class="form-check">
                            <input type="checkbox" id="{{ $name }}" name="{{ $name }}" value="1"
                                class="form-check-input" {{ $post->{$name} ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="{{ $name }}">{{ $label }}</label>
                        </div>
                        @endforeach
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary w-100 btn-sm">💾 Update Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Offer type buttons
        document.querySelectorAll('.offer-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.offer-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('offer_type').value = this.dataset.label;
            });
        });

        // Property type buttons
        document.querySelectorAll('.property-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.property-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('property_type').value = this.dataset.label;
            });
        });

        // Remove existing images
        const container = document.getElementById('imagePreviewContainer');
        const hiddenInput = document.getElementById('existing_images');
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-image-btn')) {
                const index = e.target.dataset.index;
                let images = JSON.parse(hiddenInput.value);
                images.splice(index, 1);
                hiddenInput.value = JSON.stringify(images);
                e.target.closest('.image-wrapper').remove();
                document.querySelectorAll('.remove-image-btn').forEach((btn, i) => btn.dataset.index = i);
            }
        });

        // Preview new uploads
        const fileInput = document.getElementById('newImagesInput');
        const newPreview = document.getElementById('newImagesPreview');
        fileInput.addEventListener('change', function() {
            newPreview.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const col = document.createElement('div');
                    col.classList.add('col-6', 'col-md-3', 'position-relative');
                    col.innerHTML = `<img src="${e.target.result}" class="img-thumbnail w-100" style="height:150px;object-fit:cover;"><span class='badge bg-success position-absolute top-0 start-0'>New</span>`;
                    newPreview.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        });

        // Remove existing videos
        const videoContainer = document.getElementById('videoPreviewContainer');
        const existingVideosInput = document.getElementById('existing_videos');

        videoContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-video-btn')) {
                const index = e.target.dataset.index;
                let videos = JSON.parse(existingVideosInput.value);
                videos.splice(index, 1);
                existingVideosInput.value = JSON.stringify(videos);
                e.target.closest('.video-wrapper').remove();

                // Update indexes
                document.querySelectorAll('.remove-video-btn').forEach((btn, i) => btn.dataset.index = i);
            }
        });

        // Preview new video uploads
        const newVideoInput = document.getElementById('newVideosInput');
        const newVideosPreview = document.getElementById('newVideosPreview');

        newVideoInput.addEventListener('change', function() {
            newVideosPreview.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const url = URL.createObjectURL(file);
                const col = document.createElement('div');
                col.classList.add('col-12', 'col-md-6', 'position-relative');
                col.innerHTML = `
            <video controls class="w-100" style="max-height:200px;">
                <source src="${url}" type="${file.type}">
                Your browser does not support the video tag.
            </video>
            <span class="badge bg-success position-absolute top-0 start-0">New</span>
        `;
                newVideosPreview.appendChild(col);
            });
        });

    });
</script>
@endpush