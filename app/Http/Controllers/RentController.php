<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Inquiry; 
use Illuminate\Support\Str;
use Carbon\Carbon;

class RentController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('offer_type', 'rent')->active();
        
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('ad_title', 'like', '%' . $request->search . '%')
                  ->orWhere('ad_description', 'like', '%' . $request->search . '%')
                  ->orWhere('street', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%')
                  ->orWhere('district', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('location') && !empty($request->location)) {
            $query->where('district', $request->location);
        }
        
        if ($request->has('property_type') && !empty($request->property_type)) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->has('price_range') && !empty($request->price_range)) {
            switch ($request->price_range) {
                case 'under_50k':
                    $query->where('price', '<', 50000);
                    break;
                case '50k_100k':
                    $query->whereBetween('price', [50000, 100000]);
                    break;
                case '100k_200k':
                    $query->whereBetween('price', [100000, 200000]);
                    break;
                case '200k_plus':
                    $query->where('price', '>', 200000);
                    break;
            }
        }
        if ($request->has('district') && !empty($request->district)) {
            $query->where('district', $request->district);
        }
        
        $posts = $query->latest()->paginate(12);
        $posts->getCollection()->transform(function ($post) {
           
            $post->is_hot_deal_calculated = $this->calculateIsHotDeal($post);
            $post->is_trending_calculated = $this->calculateIsTrending($post);
            $post->dynamic_status = $this->getDynamicStatus($post);
            $post->original_price_calculated = $this->calculateOriginalPrice($post);
            $post->discount_percentage_calculated = $this->calculateDiscountPercentage($post);
            
            return $post;
        });
        
        $propertyCounts = [
            'house' => Post::where('offer_type', 'rent')->where('property_type', 'house')->active()->count(),
            'apartment' => Post::where('offer_type', 'rent')->where('property_type', 'apartment')->active()->count(),
            'villa' => Post::where('offer_type', 'rent')->where('property_type', 'villa')->active()->count(),
            'room' => Post::where('offer_type', 'rent')->where('property_type', 'room')->active()->count(),
            'commercial' => Post::where('offer_type', 'rent')->where('property_type', 'commercial')->active()->count(),
        ];
        
        $districtCounts = Post::where('offer_type', 'rent')
            ->active()
            ->select('district', \DB::raw('count(*) as count'))
            ->groupBy('district')
            ->pluck('count', 'district')
            ->toArray();

        return view('rent.index', compact('posts', 'propertyCounts', 'districtCounts'));
    }
    

    /**
     * AUTO CALCULATION 
     */
    private function calculateIsHotDeal($post)
    {
        // Hot deal conditions for rental properties:
        // 1. Property is less than 5 days old
        // 2. Has at least 2 images
        // 3. Price is below market average for similar properties
        // 4. Good location (major cities get preference)
        
        $daysOld = $post->created_at->diffInDays(now());
        $hasEnoughImages = !empty($post->images) && is_array($post->images) && count($post->images) >= 2;
        $isBelowMarketPrice = $this->isBelowMarketPrice($post);
        $isGoodLocation = in_array($post->district, ['Colombo', 'Kandy', 'Galle', 'Negombo']);
        
        return $daysOld <= 5 && $hasEnoughImages && ($isBelowMarketPrice || $isGoodLocation);
    }
    

    /**
     * AUTO CALCULATION 
     */
    private function calculateIsTrending($post)
    {
        // Trending conditions for rental properties:
        // 1. Property is less than 15 days old
        // 2. Has multiple images
        // 3. In popular districts
        // 4. Good price range
        
        $daysOld = $post->created_at->diffInDays(now());
        $hasMultipleImages = !empty($post->images) && is_array($post->images) && count($post->images) >= 2;
        $isPopularDistrict = in_array($post->district, ['Colombo', 'Kandy', 'Gampaha', 'Kalutara', 'Galle']);
        $isGoodPriceRange = $post->price >= 25000 && $post->price <= 150000;
        
        return $daysOld <= 15 && $hasMultipleImages && ($isPopularDistrict || $isGoodPriceRange);
    }
    

    /**
     * AUTO CALCULATION 
     */
    private function isBelowMarketPrice($post)
    {
        
        $priceThresholds = [
            'house' => 75000,
            'apartment' => 50000,
            'villa' => 120000,
            'room' => 20000,
            'commercial' => 80000,
        ];
        
        $threshold = $priceThresholds[$post->property_type] ?? 50000;
        
        
        return $post->price <= ($threshold * 0.85);
    }
    

    /**
     * AUTO CALCULATION 
     */
    private function getDynamicStatus($post)
    {
        if ($this->calculateIsHotDeal($post)) {
            return 'hot_deal';
        }
        
        if ($this->calculateIsTrending($post)) {
            return 'trending';
        }
        
        return 'normal';
    }
    

    /**
     * Calculate original price for discount display
     */
    private function calculateOriginalPrice($post)
    {
        
        if ($post->original_price) {
            return $post->original_price;
        }
        
       
        if ($this->calculateIsHotDeal($post)) {
            $discountPercentage = rand(15, 25);
            return $post->price * (1 + ($discountPercentage / 100));
        }
        
        return $post->price; 
    }
    

    /**
     * Calculate discount percentage
     */
    private function calculateDiscountPercentage($post)
    {
        $originalPrice = $this->calculateOriginalPrice($post);
        if ($originalPrice > $post->price) {
            return round((($originalPrice - $post->price) / $originalPrice) * 100);
        }
        return 0;
    }


    /**
     * AUTO CALCULATION 
     */
    public function autoHotDeals(Request $request)
    {
        $hotDeals = Post::where('offer_type', 'rent')
            ->active()
            ->get()
            ->filter(function($post) {
                return $this->calculateIsHotDeal($post);
            })
            ->take(12);

        return response()->json([
            'success' => true,
            'data' => $hotDeals,
            'count' => $hotDeals->count()
        ]);
    }


    /**
     * AUTO CALCULATION
     */
    public function autoTrending(Request $request)
    {
        $trending = Post::where('offer_type', 'rent')
            ->active()
            ->get()
            ->filter(function($post) {
                return $this->calculateIsTrending($post);
            })
            ->take(12);

        return response()->json([
            'success' => true,
            'data' => $trending,
            'count' => $trending->count()
        ]);
    }

    
    /**
     * AUTO CALCULATION 
     */
    public function debugAutoCalculation($id)
    {
        $post = Post::findOrFail($id);
        
        $debugInfo = [
            'post_id' => $post->id,
            'title' => $post->ad_title,
            'property_type' => $post->property_type,
            'district' => $post->district,
            'price' => $post->price,
            'created_at' => $post->created_at,
            'days_old' => $post->created_at->diffInDays(now()),
            'image_count' => !empty($post->images) ? count($post->images) : 0,
            'is_hot_deal_calculated' => $this->calculateIsHotDeal($post),
            'is_trending_calculated' => $this->calculateIsTrending($post),
            'dynamic_status' => $this->getDynamicStatus($post),
            'is_below_market_price' => $this->isBelowMarketPrice($post),
            'hot_deal_conditions' => [
                'days_old_<=_5' => $post->created_at->diffInDays(now()) <= 5,
                'has_>=_2_images' => !empty($post->images) && is_array($post->images) && count($post->images) >= 2,
                'below_market_price' => $this->isBelowMarketPrice($post),
                'good_location' => in_array($post->district, ['Colombo', 'Kandy', 'Galle', 'Negombo'])
            ],
            'trending_conditions' => [
                'days_old_<=_15' => $post->created_at->diffInDays(now()) <= 15,
                'has_>=_2_images' => !empty($post->images) && is_array($post->images) && count($post->images) >= 2,
                'popular_district' => in_array($post->district, ['Colombo', 'Kandy', 'Gampaha', 'Kalutara', 'Galle']),
                'good_price_range' => $post->price >= 25000 && $post->price <= 150000
            ]
        ];

        return response()->json($debugInfo);
    }
}