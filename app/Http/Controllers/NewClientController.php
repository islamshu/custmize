<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class NewClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.clients.index')->with('clients',Client::orderby('id','desc')->get());
    }
    public function order_client($id){
        $client = Client::find($id);
        $orders = Order::with('details')->where('client_id', $id)->where('shipping',0)->orderby('id','desc')->get();

        $title = __('All Order for ').$client->name;
        return view('dashboard.orders.index', compact('orders', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.clients.create')->with('clients',Client::orderby('id','desc')->get());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'dob' => 'nullable|date',
        'gender' => 'nullable|string',
        'email' => 'required|email|unique:clients,email',
        'phone' => 'required|string|max:20',
        'state' => 'nullable|string|max:255',
        'country' => 'nullable|string|max:255',
        'password' => 'required|string|min:6|confirmed',
        'confirm_password'=>'required|same:password'
    ]);

    Client::create([
        'name'=>$request->first_name,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'dob' => $request->DOB, 
        'gender' => $request->gender,
        'email' => $request->email,
        'phone' => $request->phone,
        'state' => $request->state,
        'country' => $request->country,
        'password' =>bcrypt($request->password),
    ]);

    return response()->json(['message' => 'Client created successfully!']);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
