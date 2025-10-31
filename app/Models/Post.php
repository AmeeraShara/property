<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'offer_type',
        'property_type',
        'property_subtype',
        'district',
        'city',
        'street',
        'ad_title',
        'ad_description',
        'price',
        'price_type',
        'bedrooms',
        'bathrooms',
        'land_area',
        'floor_area',
        'num_floors',
        'features',
        'contact_name',
        'contact_email',
        'contact_phone',
        'whatsapp_phone',
        'images',
        'video_path',
        'commercial_type',
        'floor_level',
        'land_unit',
        'status',
        'size',
        'location',
        'is_featured',
        'is_hot_deal',
        'is_trending',
        'is_urgent',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'land_area' => 'decimal:2', 
        'floor_area' => 'decimal:2',
        'features' => 'array',
        'images' => 'array',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer', 
        'num_floors' => 'integer',
        'is_featured' => 'boolean',
        'is_hot_deal' => 'boolean',
        'is_trending' => 'boolean',
        'is_urgent' => 'boolean',
        'size' => 'decimal:2',
    ];

    /**
     * Relationship with user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * AUTO CALCULATION Hotdeal
     */
   public function getIsHotDealCalculatedAttribute()
{
    $score = 0;

    // Recency (max 40 points)
    if ($this->created_at->gt(now()->subDays(1))) $score += 10;
    elseif ($this->created_at->gt(now()->subDays(3))) $score += 20;
    elseif ($this->created_at->gt(now()->subDays(5))) $score += 30;
    
    // Images (max 30 points)
    $imageCount = count($this->images_array ?? []);
    if ($imageCount >= 5) $score += 30;
    elseif ($imageCount >= 3) $score += 25;
    elseif ($imageCount >= 2) $score += 20;
    elseif ($imageCount >= 1) $score += 10;
    
    // Price (max 30 points)
    if ($this->isBelowMarketPrice()) $score += 30;
    
    return $score >= 70; // Minimum 70 points needed
}



    /**
     * AUTO CALCULATION Trending
     */
 public function getIsTrendingCalculatedAttribute()
    {
        // Trending conditions:
        // 1. Post is less than 7 days old
        // 2. Has good engagement (views/inquiries)
        // 3. Multiple images
        
        $isRecent = $this->created_at->gt(Carbon::now()->subDays(7));
        $hasMultipleImages = $this->has_images && count($this->images_array) >= 2;
        
        return $isRecent && $hasMultipleImages;
    }

   

/**
 * isPopularDistrict
 */
private function isPopularDistrict()
{
    $popularDistricts = [
        'Colombo', 'Colombo 1', 'Colombo 2', 'Colombo 3', 'Colombo 4', 'Colombo 5',
        'Colombo 6', 'Colombo 7', 'Colombo 8', 'Colombo 9', 'Colombo 10', 'Colombo 11', 
        'Colombo 12', 'Colombo 13', 'Colombo 14', 'Colombo 15',
        'Kandy', 'Galle', 'Negombo', 'Mount Lavinia', 'Dehiwala', 'Moratuwa',
        'Ratmalana', 'Battaramulla', 'Rajagiriya', 'Nugegoda', 'Maharagama', 'Piliyandala'
    ];
    
    $location = $this->location ?? '';
    
    foreach ($popularDistricts as $district) {
        if (stripos($location, $district) !== false) {
            return true;
        }
    }
    
    return false;
}

/**
 *  hasEnoughFeatures
 */
