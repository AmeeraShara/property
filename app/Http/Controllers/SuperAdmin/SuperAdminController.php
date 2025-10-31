<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;

class SuperAdminController extends Controller
{
    // Show single post (view details)
    public function show($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();
        return view('superadmin.view', compact('post'));
    }

    // Show edit form
    public function edit($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();
        return view('superadmin.edit', compact('post'));
    }

public function update(Request $request, $id)
{
    $post = DB::table('posts')->where('id', $id)->first();

// Get remaining existing images
$images = json_decode($request->existing_images ?? '[]', true);
if (!is_array($images)) $images = [];

// Handle new uploads
if ($request->hasFile('images')) {
    foreach ($request->file('images') as $file) {
        // Create a unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Move file to public/images
        $file->move(public_path('images'), $filename);
        
        // Store the path for DB
        $images[] = '/images/' . $filename;
    }
}
// Existing videos
$videos = json_decode($request->existing_videos ?? '[]', true);
if (!is_array($videos)) $videos = [];

// Handle new uploads
if ($request->hasFile('videos')) {
    foreach ($request->file('videos') as $file) {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path(), $filename); 
        $videos[] = '/' . $filename;           
    }
}

// Save videos as JSON array in DB
$data['videos'] = json_encode($videos);

    
    $data = [
        'offer_type'        => $request->offer_type,
        'property_type'     => $request->property_type,
        'property_subtype'  => $request->property_subtype,
        'district'          => $request->district,
        'city'              => $request->city,
        'street'            => $request->street,
        'ad_title'          => $request->ad_title,
        'ad_description'    => $request->ad_description,
        'price'             => $request->price,
        'price_type'        => $request->price_type,
        'bedrooms'          => $request->bedrooms,
        'bathrooms'         => $request->bathrooms,
        'area'              => $request->area,
        'land_area'         => $request->land_area,
        'floor_area'        => $request->floor_area,
        'num_floors'        => $request->num_floors,
        'status'            => $request->status,
        'features'          => $request->features ? json_encode($request->features) : null,
        'contact_name'      => $request->contact_name,
        'contact_email'     => $request->contact_email,
        'contact_phone'     => $request->contact_phone,
        'whatsapp_phone'    => $request->whatsapp_phone,
        'images'            => json_encode($images),
        'video_path'        => $request->video_path,
        'commercial_type'   => $request->commercial_type,
        'floor_level'       => $request->floor_level,
        'land_unit'         => $request->land_unit,
        'is_featured'       => $request->has('is_featured') ? 1 : 0,
        'is_hot_deal'       => $request->has('is_hot_deal') ? 1 : 0,
        'is_trending'       => $request->has('is_trending') ? 1 : 0,
        'is_urgent'         => $request->has('is_urgent') ? 1 : 0,
        'size'              => $request->size,
        'location'          => $request->location,
        'amenities'         => $request->amenities ? json_encode($request->amenities) : null,
        'price_unit'        => $request->price_unit,
        'updated_at'        => now(),
    ];

    DB::table('posts')->where('id', $id)->update($data);

