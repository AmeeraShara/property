<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class DestricController extends Controller {

    public function index(Request $request)
    {
        $district = $request->get('district', '');
        $offerType = $request->get('offer_type', 'all');
        
      
        $query = Post::active();
        
    
        if (!empty($district)) {
            $query->where('district', 'like', '%' . $district . '%');
        }
        
       
        if ($offerType !== 'all') {
            switch ($offerType) {
                case 'sale':
                    // For sale
                    $query->where('offer_type', 'sale');
                    break;
                case 'rent':
                    // For rent
                    $query->where('offer_type', 'rent');
                    break;
                case 'land':
                    // For land
                    $query->where('property_type', 'land');
                    break;
            }
        }
        
        $properties = $query->latest()->paginate(12);
        
     
        $counts = [
            'all' => Post::active()->when($district, function($q) use ($district) {
                return $q->where('district', 'like', '%' . $district . '%');
            })->count(),
            'sale' => Post::active()
                ->where('offer_type', 'sale')
                ->when($district, function($q) use ($district) {
                    return $q->where('district', 'like', '%' . $district . '%');
                })->count(),
            'rent' => Post::active()
                ->where('offer_type', 'rent')
                ->when($district, function($q) use ($district) {
                    return $q->where('district', 'like', '%' . $district . '%');
                })->count(),
            'land' => Post::active()
                ->where('property_type', 'land')
                ->when($district, function($q) use ($district) {
                    return $q->where('district', 'like', '%' . $district . '%');
                })->count(),
        ];

        
        $popularDistricts = [
            'Colombo' => Post::active()->where('district', 'like', '%Colombo%')->count(),
            'Kandy' => Post::active()->where('district', 'like', '%Kandy%')->count(),
            'Gampaha' => Post::active()->where('district', 'like', '%Gampaha%')->count(),
            'Galle' => Post::active()->where('district', 'like', '%Galle%')->count(),
            'Matara' => Post::active()->where('district', 'like', '%Matara%')->count(),
            'Kurunegala' => Post::active()->where('district', 'like', '%Kurunegala%')->count(),
        ];
        
        return view('destric.index', compact(
            'properties', 
            'district', 
            'offerType', 
            'counts',
            'popularDistricts'
        ));
    }
}