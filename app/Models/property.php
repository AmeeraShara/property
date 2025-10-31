<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description', 
        'type',
        'category',
        'price',
        'price_unit',
        'size',
        'location',
        'district',
        'city',
        'bedrooms',
        'bathrooms',
        'is_featured',
        'is_hot_deal',
        'is_trending',
        'is_urgent',
        'status',
        'images',
        'amenities',
        'user_id'
    ];

    protected $casts = [
        'images' => 'array',
        'amenities' => 'array',
        'is_featured' => 'boolean',
        'is_hot_deal' => 'boolean',
        'is_trending' => 'boolean',
        'is_urgent' => 'boolean',
        'price' => 'decimal:2'
    ];

    // Accessor for first image with type-based fallback
    public function getFirstImageAttribute()
    {
        $images = $this->images ?? [];
        if (!empty($images) && is_array($images)) {
            return $images[0];
        }
        
        return $this->getDefaultImageByType();
    }


    // Get default image based on property type - PUBLIC method
    public function getDefaultImageByType()
    {
        $type = strtolower($this->type ?? '');
        
        if (str_contains($type, 'apartment') || str_contains($type, 'condo')) {
            return 'apartment.jpg';
        } elseif (str_contains($type, 'house') || str_contains($type, 'home')) {
            return 'property2.jpg';
        } elseif (str_contains($type, 'land') || str_contains($type, 'plot')) {
            return 'property3.jpg';
        } elseif (str_contains($type, 'commercial')) {
            return 'property4.jpg';
        } else {
            return 'property1.jpg';
        }
    }


    // Get default image path for blade templates
    public function getDefaultImagePathAttribute()
    {
        return asset('images/' . $this->getDefaultImageByType());
    }


    // Accessor for all images
    public function getAllImagesAttribute()
    {
        $images = $this->images ?? [];
        if (!empty($images) && is_array($images)) {
            return $images;
        }
        return [$this->getDefaultImageByType()];
    }


    // Get image URL for display
    public function getDisplayImageAttribute()
    {
        if ($this->first_image) {
            return asset('storage/' . $this->first_image);
        }
        return $this->default_image_path;
    }


    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('status', 'active');
    }


    public function scopeHotDeals($query)
    {
        return $query->where('is_hot_deal', true)->where('status', 'active');
    }


    public function scopeTrending($query)
    {
        return $query->where('is_trending', true)->where('status', 'active');
    }

    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}