    return redirect()->route('superadmin.posts')->with('success', 'Post updated successfully!');
}


    // Delete post
    public function destroy($id)
    {
        DB::table('posts')->where('id', $id)->delete();
        return redirect()->route('superadmin.posts')->with('success', 'Post deleted successfully!');
    }

    //dashboard
    public function dashboard()
    {
        $totalPosts = \App\Models\Post::count();
        $totalUsers = \App\Models\User::count();
        $totalProperties = \App\Models\Property::count();
        $totalAdvertisers = \App\Models\Advertiser::count();
        $totalInquiries = \App\Models\Inquiry::count();
        $totalSubscribers = \App\Models\NewsletterSubscriber::count();

       
        return view('superadmin.dashboard', compact(
            'totalPosts',
            'totalUsers',
            'totalProperties',
            'totalAdvertisers',
            'totalInquiries',
            'totalSubscribers'
        ));
    }
   //posts
    public function posts(Request $request)
    {
     
        $query = DB::table('posts');

       
        if ($request->filled('offer_type')) {
            $query->where('offer_type', $request->offer_type);
        }
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

      
        $posts = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        
        $districts = DB::table('posts')->select('district')->distinct()->pluck('district');
        $cities = DB::table('posts')->select('city')->distinct()->pluck('city');

       
        return view('superadmin.posts', compact('posts', 'districts', 'cities'));
    }



    public function users()
    {
        $users = DB::table('users')->orderByDesc('created_at')->paginate(10);
        return view('superadmin.users', compact('users'));
    }

    // View single user
    public function showUser($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return view('superadmin.users-view', compact('user'));
    }

    // Show edit form
    public function editUser($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return view('superadmin.users-edit', compact('user'));
    }

    // Update user
    public function updateUser(Request $request, $id)
    {
        DB::table('users')->where('id', $id)->update([
            'first_name'         => $request->first_name,
            'last_name'          => $request->last_name,
            'email'              => $request->email,
            'phone'              => $request->phone,
            'user_type'          => $request->user_type,
            'preferred_location' => $request->preferred_location,
            'budget_min'         => $request->budget_min,
            'budget_max'         => $request->budget_max,
            'company_name'       => $request->company_name,
            'tax_id'             => $request->tax_id,
            'agency_name'        => $request->agency_name,
            'license_number'     => $request->license_number,
            'experience'         => $request->experience,
            'role'               => $request->role,
            'updated_at'         => now(),
        ]);

        return redirect()->route('superadmin.users')->with('success', 'User updated successfully!');
    }

    // Delete user
    public function destroyUser($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('superadmin.users')->with('success', 'User deleted successfully!');
    }


    // Show all properties with filters and pagination
    public function properties(Request $request)
    {
        $query = DB::table('properties');

        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

       
        $properties = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

       
        $districts = DB::table('properties')->select('district')->distinct()->pluck('district');
        $cities = DB::table('properties')->select('city')->distinct()->pluck('city');
        $types = DB::table('properties')->select('type')->distinct()->pluck('type');
        $categories = DB::table('properties')->select('category')->distinct()->pluck('category');

        return view('superadmin.properties', compact('properties', 'districts', 'cities', 'types', 'categories'));
    }

    // Show single property
    public function showProperty($id)
    {
        $property = DB::table('properties')->where('id', $id)->first();
        return view('superadmin.properties-view', compact('property'));
    }

    // Show edit form
    public function editProperty($id)
    {
        $property = DB::table('properties')->where('id', $id)->first();
        return view('superadmin.properties-edit', compact('property'));
    }

