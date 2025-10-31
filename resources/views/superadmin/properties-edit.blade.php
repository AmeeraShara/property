<div class="container-fluid">
<form id="editPropertyForm" action="{{ route('superadmin.properties.update', $property->id) }}" method="POST" class="small" enctype="multipart/form-data">
        @csrf
        <div class="row g-2">

            {{-- Column 1: Property Basics --}}
            <div class="col-md-4">
                <div class="card border-dark text-dark bg-white" style="font-size:0.85rem;">
                    <div class="card-header fw-bold text-dark">Property Basics</div>
                    <div class="card-body p-2">
                        <div class="mb-2">
                            <label class="form-label fw-bold">Title *</label>
                            <input type="text" name="title" class="form-control form-control-sm" value="{{ $property->title }}" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold">Category</label>
                            <select name="category" class="form-select form-select-sm">
                                <option value="sale" {{ $property->category == 'sale' ? 'selected' : '' }}>Sale</option>
                                <option value="rental" {{ $property->category == 'rental' ? 'selected' : '' }}>Rental</option>
                                <option value="land" {{ $property->category == 'land' ? 'selected' : '' }}>Land</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold">Type</label>
                            <select name="type" class="form-select form-select-sm">
                                <option value="house" {{ $property->type == 'house' ? 'selected' : '' }}>House</option>
                                <option value="apartment" {{ $property->type == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="land" {{ $property->type == 'land' ? 'selected' : '' }}>Land</option>
                                <option value="commercial" {{ $property->type == 'commercial' ? 'selected' : '' }}>Commercial</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="active" {{ $property->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $property->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{-- Property Flags --}}
                <div class="card border-dark text-dark bg-white" style="font-size:0.85rem;">
                    <div class="card-header fw-bold">Property Flags</div>
                    <div class="card-body p-2">
                        <div class="row g-1">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_featured" {{ $property->is_featured ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold">Featured</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_hot_deal" {{ $property->is_hot_deal ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold">Hot Deal</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_trending" {{ $property->is_trending ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold">Trending</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_urgent" {{ $property->is_urgent ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold">Urgent</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            {{-- Column 2: Location & Features --}}
            <div class="col-md-4">
                <div class="card border-dark text-dark bg-white mb-2" style="font-size:0.85rem;">
                    <div class="card-header fw-bold">Location Details</div>
                    <div class="card-body p-2">
                        <div class="mb-2">
                            <label class="form-label fw-bold">District *</label>
                            <input type="text" name="district" class="form-control form-control-sm" value="{{ $property->district }}" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold">City *</label>
                            <input type="text" name="city" class="form-control form-control-sm" value="{{ $property->city }}" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold">Location *</label>
                            <input type="text" name="location" class="form-control form-control-sm" value="{{ $property->location }}" required>
                        </div>
                    </div>
                </div>

                <div class="card border-dark text-dark bg-white mb-2" style="font-size:0.85rem;">
                    <div class="card-header fw-bold">Pricing </div>
                    <div class="card-body p-2">
                        <div class="mb-2">
                            <label class="form-label fw-bold">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control form-control-sm" value="{{ $property->price }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold">Unit</label>
                            <input type="text" name="price_unit" class="form-control form-control-sm" value="{{ $property->price_unit }}" placeholder="e.g., $, €, ₹">
                        </div>

                    </div>
                </div>
            </div>

            {{-- Column 3: Pricing --}}
            <div class="col-md-4">

                <div class="card border-dark text-dark bg-white" style="font-size:0.85rem;">
                    <div class="card-header fw-bold">Property Features</div>
                    <div class="card-body p-2">
                        <div class="mb-2">
                            <label class="form-label fw-bold">Size</label>
                            <input type="text" name="size" class="form-control form-control-sm" value="{{ $property->size }}" placeholder="e.g., 1500 sq ft">
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold">Bedrooms</label>
                            <input type="number" name="bedrooms" class="form-control form-control-sm" value="{{ $property->bedrooms }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-bold">Bathrooms</label>
                            <input type="number" name="bathrooms" class="form-control form-control-sm" value="{{ $property->bathrooms }}">
                        </div>
                    </div>
                </div>


                {{-- Details --}}
                <div class="card border-dark text-dark bg-white" style="font-size:0.85rem;">
                    <div class="card-header fw-bold">Details</div>
                    <div class="card-body p-2">
                        <div class="row g-1">
                            <div class="mb-2">
                                <label class="form-label fw-bold">Amenities</label>
                                @php
                                $decodedAmenities = json_decode($property->amenities, true);
                                $amenitiesValue = is_array($decodedAmenities) ? implode(', ', $decodedAmenities) : $property->amenities;
                                @endphp
                                <input type="text" name="amenities" class="form-control form-control-sm" value="{{ $amenitiesValue }}" placeholder="Pool, Garden, Garage...">
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" rows="2" class="form-control form-control-sm" placeholder="Property description...">{{ $property->description }}</textarea>
                            </div>



                        </div>
                    </div>
                </div>

            </div>

<div class="card border-dark text-dark bg-white mt-2" style="font-size:0.85rem;">
    <div class="card-header fw-bold">Property Images</div>
    <div class="card-body p-2">
        {{-- Existing Images --}}
        <div class="mb-2">
            <label class="form-label fw-bold">Existing Images</label>
            <div class="d-flex flex-wrap gap-2">
                @php
                    $images = $property->images ? json_decode($property->images, true) : [];
                    if (!is_array($images)) {
                        $images = $images ? [$images] : [];
                    }
                @endphp

                @foreach($images as $index => $image)
                    <div class="position-relative" style="width: 80px; height: 80px;">
                        <img src="{{ asset('images/' . $image) }}" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;" alt="Property Image">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image" data-index="{{ $index }}" style="padding: 0.1rem 0.25rem;">&times;</button>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Hidden Input to Store Existing Images --}}
        <input type="hidden" name="existing_images" id="existing_images" value='@json($images)'>

        {{-- Upload New Images --}}
        <div class="mb-2">
            <label class="form-label fw-bold">Add / Replace Images</label>
            <input type="file" name="images[]" class="form-control form-control-sm" multiple accept="image/*">
            <small class="text-muted">You can upload multiple images. Existing images will remain unless removed.</small>
        </div>

        {{-- Optional Preview for New Images --}}
        <div class="row g-2 mt-2" id="newImagesPreview"></div>
    </div>
</div>



        </div>

        {{-- Form Actions --}}
        <div class="row mt-2">
            <div class="col-12">
                <div class="d-flex gap-2 justify-content-end border-top pt-2">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark btn-sm">Update Property</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('.remove-image').forEach(btn => {
    btn.addEventListener('click', function() {
        const parentDiv = this.parentElement;
        parentDiv.remove(); // remove from UI
    });
});


</script>
