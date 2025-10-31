<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container-fluid bg-white px-3 py-3">
  <div class="row justify-content-center">
    <main class="col-12 col-lg-10">

      <!-- Title -->
      <h4 class="text-center mb-3 fw-bold text-black">Post Details</h4>



      <form class="small">
        <div class="row g-2">

          <!-- Column 1 -->
          <div class="col-md-4 d-flex flex-column gap-2">

            <!-- Basic Info -->
            <div class="card border-dark flex-fill">
              <div class="card-header fw-bold border-dark text-center py-1">Basic Information</div>
              <div class="card-body p-2">
                <div><strong>Post ID:</strong> {{ $post->id }}</div>
                <div><strong>User ID:</strong> {{ $post->user_id ?? '-' }}</div>
                <div><strong>Offer Type:</strong> {{ ucfirst($post->offer_type) }}</div>
                <div><strong>Property Type:</strong> {{ ucfirst($post->property_type) }}</div>
                <div><strong>Title:</strong> {{ $post->ad_title ?? '-' }}</div>
              </div>
            </div>

            <!-- Location -->
            <div class="card border-dark flex-fill">
              <div class="card-header fw-bold border-dark text-center py-1">Location</div>
              <div class="card-body p-2">
                <div><strong>District:</strong> {{ $post->district }}</div>
                <div><strong>City:</strong> {{ $post->city }}</div>
                <div><strong>Street:</strong> {{ $post->street ?? '-' }}</div>
              </div>
            </div>

            <!-- Description -->
            <div class="card border-dark flex-fill">
              <div class="card-header fw-bold border-dark text-center py-1">Description</div>
              <div class="card-body p-2">
                <p class="mb-0">{{ $post->ad_description ?? '-' }}</p>
              </div>
            </div>
          </div>

          <!-- Column 2 -->
          <div class="col-md-4 d-flex flex-column gap-2">

            <!-- Pricing -->
            <div class="card border-dark flex-fill">
              <div class="card-header fw-bold border-dark text-center py-1">Pricing & Status</div>
              <div class="card-body p-2">
                <div><strong>Price:</strong> {{ number_format($post->price, 2) }} {{ $post->price_unit }}</div>
                <div><strong>Price Type:</strong> {{ $post->price_type ?? '-' }}</div>
                <div><strong>Size:</strong> {{ $post->size ?? '-' }}</div>
                <div><strong>Status:</strong>
                  <span class="badge bg-{{ 
                    $post->status == 'published' ? 'success' : 
                    ($post->status == 'pending' ? 'warning' : 'secondary') 
                  }}">{{ ucfirst($post->status) }}</span>
                </div>
              </div>
            </div>

            <!-- Tags -->
            <div class="card border-dark flex-fill">
              <div class="card-header fw-bold border-dark text-center py-1">Tags</div>
              <div class="card-body p-2">
                <div><strong>Featured:</strong> {{ $post->is_featured ? 'Yes' : 'No' }}</div>
                <div><strong>Hot Deal:</strong> {{ $post->is_hot_deal ? 'Yes' : 'No' }}</div>
                <div><strong>Trending:</strong> {{ $post->is_trending ? 'Yes' : 'No' }}</div>
                <div><strong>Urgent:</strong> {{ $post->is_urgent ? 'Yes' : 'No' }}</div>
              </div>
            </div>

            <!-- Features -->
            <div class="card border-dark flex-fill">
              <div class="card-header fw-bold border-dark text-center py-1">Features</div>
              <div class="card-body p-2">
                @php
                  $features = collect(json_decode($post->features ?? '[]', true))->filter()->all();
                @endphp
                <p class="mb-0">{{ !empty($features) ? implode(', ', $features) : '-' }}</p>
              </div>
            </div>
          </div>

          <!-- Column 3 -->
          <div class="col-md-4 d-flex flex-column gap-2">

            <!-- Property Details -->
            <div class="card border-dark flex-fill">
              <div class="card-header fw-bold border-dark text-center py-1">Property Details</div>
              <div class="card-body p-2">
                <div><strong>Bedrooms:</strong> {{ $post->bedrooms ?? '-' }}</div>
                <div><strong>Bathrooms:</strong> {{ $post->bathrooms ?? '-' }}</div>
                <div><strong>Area:</strong> {{ $post->area ?? '-' }}</div>
                <div><strong>Land Area:</strong> {{ $post->land_area ?? '-' }}</div>
                <div><strong>Floor Area:</strong> {{ $post->floor_area ?? '-' }}</div>
                <div><strong>Floors:</strong> {{ $post->num_floors ?? '-' }}</div>
                <div><strong>Floor Level:</strong> {{ $post->floor_level ?? '-' }}</div>
                <div><strong>Land Unit:</strong> {{ $post->land_unit ?? '-' }}</div>
              </div>
            </div>

            <!-- Contact -->
            <div class="card border-dark flex-fill">
              <div class="card-header fw-bold border-dark text-center py-1">Contact Information</div>
              <div class="card-body p-2">
                <div><strong>Name:</strong> {{ $post->contact_name ?? '-' }}</div>
                <div><strong>Phone:</strong> {{ $post->contact_phone ?? '-' }}</div>
                <div><strong>Email:</strong> {{ $post->contact_email ?? '-' }}</div>
                <div><strong>WhatsApp:</strong> {{ $post->whatsapp_phone ?? '-' }}</div>
              </div>
            </div>

            <!-- Amenities -->
            <div class="card border-dark flex-fill">
              <div class="card-header fw-bold border-dark text-center py-1">Amenities</div>
              <div class="card-body p-2">
                <p class="mb-0">{{ $post->amenities ? implode(', ', json_decode($post->amenities, true)) : '-' }}</p>
              </div>
            </div>
          </div>
        </div>
      </form>
    </main>
  </div>
</div>

<style>
  body { background-color: #fff !important; color: #000 !important; }
  .card {
    border: 1px solid #000;
    border-radius: 6px;
    background-color: #fff;
    height: 100%;
    font-size: 0.8rem;
  }
  .card-header {
    background-color: #fff !important;
    color: #000 !important;
    border-bottom: 1px solid #000;
    font-weight: 600;
    font-size: 0.8rem;
  }
  .card-body div, .card-body p { margin-bottom: 2px; }
  .btn-outline-dark {
    border: 1px solid #000 !important;
    color: #000 !important;
    font-size: 0.8rem;
  }
  .btn-outline-dark:hover {
    background-color: #000 !important;
    color: #fff !important;
  }
  .badge { font-size: 0.7rem; }
</style>
