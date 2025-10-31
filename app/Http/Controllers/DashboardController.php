<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Property;
use App\Models\HeroBackground;

class DashboardController extends Controller
{
     public function index()
    {
        try {
          
            $newArrivals = Post::where('status', 'active')
                  ->latest('created_at')
                  ->take(10)
                  ->get();

            
            $featuredProperties = Post::where('is_featured', true)
                                    ->where('status', 'active')
                                    ->latest()
                                    ->take(4)
                                    ->get();
            
           
            $allActiveProperties = Post::where('status', 'active')
                                     ->latest()
                                     ->get();
            
            
            $normalProperties = $allActiveProperties->filter(function($post) {
                return !$post->is_hot_deal && 
                       !$post->is_hot_deal_calculated && 
                       !$post->is_trending && 
                       !$post->is_trending_calculated;
            })->take(3);
            
            // Line 2: Hot Deal Properties 
            $hotDealProperties = $allActiveProperties->filter(function($post) {
                return $post->is_hot_deal || $post->is_hot_deal_calculated;
            })->take(3);
            
            // Line 3: Trending Properties 
            $trendingProperties = $allActiveProperties->filter(function($post) {
                return $post->is_trending || $post->is_trending_calculated;
            })->take(3);
            
            // If any line doesn't have enough properties, fill with normal ones
            if ($normalProperties->count() < 3) {
                $needed = 3 - $normalProperties->count();
                $extraNormals = $allActiveProperties->whereNotIn('id', $normalProperties->pluck('id'))
                                                  ->whereNotIn('id', $hotDealProperties->pluck('id'))
                                                  ->whereNotIn('id', $trendingProperties->pluck('id'))
                                                  ->take($needed);
                $normalProperties = $normalProperties->merge($extraNormals)->take(3);
            }
            
            if ($hotDealProperties->count() < 3) {
                $needed = 3 - $hotDealProperties->count();
                $extraHotDeals = $allActiveProperties->whereNotIn('id', $normalProperties->pluck('id'))
                                                   ->whereNotIn('id', $hotDealProperties->pluck('id'))
                                                   ->whereNotIn('id', $trendingProperties->pluck('id'))
                                                   ->filter(function($post) {
                                                       return $post->is_hot_deal || $post->is_hot_deal_calculated;
                                                   })
                                                   ->take($needed);
                $hotDealProperties = $hotDealProperties->merge($extraHotDeals)->take(3);
            }
            
            if ($trendingProperties->count() < 3) {
                $needed = 3 - $trendingProperties->count();
                $extraTrending = $allActiveProperties->whereNotIn('id', $normalProperties->pluck('id'))
                                                   ->whereNotIn('id', $hotDealProperties->pluck('id'))
                                                   ->whereNotIn('id', $trendingProperties->pluck('id'))
                                                   ->filter(function($post) {
                                                       return $post->is_trending || $post->is_trending_calculated;
                                                   })
                                                   ->take($needed);
                $trendingProperties = $trendingProperties->merge($extraTrending)->take(3);
            }

           
            // Sales: 3 hot deals with sale-related offer_type
            $manualHotDealsSales = Post::where('is_hot_deal', true)
                                     ->where('status', 'active')
                                     ->whereRaw('LOWER(offer_type) IN (?, ?, ?, ?)', ['sale', 'sell', 'for sale', 'sale only'])
                                     ->latest()
                                     ->take(3)
                                     ->get();
            
            $autoHotDealsSales = Post::where('status', 'active')
                                   ->whereRaw('LOWER(offer_type) IN (?, ?, ?, ?)', ['sale', 'sell', 'for sale', 'sale only'])
                                   ->get()
                                   ->filter(function($post) {
                                       return $post->is_hot_deal_calculated;
                                   })
                                   ->take(3 - $manualHotDealsSales->count());
            
            $hotDealSales = $manualHotDealsSales->merge($autoHotDealsSales)->take(3);
            
            // Rentals: 3 hot deals with rent-related offer_type
            $manualHotDealsRentals = Post::where('is_hot_deal', true)
                                       ->where('status', 'active')
                                       ->whereRaw('LOWER(offer_type) IN (?, ?, ?, ?, ?)', ['rent', 'rental', 'for rent', 'lease', 'rent only'])
                                       ->latest()
                                       ->take(3)
                                       ->get();
            
            $autoHotDealsRentals = Post::where('status', 'active')
                                     ->whereRaw('LOWER(offer_type) IN (?, ?, ?, ?, ?)', ['rent', 'rental', 'for rent', 'lease', 'rent only'])
                                     ->get()
                                     ->filter(function($post) {
                                         return $post->is_hot_deal_calculated;
                                     })
                                     ->take(3 - $manualHotDealsRentals->count());
            
            $hotDealRentalsFromHot = $manualHotDealsRentals->merge($autoHotDealsRentals)->take(3);
            
            // Fallback - If no hot deal rentals, show any 3 active rental properties
            if ($hotDealRentalsFromHot->count() < 3) {
                $fallbackRentals = Post::where('status', 'active')
                                     ->whereRaw('LOWER(offer_type) IN (?, ?, ?, ?, ?)', ['rent', 'rental', 'for rent', 'lease', 'rent only'])
                                     ->whereNotIn('id', $hotDealRentalsFromHot->pluck('id'))
                                     ->latest()
                                     ->take(3 - $hotDealRentalsFromHot->count())
                                     ->get();
                $hotDealRentals = $hotDealRentalsFromHot->merge($fallbackRentals)->take(3);
            } else {
                $hotDealRentals = $hotDealRentalsFromHot;
            }
            
            // Lands: First try hot deals with property_type = 'land'
            $manualHotDealsLands = Post::where('is_hot_deal', true)
                                     ->where('status', 'active')
                                     ->where('property_type', 'land')
                                     ->latest()
                                     ->take(3)
                                     ->get();
            
            $autoHotDealsLands = Post::where('status', 'active')
                                   ->where('property_type', 'land')
                                   ->get()
                                   ->filter(function($post) {
                                       return $post->is_hot_deal_calculated;
                                   })
                                   ->take(3 - $manualHotDealsLands->count());
            
            $hotDealLandsFromHot = $manualHotDealsLands->merge($autoHotDealsLands)->take(3);
            
            // Fallback - If no hot deal lands, show any 3 active land properties
            if ($hotDealLandsFromHot->count() < 3) {
                $fallbackLands = Post::where('status', 'active')
                                   ->where('property_type', 'land')
                                   ->whereNotIn('id', $hotDealLandsFromHot->pluck('id'))
                                   ->latest()
                                   ->take(3 - $hotDealLandsFromHot->count())
                                   ->get();
                $hotDealLands = $hotDealLandsFromHot->merge($fallbackLands)->take(3);
            } else {
                $hotDealLands = $hotDealLandsFromHot;
            }

            // NEW: Get hero background
            $heroBackground = HeroBackground::getRandomBackground();

            \Log::info('Dashboard Data with Organized Lines:', [
                'new_arrivals_count' => $newArrivals->count(),
                'normal_count' => $normalProperties->count(),
                'hotdeal_count' => $hotDealProperties->count(),
                'trending_count' => $trendingProperties->count(),
                'hotdeal_sales_count' => $hotDealSales->count(),
                'hotdeal_rentals_count' => $hotDealRentals->count(),
                'hotdeal_lands_count' => $hotDealLands->count(),
                'hero_background' => $heroBackground->image_path // Log background
            ]);

            return view('dashboard.index', compact(
                'newArrivals',
                'featuredProperties',
                'normalProperties',      
                'hotDealProperties',     
                'trendingProperties',    
                'hotDealSales',          
                'hotDealRentals',         
                'hotDealLands',
                'heroBackground' // Add this
            ));

        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            
            return view('dashboard.index', [
                'newArrivals' => collect(),
                'featuredProperties' => collect(),
                'normalProperties' => collect(),
                'hotDealProperties' => collect(),
                'trendingProperties' => collect(),
                'hotDealSales' => collect(),
                'hotDealRentals' => collect(),
                'hotDealLands' => collect(),
                'heroBackground' => (object)['image_path' => 'images/home1.jpg'] // Fallback
            ]);
        }
    }
    public function hotDeal()
    {
        try {
            // Get all hot deal properties 
            $manualHotDeals = Post::where('is_hot_deal', true)
                                ->where('status', 'active')
                                ->latest()
                                ->get();
            
            // Auto calculated hot deals
            $autoHotDeals = Post::where('status', 'active')
                              ->get()
                              ->filter(function($post) {
                                  return $post->is_hot_deal_calculated;
                              });
            
            // Combine manual and auto hot deals
            $hotDealProperties = $manualHotDeals->merge($autoHotDeals);

            \Log::info('Hot Deal Page Data:', [
                'manual_hot_deals' => $manualHotDeals->count(),
                'auto_hot_deals' => $autoHotDeals->count(),
                'total_hot_deals' => $hotDealProperties->count()
            ]);

            return view('dashboard.hot-deal', compact('hotDealProperties'));

        } catch (\Exception $e) {
            \Log::error('Hot Deal Page Error: ' . $e->getMessage());
            
            return view('dashboard.hot-deal', [
                'hotDealProperties' => collect()
            ]);
        }
    }

