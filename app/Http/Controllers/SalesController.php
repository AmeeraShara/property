<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Inquiry; 
use Illuminate\Support\Str;

class SalesController extends Controller
{

    public function index()
    {
       
        $properties = Post::where('status', 'active')
            ->where('offer_type', 'sale') 
            ->latest()
            ->paginate(12); 

        $propertyCounts = [
            'all' => Post::where('status', 'active')->where('offer_type', 'sale')->count(),
            'house' => Post::where('status', 'active')->where('offer_type', 'sale')->where('property_type', 'house')->count(),
            'apartment' => Post::where('status', 'active')->where('offer_type', 'sale')->where('property_type', 'apartment')->count(),
            'villa' => Post::where('status', 'active')->where('offer_type', 'sale')->where('property_type', 'villa')->count(),
            'commercial' => Post::where('status', 'active')->where('offer_type', 'sale')->where('property_type', 'commercial')->count(),
        ];

        return view('sales.index', compact('properties', 'propertyCounts'));
    }


    // Add search method for filtering
    public function search(Request $request)
    {
        $query = Post::where('status', 'active')->where('offer_type', 'sale');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('ad_title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('ad_description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('district', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('city', 'LIKE', "%{$searchTerm}%");
            });
        }

        if ($request->has('location') && !empty($request->location)) {
            $query->where('district', $request->location);
        }

      
        if ($request->has('property_type') && !empty($request->property_type)) {
            $query->where('property_type', $request->property_type);
        }

       
        if ($request->has('price_range') && !empty($request->price_range)) {
            $priceRange = $request->price_range;
            switch ($priceRange) {
                case 'Under 5M':
                    $query->where('price', '<', 5000000);
                    break;
                case '5M - 10M':
                    $query->whereBetween('price', [5000000, 10000000]);
                    break;
                case '10M - 20M':
                    $query->whereBetween('price', [10000000, 20000000]);
                    break;
                case '20M+':
                    $query->where('price', '>', 20000000);
                    break;
            }
        }

        if ($request->has('district') && !empty($request->district)) {
            $query->where('district', $request->district);
        }

        $properties = $query->latest()->paginate(12);

        if ($request->ajax()) {
            return view('sales.partials.properties_grid', compact('properties'))->render();
        }

        $propertyCounts = [
            'all' => Post::where('status', 'active')->where('offer_type', 'sale')->count(),
            'house' => Post::where('status', 'active')->where('offer_type', 'sale')->where('property_type', 'house')->count(),
            'apartment' => Post::where('status', 'active')->where('offer_type', 'sale')->where('property_type', 'apartment')->count(),
            'villa' => Post::where('status', 'active')->where('offer_type', 'sale')->where('property_type', 'villa')->count(),
            'commercial' => Post::where('status', 'active')->where('offer_type', 'sale')->where('property_type', 'commercial')->count(),
        ];

