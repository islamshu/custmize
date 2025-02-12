<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        return view('dashboard.customers.index')->with('clients',Client::orderby('id','desc')->get());
    }
    public function create(){
        return view('dashboard.customers.create')->with('clients',Client::orderby('id','desc')->get());
    }
    public function order_client($id){
        $client = Client::find($id);
        $orders = Order::with('details')->where('client_id', $id)->where('shipping',0)->orderby('id','desc')->get();

        $title = __('All Order for ').$client->name;
        return view('dashboard.orders.index', compact('orders', 'title'));
    }
    public function store(Request $request){
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'Email' => 'required|email|unique:clients,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'DOB'=>'required',
            'Phone'=>'required|unique:clients,phone'
        ]);
        // dd($request->all());
        $client = new Client();
        $client->name = $request->first_name;

        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->email = $request->Email;
        $client->phone = $request->Phone;
        $client->password = bcrypt($request->password); // تشفير كلمة المرور
        $client->save();
        return redirect()->route('customers.index')->with(['success'=>__('Added Successfuly')]);

    }
    public function edit($id){
        return view('dashboard.customers.edit')->with('client',Client::find($id));
    }
    public function update(Request $request,$id){
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'Email' => 'required|email|unique:clients,email,'.$id,
           
            'DOB'=>'required',
            'Phone'=>'required|unique:clients,phone,'.$id
        ]);
        if($request->password  != null){
            $request->validate([
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);
        }
        // dd($request->all());
        $client = Client::find($id);
        $client->name = $request->first_name;
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->email = $request->Email;
        $client->phone = $request->Phone;
        $client->DOB = $request->DOB;

        if($request->password){
            $client->password = bcrypt($request->password); // تشفير كلمة المرور
        }
        $client->save();
        return redirect()->route('customers.index')->with(['success'=>__('Added Successfuly')]);
    }
    public function destroy($id){
        $calient = Client::find($id);
        $calient->delete();
        return redirect()->route('customers.index')->with(['success'=>__('Deleted Successfuly')]);

    }
}