public function updateProperty(Request $request, $id)
{
    $property = DB::table('properties')->where('id', $id)->first();

    // Decode existing images safely
    $existingImages = $property->images ? json_decode($property->images, true) : [];

    // Ensure it's an array
    if (!is_array($existingImages)) {
        $existingImages = $existingImages ? [$existingImages] : [];
    }

    // Handle new uploaded images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename); 
            $existingImages[] = $filename; 
        }
    }

    // Prepare data to update
    $data = [
        'title'        => $request->title,
        'category'     => $request->category,
        'type'         => $request->type,
        'status'       => $request->status,
        'district'     => $request->district,
        'city'         => $request->city,
        'location'     => $request->location,
        'price'        => $request->price,
        'price_unit'   => $request->price_unit,
        'size'         => $request->size,
        'bedrooms'     => $request->bedrooms,
        'bathrooms'    => $request->bathrooms,
        'amenities'    => $request->amenities ? json_encode(array_map('trim', explode(',', $request->amenities))) : null,
        'description'  => $request->description,
        'is_featured'  => $request->has('is_featured') ? 1 : 0,
        'is_hot_deal'  => $request->has('is_hot_deal') ? 1 : 0,
        'is_trending'  => $request->has('is_trending') ? 1 : 0,
        'is_urgent'    => $request->has('is_urgent') ? 1 : 0,
        'images'       => json_encode($existingImages),
        'updated_at'   => now(),
    ];

    // Update in DB
    DB::table('properties')->where('id', $id)->update($data);

    return redirect()->route('superadmin.properties')->with('success', 'Property updated successfully!');
}

    // Delete property
    public function destroyProperty($id)
    {
        DB::table('properties')->where('id', $id)->delete();
        return redirect()->route('superadmin.properties')->with('success', 'Property deleted successfully!');
    }


    public function subscribers(Request $request)
    {
        $query = DB::table('newsletter_subscribers');

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', 0);
            }
        }



        $subscribers = $query->orderByDesc('subscribed_at')->paginate(10)->withQueryString();

        return view('superadmin.subscribers', compact('subscribers'));
    }


    // View single subscriber details
    public function showSubscriber($id)
    {
        $subscriber = DB::table('newsletter_subscribers')->where('id', $id)->first();
        return view('superadmin.subscribers-view', compact('subscriber'));
    }

    // Delete subscriber
    public function destroySubscriber($id)
    {
        DB::table('newsletter_subscribers')->where('id', $id)->delete();
        return redirect()->route('superadmin.subscribers')->with('success', 'Subscriber deleted successfully!');
    }

    // Optional: toggle active/inactive
    public function toggleSubscriberStatus($id)
    {
        $subscriber = DB::table('newsletter_subscribers')->where('id', $id)->first();
        $newStatus = $subscriber->is_active ? 0 : 1;

        DB::table('newsletter_subscribers')->where('id', $id)->update([
            'is_active' => $newStatus,
            'updated_at' => now()
        ]);

        return redirect()->route('superadmin.subscribers')->with('success', 'Subscriber status updated!');
    }
    // Show edit form
    public function editSubscriber($id)
    {
        $subscriber = DB::table('newsletter_subscribers')->where('id', $id)->first();
        return view('superadmin.subscribers-edit', compact('subscriber'));
    }

    // Update subscriber
    public function updateSubscriber(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email,' . $id,
            'is_active' => 'required|boolean',
        ]);

        DB::table('newsletter_subscribers')->where('id', $id)->update([
            'email' => $request->email,
            'is_active' => $request->is_active,
            'updated_at' => now(),
        ]);

        return redirect()->route('superadmin.subscribers')->with('success', 'Subscriber updated successfully!');
    }


    public function inquiries()
    {
        // Fetch all inquiries with pagination
        $inquiries = Inquiry::orderBy('created_at', 'desc')->paginate(10);

        return view('superadmin.inquiries', compact('inquiries'));
    }

    // Display all advertisers
    public function advertisers()
    {
        $advertisers = DB::table('advertisers')->orderBy('created_at', 'desc')->paginate(10);
        return view('superadmin.advertisers.index', compact('advertisers'));
    }

    // Show create form
    public function createAdvertiser()
    {
        return view('superadmin.advertisers.create');
    }

    // Store new advertiser
    public function storeAdvertiser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:advertisers,email',
            'phone' => 'nullable|string|max:20',
            'type' => 'required|string|max:50'
        ]);

        DB::table('advertisers')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('superadmin.advertisers')->with('success', 'Advertiser added successfully.');
    }

    // Show edit form
    public function editAdvertiser($id)
    {
        $advertiser = DB::table('advertisers')->where('id', $id)->first();
        return view('superadmin.advertisers.edit', compact('advertiser'));
    }

    // Update advertiser
    public function updateAdvertiser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:advertisers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'type' => 'required|string|max:50'
        ]);

        DB::table('advertisers')->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type,
            'updated_at' => now()
        ]);

        return redirect()->route('superadmin.advertisers')->with('success', 'Advertiser updated successfully.');
    }

    // Delete advertiser
    public function deleteAdvertiser($id)
    {
        DB::table('advertisers')->where('id', $id)->delete();
        return redirect()->route('superadmin.advertisers')->with('success', 'Advertiser deleted successfully.');
    }
}
