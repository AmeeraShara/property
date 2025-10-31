<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class DashboardController extends Controller
{
    public function index()
    {
        
        $featuredProperties = Property::featured()->latest()->take(4)->get();
        $showcaseProperties = Property::active()->latest()->take(9)->get();
        $hotDealProperties = Property::hotDeals()->latest()->take(9)->get();
        $trendingProperties = Property::trending()->latest()->take(3)->get();

        return view('dashboard.index', compact(
            'featuredProperties',
            'showcaseProperties', 
            'hotDealProperties',
            'trendingProperties'
        ));
    }
}