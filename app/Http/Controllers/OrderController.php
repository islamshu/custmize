<?php
namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch all orders with their details
        $orders = Order::with('details')->get();

        return view('dashboard.orders.index', compact('orders'));
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
       return redirect()->route('orders.index')->with(['success'=>__('Deleted Successfuly')]);
    }
}