private function hasEnoughFeatures()
{
    $featureCount = 0;
    
    $featuresToCheck = [
        'has_pool', 'has_garden', 'has_garage', 'has_security', 
        'has_ac', 'has_furniture', 'has_parking', 'has_elevator',
        'has_balcony', 'has_sea_view', 'has_mountain_view',
        'has_modern_kitchen', 'has_storage', 'has_laundry'
    ];
    
    foreach ($featuresToCheck as $feature) {
        if (!empty($this->$feature)) {
            $featureCount++;
        }
    }
    
    // If features are stored in an array
    if (!empty($this->features) && is_array($this->features)) {
        $featureCount += count($this->features);
    }
    
    return $featureCount >= 3;
}
   private function isBelowMarketPrice()
{
    if (!$this->price || !$this->property_type) {
        return false;
    }
    
    // Adjust price thresholds
    $priceThresholds = [
        'house' => 400000000,        // 50M → 40M (more strict)
        'apartment' => 20000000,    // 25M → 20M
        'land' => 8000000,          // 10M → 8M  
        'commercial' => 60000000,   // 75M → 60M
    ];
    
    // OR - Increase thresholds (more relaxed)
    // $priceThresholds = [
    //     'house' => 60000000,        // 50M → 60M
    //     'apartment' => 30000000,    // 25M → 30M
    //     'land' => 15000000,         // 10M → 15M
    //     'commercial' => 90000000,   // 75M → 90M
    // ];
    
    $threshold = $priceThresholds[$this->property_type] ?? 50000000;
    
    return $this->price <= $threshold;
}

    /**
     * AUTO CALCULATION - Get dynamic post status
     */
    public function getDynamicStatusAttribute()
    {
        if ($this->is_hot_deal_calculated) {
            return 'hot_deal';
        }
        
        if ($this->is_trending_calculated) {
            return 'trending';
        }
        
        return 'normal';
    }

    /**
     * Get first image URL
     */
    public function getFirstImageAttribute()
    {
        try {
            $images = $this->images;
            
            if (empty($images) || !is_array($images)) {
                return null;
            }

            $firstImagePath = $images[0];
            
            if (empty($firstImagePath)) {
                return null;
            }

            return Storage::disk('public')->url($firstImagePath);

        } catch (\Exception $e) {
            \Log::error("Post {$this->id}: ERROR in getFirstImageAttribute: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get images array
     */
    public function getImagesArrayAttribute()
    {
        $images = $this->images;
        
        if (empty($images) || !is_array($images)) {
            return [];
        }
        
        return array_filter($images);
    }

    /**
     * Check if post has images
     */
    public function getHasImagesAttribute()
    {
        $images = $this->images;
        return !empty($images) && is_array($images) && count($images) > 0;
    }

    /**
     * Set mutator for images
     */
    public function setImagesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['images'] = json_encode($value);
        } elseif (is_string($value)) {
            json_decode($value);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->attributes['images'] = json_encode([$value]);
            } else {
                $this->attributes['images'] = $value;
            }
        } else {
            $this->attributes['images'] = null;
        }
    }

    /**
     * Set mutator for features
     */
    public function setFeaturesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['features'] = json_encode(array_filter($value));
        } elseif (is_string($value)) {
            if (strpos($value, ',') !== false) {
                $array = array_map('trim', explode(',', $value));
                $this->attributes['features'] = json_encode(array_filter($array));
            } else {
                $this->attributes['features'] = json_encode([$value]);
            }
        } else {
            $this->attributes['features'] = null;
        }
    }

    /**
     * Get features as array
     */
    public function getFeaturesArrayAttribute()
    {
        $features = $this->features;
        
        if (empty($features)) {
            return [];
        }
        
        if (is_array($features)) {
            return array_filter($features);
        }
        
        if (is_string($features)) {
            $decoded = json_decode($features, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return array_filter($decoded);
            }
            
            if (strpos($features, ',') !== false) {
                return array_filter(array_map('trim', explode(',', $features)));
            }
            
            return [$features];
        }
        
        return [];
    }

    /**
     * Check if property has features
     */
    public function getHasFeaturesAttribute()
    {
        return !empty($this->features_array);
    }

    /**
     * Accessor for formatted price
     */
    public function getFormattedPriceAttribute()
    {
        if ($this->price === null) {
            return 'Price on Request';
        }
        return 'Rs. ' . number_format($this->price, 2);
    }

    /**
     * Accessor for formatted land area
     */
    public function getFormattedLandAreaAttribute()
    {
        if ($this->land_area === null) {
            return 'N/A';
        }
        return number_format($this->land_area, 2) . ' ' . ($this->land_unit ?? 'Perches');
    }

    /**
     * Accessor for formatted floor area
     */
    public function getFormattedFloorAreaAttribute()
    {
        if ($this->floor_area === null) {
            return 'N/A';
        }
        return number_format($this->floor_area, 2) . ' sq ft';
    }

    /**
     * Scope active posts
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope featured posts
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope hot deals (using database columns)
     */
    public function scopeHotDeal($query)
    {
        return $query->where('is_hot_deal', true);
    }

    /**
     * Scope trending posts (using database columns)
     */
    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    /**
     * Scope for sale
     */
    public function scopeForSale($query)
    {
        return $query->where('offer_type', 'sale');
    }
    public function getIsFavoritedAttribute()
    {
        if (!auth()->check()) {
            return false;
        }
        
        return auth()->user()->hasFavorited($this->id);
}
}