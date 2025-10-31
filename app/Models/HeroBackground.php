<?php
// app/Models/HeroBackground.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroBackground extends Model
{
    use HasFactory;

   protected $fillable = ['image_path', 'title', 'is_active', 'display_order'];
    
    

    // Get random active background
   // app/Models/HeroBackground.php
public static function getRandomBackground()
{
    try {
        $activeBackgrounds = static::where('is_active', true)
                    ->orderBy('display_order')
                    ->get();
        
        if ($activeBackgrounds->isEmpty()) {
            \Log::warning('No active hero backgrounds found in database');
            // Fallback to default image path - make sure this image exists!
            return (object)[
                'image_path' => 'images/home1.jpg',
                'title' => 'Default Background'
            ];
        }

        $randomBg = $activeBackgrounds->random();
        \Log::info('Selected background:', [
            'path' => $randomBg->image_path,
            'title' => $randomBg->title
        ]);
        
        return $randomBg;

    } catch (\Exception $e) {
        \Log::error('Error getting hero background: ' . $e->getMessage());
        return (object)[
            'image_path' => 'images/home1.jpg',
            'title' => 'Fallback Background'
        ];
    }
}
}