    public function autoHotDeals()
    {
        $allPosts = Post::where('status', 'active')->get();
        
        $hotDealProperties = $allPosts->filter(function($post) {
            return $post->is_hot_deal_calculated;
        });
        
        $page = request()->get('page', 1);
        $perPage = 9;
        $currentPageItems = $hotDealProperties->slice(($page - 1) * $perPage, $perPage)->all();
        
        $hotDealProperties = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $hotDealProperties->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        return view('dashboard.hot-deal', compact('hotDealProperties'));
    }

    public function trending()
    {
        try {
            // Get ALL trending properties 
            $manualTrending = Post::where('is_trending', true)
                                ->where('status', 'active')
                                ->latest()
                                ->get();
            
            // Auto calculated trending - ALL properties
            $autoTrending = Post::where('status', 'active')
                              ->get()
                              ->filter(function($post) {
                                  return $post->is_trending_calculated;
                              });
            
            // Combine ALL trending properties
            $allTrending = $manualTrending->merge($autoTrending);

            \Log::info('Trending Page - Complete Data:', [
                'total_properties' => $allTrending->count(),
                'properties_list' => $allTrending->pluck('id')->toArray()
            ]);

           
            $currentPage = request()->get('page', 1);
            $perPage = 9;
            $currentItems = $allTrending->slice(($currentPage - 1) * $perPage, $perPage)->all();
            
            $trendingProperties = new \Illuminate\Pagination\LengthAwarePaginator(
                $currentItems,
                $allTrending->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            return view('dashboard.trending', compact('trendingProperties'));

        } catch (\Exception $e) {
            \Log::error('Trending Page Error: ' . $e->getMessage());
            
            return view('dashboard.trending', [
                'trendingProperties' => collect()
            ]);
        }
    }
}