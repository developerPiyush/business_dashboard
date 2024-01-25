<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = Business::latest()->get();
        return view('business.index', compact('businesses'));
    }

    public function create()
    {
        return view('business.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:businesses',
            'phone_number' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        Business::create($validatedData);

        return redirect()->route('business.index')->with('success', 'Business created successfully!');
    }



    public function update(Request $request, Business $business)
    {
        // Similar validation logic as in store method

        $business->update($request->all());

        return redirect()->route('business.index')->with('success', 'Business updated successfully!');
    }

    public function destroy(Business $business)
    {
        $business->delete();

        return redirect()->route('business.index')->with('success', 'Business deleted successfully!');
    }

}
