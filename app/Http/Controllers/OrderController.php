<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch all orders with their details
        $orders = Order::with('details')->where('shipping',0)->orderby('id','desc')->get();
        $title = __('Orders');
        return view('dashboard.orders.index', compact('orders', 'title'));
    }
    public function guest_orders()
    {
        // Fetch all orders with their details
        $orders = Order::with('details')->where('client_id', null)->where('shipping',0)->orderby('id','desc')->get();

        $title = __('Guest Orders');
        return view('dashboard.orders.index', compact('orders', 'title'));
    }
    public function clinet_orders()
    {
        // Fetch all orders with their details
        $orders = Order::with('details')->where('client_id', '!=', null)->where('shipping',0)->orderby('id','desc')->get();

        $title = __('Clinet Orders');
        return view('dashboard.orders.index', compact('orders', 'title'));
    }




    public function index_shipping()
    {
        // Fetch all orders with their details
        $orders = Order::with('details')->where('shipping',1)->get();
        $title = __('Orders');
        return view('dashboard.orders.index', compact('orders', 'title'));
    }
    public function guest_orders_shipping()
    {
        // Fetch all orders with their details
        $orders = Order::with('details')->where('client_id', null)->where('shipping',1)->orderby('id','desc')->get();

        $title = __('Guest Orders');
        return view('dashboard.orders.index', compact('orders', 'title'));
    }
    public function clinet_orders_shipping()
    {
        // Fetch all orders with their details
        $orders = Order::with('details')->where('client_id', '!=', null)->where('shipping',1)->orderby('id','desc')->get();

        $title = __('Clinet Orders');
        return view('dashboard.orders.index', compact('orders', 'title'));
    }



    
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        $order->status_id = $validated['status_id'];
        $order->save();

        return response()->json(['success' => true]);
    }

    



    public function show(Order $order)
    {
        // Load order details for a specific order
        $order->load('details');

        return view('dashboard.orders.show', compact('order'));
    }
    public function destroy($id)
    {
        // Load order details for a specific order
        $orders = Order::find($id)->delete();
        return redirect()->route('orders.index')->with(['success' => __('Deleted Successfuly')]);
    }
}
