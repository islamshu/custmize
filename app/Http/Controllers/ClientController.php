<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('front.profile_client');
    }

    public function wishlist()
    {
        $products = Product::has('favorites')->with(['favorites' => function ($query) {
            $query->where('client_id', auth()->guard('client')->id());
        }])->paginate(6);    
          return view('front.wishlist')->with('products',$products);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function updateProfile(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|in:1,2',
        ]);
    
        // Update the authenticated client's profile
        $client = auth('client')->user();
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->phone = $request->phone;
        $client->DOB = $request->birthdate;
        $client->gender = $request->gender;
        $client->save();
    
        // Return success response
        return response()->json(['success' => true, 'message' => 'Profile updated successfully']);
    }
    
}
