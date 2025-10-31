<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Inquiry; 
use Illuminate\Support\Str;

class LandController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('property_type', 'land')->active();
        
       
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('ad_title', 'like', '%' . $request->search . '%')
                  ->orWhere('ad_description', 'like', '%' . $request->search . '%')
                  ->orWhere('street', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }
        
      
        if ($request->has('district') && !empty($request->district)) {
            $query->where('district', $request->district);
        }
        
        
        if ($request->has('type') && !empty($request->type)) {
            $query->where('property_subtype', $request->type);
        }
        
       
        if ($request->has('price_range') && !empty($request->price_range)) {
            switch ($request->price_range) {
                case 'under_5m':
                    $query->where('price', '<', 5000000);
                    break;
                case '5m_10m':
                    $query->whereBetween('price', [5000000, 10000000]);
                    break;
                case '10m_20m':
                    $query->whereBetween('price', [10000000, 20000000]);
                    break;
                case '20m_plus':
                    $query->where('price', '>', 20000000);
                    break;
            }
        }
        
        $posts = $query->latest()->paginate(12);
        
        $posts->getCollection()->transform(function ($post) {
           
            $post->is_hot_deal_calculated = $this->calculateIsHotDeal($post);
            $post->is_trending_calculated = $this->calculateIsTrending($post);
            $post->original_price_calculated = $this->calculateOriginalPrice($post);
            
            return $post;
        });
        
     
        $landCounts = [
            'bare_land' => Post::where('property_type', 'land')->where('property_subtype', 'bare_land')->active()->count(),
            'land_with_house' => Post::where('property_type', 'land')->where('property_subtype', 'land_with_house')->active()->count(),
            'coconut_land' => Post::where('property_type', 'land')->where('property_subtype', 'coconut_land')->active()->count(),
            'tea_land' => Post::where('property_type', 'land')->where('property_subtype', 'tea_land')->active()->count(),
            'rubber_land' => Post::where('property_type', 'land')->where('property_subtype', 'rubber_land')->active()->count(),
        ];
        
       
        $districtCounts = Post::where('property_type', 'land')
            ->active()
            ->select('district', \DB::raw('count(*) as count'))
            ->groupBy('district')
            ->pluck('count', 'district')
            ->toArray();

        return view('land.index', compact('posts', 'landCounts', 'districtCounts'));
    }


    //Check if post is hot deal 
    private function calculateIsHotDeal($post)
    {
        try {
            
            $similarProperties = Post::where('property_type', $post->property_type)
                ->where('property_subtype', $post->property_subtype)
                ->where('id', '!=', $post->id)
                ->active()
                ->get();

            if ($similarProperties->count() < 3) {
                return false; 
            }

            $averagePrice = $similarProperties->avg('price');
            
            if ($averagePrice && $post->price) {
                $discountPercentage = (($averagePrice - $post->price) / $averagePrice) * 100;
                return $discountPercentage >= 20; 
            }

            return false;
        } catch (\Exception $e) {
            \Log::error("Error calculating hot deal for post {$post->id}: " . $e->getMessage());
            return false;
        }
    }


    //Check if post is trending 
    private function calculateIsTrending($post)
    {
        try {
          
            
            $recentInquiries = Inquiry::where('post_id', $post->id)
                ->where('created_at', '>=', now()->subDays(7))
                ->count();

            return $recentInquiries >= 3; 
        } catch (\Exception $e) {
            \Log::error("Error calculating trending for post {$post->id}: " . $e->getMessage());
            return false;
        }
    }

   
   // Get original price for hot deals (calculate average price)
    private function calculateOriginalPrice($post)
    {
        if (!$this->calculateIsHotDeal($post)) {
            return null;
        }

        $similarProperties = Post::where('property_type', $post->property_type)
            ->where('property_subtype', $post->property_subtype)
            ->where('id', '!=', $post->id)
            ->active()
            ->get();

        return $similarProperties->avg('price');
    }
}