        return view('sales.index', compact('properties', 'propertyCounts'));
    }

    
    public function homeDetails($id)
    {
     try {
        
        $property = Post::with(['user'])
            ->where('id', $id)
            ->where('status', 'active')
            ->firstOrFail();

        
        $similarProperties = Post::where('id', '!=', $id)
            ->where('property_type', $property->property_type)
            ->where('status', 'active')
            ->where(function($query) use ($property) {
                $query->where('district', $property->district)
                      ->orWhere('property_type', $property->property_type);
            })
            ->where('price', '>=', $property->price * 0.7) 
            ->where('price', '<=', $property->price * 1.3)
            ->inRandomOrder() 
            ->limit(4)
            ->get();

        if ($similarProperties->count() === 0) {
            $similarProperties = Post::where('id', '!=', $id)
                ->where('status', 'active')
                ->inRandomOrder()
                ->limit(3)
                ->get();
        }

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        abort(404, 'Property not found or not active');
    }

    return view('sales.home-details', compact('property', 'similarProperties'));
   }


    /**
     * propertyDetails
     */
    public function propertyDetails($id)
    {
        try {
           
            $property = Post::with(['user'])
                ->where('id', $id)
                ->where('status', 'active')
                ->firstOrFail();

            
            $property = $this->formatPropertyData($property);

            $similarProperties = $this->getSimilarProperties($property);

            $viewName = $this->determineViewByPropertyType($property->property_type);

            return view($viewName, compact('property', 'similarProperties'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Property not found or not active');
        }
    }


    /**
     *formatPropertyData
     */
    private function formatPropertyData($property)
    {
       
        if (empty($property->images)) {
            $property->gallery_images = [];
        } else {
         
            $property->gallery_images = $this->formatGalleryImages($property->images);
        }

        
        if (empty($property->features)) {
            $property->features = [];
        } else {
            $property->features = $this->formatFeatures($property->features);
        }

        
        if (empty($property->main_image)) {
            $property->main_image = $property->getFirstImageAttribute();
        }

       
        $property->title = $property->ad_title ?? 'No Title';
        $property->description = $property->ad_description ?? 'No description available';
        $property->location = ($property->district ?? '') . ', ' . ($property->city ?? '');
        $property->type = $property->property_type ?? 'Property';
        $property->size = $property->land_area ?? $property->size ?? 0;
        $property->size_unit = $property->land_unit ?? 'Perches';
        $property->price_type = $property->price_type ?? 'Fixed Price';
        
        
        if (!isset($property->advertiser)) {
            $property->advertiser = (object)[
                'name' => $property->contact_name ?? 'Unknown',
                'type' => 'Owner',
                'phone' => $property->contact_phone ?? 'Not provided',
                'avatar' => null
            ];
        }

        return $property;
    }


    /**
     * formatGalleryImages
     */
    private function formatGalleryImages($images)
    {
        if (is_array($images) && !empty($images)) {
            return array_map(function($image) {
                return $this->getImageUrl($image);
            }, $images);
        }

        if (is_string($images)) {
            $decoded = json_decode($images, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && !empty($decoded)) {
                return array_map(function($image) {
                    return $this->getImageUrl($image);
                }, $decoded);
            }
            
           
            $trimmed = trim($images);
            if (!empty($trimmed)) {
                return [$this->getImageUrl($trimmed)];
            }
        }

        return [
            asset('images/property1.jpg'),
            asset('images/property2.jpg'),
            asset('images/property3.jpg')
        ];
    }


    /**
     * formatFeatures
     */
    private function formatFeatures($features)
    {
        if (is_array($features) && !empty($features)) {
            return array_filter($features);
        }

        if (is_string($features)) {
            $decoded = json_decode($features, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && !empty($decoded)) {
                return array_filter($decoded);
            }
            
            if (strpos($features, ',') !== false) {
                return array_filter(array_map('trim', explode(',', $features)));
            }
            
            $trimmed = trim($features);
            if (!empty($trimmed)) {
                return [$trimmed];
            }
        }

        return [
            'Near to Main Road',
            'Good Accessibility',
            'Prime Location'
        ];
    }


    /**
     * Get full image URL
     */
    private function getImageUrl($imagePath)
    {
        $imagePath = trim($imagePath, '[]"\'');
        
        if (strpos($imagePath, 'http') === 0) {
            return $imagePath;
        }
        
        if (file_exists(public_path('storage/' . $imagePath))) {
            return asset('storage/' . $imagePath);
        }
        
        if (file_exists(public_path($imagePath))) {
            return asset($imagePath);
        }
        
        return asset('images/property1.jpg');
    }


    /**
     * Determine
     */
    private function determineViewByPropertyType($propertyType)
    {
        $propertyType = strtolower($propertyType);
        $landTypes = ['land', 'bare land', 'agricultural land', 'commercial land', 'bare-land']; 
        $houseTypes = ['house', 'apartment', 'villa', 'bungalow', 'room'];
        
        if (in_array($propertyType, $landTypes)) {
            return 'sales.land-details';
        } elseif (in_array($propertyType, $houseTypes)) {
            return 'sales.home-details';
        } else {
            
            return 'sales.home-details';
        }
    }


    /**
     * Get similar properties
     */
    private function getSimilarProperties($property)
    {
        $similarProperties = Post::where('id', '!=', $property->id)
            ->where('property_type', $property->property_type)
            ->where('status', 'active')
            ->where(function($query) use ($property) {
                $query->where('district', $property->district)
                      ->orWhere('property_type', $property->property_type);
            })
            ->where('price', '>=', $property->price * 0.7)
            ->where('price', '<=', $property->price * 1.3)
            ->inRandomOrder()
            ->limit(4)
            ->get();

       
        $similarProperties->each(function($prop) {
            $prop->thumbnail = $prop->getFirstImageAttribute();
            $prop->short_description = Str::limit($prop->ad_description ?? 'No description', 60);
            $prop->type = $prop->property_type ?? 'Property';
            $prop->size = $prop->land_area ?? $prop->size ?? 0;
            $prop->size_unit = $prop->land_unit ?? 'Perches';
        });

       
        if ($similarProperties->count() === 0) {
            $similarProperties = Post::where('id', '!=', $property->id)
                ->where('status', 'active')
                ->inRandomOrder()
                ->limit(3)
                ->get();
                
            $similarProperties->each(function($prop) {
                $prop->thumbnail = $prop->getFirstImageAttribute();
                $prop->short_description = Str::limit($prop->ad_description ?? 'No description', 60);
                $prop->type = $prop->property_type ?? 'Property';
                $prop->size = $prop->land_area ?? $prop->size ?? 0;
                $prop->size_unit = $prop->land_unit ?? 'Perches';
            });
        }

        return $similarProperties;
    }


    // submitInquiry
    public function submitInquiry(Request $request)
    {
        \DB::beginTransaction();
        
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'message' => 'required|string',
                'property_id' => 'required|exists:posts,id'
            ]);

            $inquiry = Inquiry::create([
                'property_id' => $validated['property_id'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'message' => $validated['message'],
                'ip_address' => $request->ip()
            ]);

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully! We will contact you soon.',
                'inquiry_id' => $inquiry->id
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            
            \Log::error('Inquiry submission failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again later.'
            ], 500);
        }
    }


    public function saveProperty(Request $request)
    {
        try {
            $request->validate([
                'property_id' => 'required|exists:posts,id',
                'action' => 'required|in:add,remove'
            ]);

            $propertyId = $request->property_id;
            
            if (auth()->check()) {
                $user = auth()->user();
                
                if ($request->action === 'add') {
                    $user->favoriteProperties()->syncWithoutDetaching([$propertyId]);
                } else {
                    $user->favoriteProperties()->detach($propertyId);
                }
                
                return response()->json([
                    'success' => true,
                    'message' => $request->action === 'add' ? 'Property saved to favorites' : 'Property removed from favorites'
                ]);
            } else {
                $favorites = session()->get('favorites', []);
                
                if ($request->action === 'add') {
                    $favorites[$propertyId] = true;
                    session()->put('favorites', $favorites);
                } else {
                    unset($favorites[$propertyId]);
                    session()->put('favorites', $favorites);
                }
                
                return response()->json([
                    'success' => true,
                    'message' => $request->action === 'add' ? 'Property saved to favorites' : 'Property removed from favorites'
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Save property failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save property. Please try again.'
            ], 500);
        }
    }


    public function favorites()
    {
        $favorites = [];
        
        if (auth()->check()) {
            $favorites = auth()->user()->favoriteProperties()->get();
        } else {
            $favoriteIds = array_keys(session()->get('favorites', []));
            $favorites = Post::whereIn('id', $favoriteIds)->get();
        }
        
        return view('sales.favorites', compact('favorites'));
    }
}