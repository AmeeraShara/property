<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    public function run()
    {
        Property::create([
            'title' => 'Luxury Villa in Nawala',
            'description' => 'A beautiful villa with modern amenities and large garden.',
            'type' => 'house',
            'category' => 'sale', // sale / rental / land
            'price' => 15000000,
            'price_unit' => 'LKR',
            'size' => '4000 sqft',
            'location' => 'Nawala',
            'district' => 'Colombo',
            'city' => 'Colombo',
            'bedrooms' => 4,
            'bathrooms' => 3,
            'is_featured' => true,
            'is_hot_deal' => true,
            'is_trending' => false,
            'is_urgent' => false,
            'status' => 'active',
            'images' => json_encode(['default.jpg']),
            'amenities' => 'Pool,Gym,Garage',
            'user_id' => 1
        ]);

        Property::create([
            'title' => 'Modern Apartment in Kandy',
            'description' => 'A cozy apartment near city center.',
            'type' => 'apartment',
            'category' => 'rental',
            'price' => 50000,
            'price_unit' => 'LKR/month',
            'size' => '1200 sqft',
            'location' => 'City Center',
            'district' => 'Kandy',
            'city' => 'Kandy',
            'bedrooms' => 2,
            'bathrooms' => 2,
            'is_featured' => false,
            'is_hot_deal' => true,
            'is_trending' => true,
            'is_urgent' => false,
            'status' => 'active',
            'images' => json_encode(['default.jpg']),
            'amenities' => 'Parking,Elevator',
            'user_id' => 1
        ]);

        Property::create([
            'title' => 'Land Plot in Gampaha',
            'description' => 'Perfect location for building your dream home.',
            'type' => 'land',
            'category' => 'sale',
            'price' => 3000000,
            'price_unit' => 'LKR',
            'size' => '2000 sqft',
            'location' => 'Gampaha',
            'district' => 'Gampaha',
            'city' => 'Gampaha',
            'bedrooms' => 0,
            'bathrooms' => 0,
            'is_featured' => false,
            'is_hot_deal' => false,
            'is_trending' => true,
            'is_urgent' => true,
            'status' => 'active',
            'images' => json_encode(['default.jpg']),
            'amenities' => '',
            'user_id' => 1
        ]);
    }
}
