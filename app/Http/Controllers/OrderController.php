<?php
namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch all orders with their details
        $orders = Order::with('details')->get();
        $title = __('Orders');
        return view('dashboard.orders.index', compact('orders','title'));
    }
    public function guest_orders()
    {
        // Fetch all orders with their details
        $orders = Order::with('details')->where('client_id',null)->get();

        $title = __('Guest Orders');
        return view('dashboard.orders.index', compact('orders','title'));  
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

    public function clinet_orders()
    {
        // Fetch all orders with their details
        $orders = Order::with('details')->where('client_id','!=',null)->get();

        $title = __('Clinet Orders');
        return view('dashboard.orders.index', compact('orders','title'));    }

    

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
