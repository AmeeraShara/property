<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WantedAd;

class WantedController extends Controller
{
     //index
    public function index()
    {
        $wantedAds = WantedAd::paginate(6);
        return view('wanted.index', compact('wantedAds'));
    }


    // store
    public function store(Request $request)
    {
      $validated = $request->validate([
    'title' => 'required|string|max:255',
    'offer_type' => 'required|string',
    'property_type' => 'required|string',
    'district' => 'required|string',
    'city' => 'required|string',
    'bedrooms' => 'nullable|integer|min:0',
    'bathrooms' => 'nullable|integer|min:0',
    'budget_min' => 'nullable|numeric|min:0',
    'budget_max' => 'nullable|numeric|min:0',
    'floor_area_min' => 'nullable|numeric|min:0',
    'floor_area_max' => 'nullable|numeric|min:0',
    'requirements' => 'required|string',
    'contact_name' => 'required|string|max:255',
    'contact_phone' => 'required|string|max:20',
    'contact_email' => 'nullable|email|max:255',
]);

        WantedAd::create($validated);

        return redirect()->route('wanted.index')->with('success', 'Your wanted ad has been posted successfully!');
    }

    public function loadMore(Request $request)
    {
        $page = $request->input('page', 1);
        $wantedAds = WantedAd::paginate(9, ['*'], 'page', $page);
        return response()->json($wantedAds);
    }
}
