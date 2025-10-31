<?php
// database/seeders/HeroBackgroundSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HeroBackgroundSeeder extends Seeder
{
    public function run()
    {
        DB::table('hero_backgrounds')->insert([
            [
                'image_path' => 'images/home1.jpg',
                'title' => 'Modern House',
                'is_active' => true,
                'display_order' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'image_path' => 'images/home2.jpg',
                'title' => 'Luxury Villa', 
                'is_active' => true,
                'display_order' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'image_path' => 'images/home3.jpg',
                'title' => 'City Apartment',
                'is_active' => true,
                'display_order' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'image_path' => 'images/home4.jpg',
                'title' => 'Beach House',
                'is_active' => true,
                'display_order' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'image_path' => 'images/home5.jpg',
                'title' => 'Mountain View',
                'is_active' => true,
                'display_order' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}