<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PremiumPackage;

class PremiumPackageController extends Controller
{
    public function index()
    {
        $packages = PremiumPackage::all();
        return view('superadmin.premium.index', compact('packages'));
    }

    public function create()
    {
        return view('superadmin.premium.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        PremiumPackage::create($request->all());

        return redirect()->route('superadmin.premium.index')->with('success', 'Package created successfully.');
    }

    public function edit(PremiumPackage $premium)
    {
        return view('superadmin.premium.edit', compact('premium'));
    }

    public function update(Request $request, PremiumPackage $premium)
    {
        $request->validate([
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $premium->update($request->all());

        return redirect()->route('superadmin.premium.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(PremiumPackage $premium)
    {
        $premium->delete();
        return redirect()->route('superadmin.premium.index')->with('success', 'Package deleted successfully.');
    }
}
