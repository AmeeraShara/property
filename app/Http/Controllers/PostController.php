<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.post-ad');
    }

    /**
     * Store step 1 data and redirect to appropriate step 2
     */
   public function store(Request $request)
    {
        $validated = $request->validate([
            'offer_type' => 'required|string',
            'property_type' => 'required|string',
            'property_subtype' => 'nullable|string',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'street' => 'nullable|string|max:255',
        ]);

        // Debug: check what data is coming
        \Log::info('Step 1 Form Data:', $validated);

        // Store in session for multi-step form
        Session::put('post_step1', $validated);

        // Debug: check session data
        \Log::info('Session Data after Step 1:', Session::get('post_step1'));

        // Redirect based on property type
        return $this->redirectToStep2($validated['property_type']);
    }

    /**
     * Redirect to appropriate step 2 form based on property type
     */
    private function redirectToStep2($propertyType)
    {
        \Log::info('Redirecting to Step 2 for property type: ' . $propertyType);
        
        switch ($propertyType) {
            case 'house':
                return redirect()->route('posts.housepost');
            case 'apartment':
                return redirect()->route('posts.apartment-post');
            case 'land':
                return redirect()->route('posts.land-post');
            case 'commercial':
                return redirect()->route('posts.commercial-post');
            default:
                \Log::warning('Unknown property type: ' . $propertyType);
                return redirect()->route('posts.housepost');
        }
    }

    /**
     * Show house post form (step 2)
     */
    public function housepost()
    {
        return view('posts.post-house');
    }

    /**
     * Store house post data (step 2)
     */
    public function storehousepost(Request $request)
    {
        $validated = $request->validate([
            'bedrooms' => 'required|string',
            'bathrooms' => 'required|string',
            'land_area' => 'required|string',
            'floor_area' => 'required|string',
            'num_floors' => 'required|string',
            'price' => 'required|string',
            'price_type' => 'required|string',
            'features' => 'nullable|string',
            'ad_title' => 'required|string|max:255',
            'ad_description' => 'required|string',
        ]);

        // Store in session
        Session::put('post_step2', $validated);

        // Redirect to step 3
        return redirect()->route('posts.post3');
    }

    /**
     * Show apartment post form (step 2)
     */
    public function apartmentPost()
    {
        return view('posts.apartment-post');
    }

    /**
     * Store apartment post data (step 2)
     */
   public function storeApartment(Request $request)
    {
        $validated = $request->validate([
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'floor_area' => 'required|numeric',
            'price' => 'required|numeric',
            'price_type' => 'required|string',
            'features' => 'nullable|array',
            'ad_title' => 'required|string|max:255',
            'ad_description' => 'required|string',
        ]);

        // Debug: check what data is coming
        \Log::info('Apartment Step 2 Form Data:', $validated);

        // Store in session
        Session::put('post_step2', $validated);

        // Debug: check session data
        \Log::info('Session Data after Apartment Step 2:', Session::get('post_step2'));

        // Redirect to step 3
        return redirect()->route('posts.post3');
    }

   

    /**
     * Show land post form (step 2)
     */
    public function landPost()
    {
        return view('posts.land-post');
    }

    /**
     * Store land post data (step 2)
     */
    public function storeLand(Request $request)
{
    $validated = $request->validate([
        'land_size' => 'required|numeric',
        'land_unit' => 'required|string',
        'price' => 'required|numeric',
        'price_type' => 'required|string',
        'features' => 'nullable|array',
        'ad_title' => 'required|string|max:255',
        'ad_description' => 'required|string',
    ]);

    // Get property type and subtype from session
    $step1Data = Session::get('post_step1');
    
    // Merge with property type data
    $validated = array_merge($validated, [
        'property_type' => $step1Data['property_type'],
        'property_subtype' => $step1Data['property_subtype'] ?? null
    ]);

    Session::put('post_step2', $validated);
    
    \Log::info('Land Post Step 2 Data:', $validated);
    
    return redirect()->route('posts.post3');
}
    /**
     * Show commercial post form (step 2)
     */
    public function commercialPost()
    {
        return view('posts.commercial-post');
    }

    /**
     * Store commercial post data (step 2)
     */
   public function storeCommercial(Request $request)
{
    $validated = $request->validate([
        'floor_area' => 'required|numeric',
        'floor_level' => 'nullable|string',
        'price' => 'required|numeric',
        'price_type' => 'required|string',
        'features' => 'nullable|array',
        'ad_title' => 'required|string|max:255',
        'ad_description' => 'required|string',
    ]);

    // Get property type and subtype from session
    $step1Data = Session::get('post_step1');
    
    // Merge with property type data
    $validated = array_merge($validated, [
        'property_type' => $step1Data['property_type'],
        'property_subtype' => $step1Data['property_subtype'] ?? null,
        'commercial_type' => $step1Data['property_subtype'] ?? null
    ]);

    Session::put('post_step2', $validated);
    
    \Log::info('Commercial Post Step 2 Data:', $validated);
    
    return redirect()->route('posts.post3');
}

    /**
     * Show final step form (step 3)
     */
    public function ThirdPost()
    {
        // Check if user is super admin
        $isSuperAdmin = Auth::check() && Auth::user()->role === 'super_admin';
        
        return view('posts.post3', compact('isSuperAdmin'));
    }

    /**
     * Store all post data and save to database
     */
   public function storeFinal(Request $request)
{
    $user = Auth::user();
    $isSuperAdmin = $user && $user->role === 'super_admin';

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'contact_tel' => 'required|string',
        'whatsapp_tel' => 'nullable|string',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'video' => 'nullable|file|mimes:mp4,avi,mov|max:10240',
    ]);

    // For super admin: Bypass payment validation and force 'free'
    if ($isSuperAdmin) {
        $validated['payment_option'] = 'free';
        \Log::info('Super admin detected - forcing payment_option to free');
    } else {
        // For non-super admins: Require payment option
        $validated['payment_option'] = $request->validate([
            'payment_option' => ['required', 'in:free,premium'],
        ])['payment_option'];
        
        // If premium, handle payment (placeholder - integrate gateway here)
        if ($validated['payment_option'] === 'premium') {
            // TODO: Integrate payment gateway (e.g., Stripe, PayPal)
            // Example: $payment = $this->processPayment($request, 500); // LKR 500
            // if (!$payment->success) { return back()->with('error', 'Payment failed.'); }
            
            \Log::info('Premium selected - Payment processed (placeholder)');
        }
    }

    // Get all data from sessions
    $step1Data = Session::get('post_step1');
    $step2Data = Session::get('post_step2');

    \Log::info('Step 1 Data: ', $step1Data ?? []);
    \Log::info('Step 2 Data: ', $step2Data ?? []);

      // DEBUG: Check if property_subtype exists in step1 data
        \Log::info('Property Subtype in Step 1: ' . ($step1Data['property_subtype'] ?? 'NOT FOUND'));

    // Handle file uploads - IMPROVED
    $imagePaths = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            // Generate unique filename
            $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('post-images', $filename, 'public');
            $imagePaths[] = $path; // Store relative path
            
            \Log::info("Image {$index} stored at: " . $path);
        }
    } else {
        \Log::info('No images in request');
    }

    \Log::info('Final Image Paths: ', $imagePaths);

    $videoPath = null;
    if ($request->hasFile('video')) {
        $videoPath = $request->file('video')->store('post-videos', 'public');
    }

    // Merge all data
    $postData = array_merge($step1Data, $step2Data, [
        'contact_name' => $validated['name'],
        'contact_email' => $validated['email'],
        'contact_phone' => $validated['contact_tel'],
        'whatsapp_phone' => $validated['whatsapp_tel'] ?? null,
        'payment_option' => $validated['payment_option'],  // Now always set
        'images' => $imagePaths, // This will use the setImagesAttribute mutator
        'video_path' => $videoPath,
        'user_id' => auth()->id() ?? null,
        'status' => 'active'
    ]);

    \Log::info('Final Post Data before create: ', $postData);
    
        // FIX: Ensure property_subtype is properly set
        if (isset($step1Data['property_subtype'])) {
            $postData['property_subtype'] = $step1Data['property_subtype'];
        } else {
            $postData['property_subtype'] = null;
        }

        \Log::info('Final Post Data with property_subtype: ', [
            'property_type' => $postData['property_type'] ?? 'N/A',
            'property_subtype' => $postData['property_subtype'] ?? 'N/A',
            'offer_type' => $postData['offer_type'] ?? 'N/A'
        ]);

    try {
        // Create post
        $post = Post::create($postData);
        
        \Log::info('Post created successfully. ID: ' . $post->id);
        \Log::info('Stored images in DB: ' . $post->images);

        // Clear session data
        Session::forget(['post_step1', 'post_step2']);

        $message = $isSuperAdmin 
            ? 'Ad posted successfully (no payment required for super admins)!'
            : 'Ad posted successfully!';
            
        return redirect()->route('posts.show', $post->id)
            ->with('success', $message);
            
    } catch (\Exception $e) {
        \Log::error('Error creating post: ' . $e->getMessage());
        \Log::error('Error trace: ' . $e->getTraceAsString());
        return back()->with('error', 'Error creating post: ' . $e->getMessage());
    }
}
    /**
     * Display the specified resource.
     */
     public function show(string $id)
{
    $post = Post::findOrFail($id);
    
    // Debug the post data
    \Log::info('Post Data:', [
        'id' => $post->id,
        'ad_title' => $post->ad_title,
        'ad_description' => $post->ad_description,
        'property_type' => $post->property_type,
        'street' => $post->street,
        'images' => $post->images,
        'payment_option' => $post->payment_option,  // New: Log payment option for debugging
    ]);
    
    return view('posts.index', compact('post'))  // Fixed: Changed to 'posts.show' view
        ->with('success', 'Post viewed successfully!');
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'offer_type' => 'required|string',
            'property_type' => 'required|string',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'street' => 'nullable|string|max:255',
        ]);

        $post = Post::findOrFail($id);
        $post->update($validated);

        return redirect()->route('posts.index', $post->id)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }
}