<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Get the current cart items
        $cartItems = Cart::getContent();

        // Calculate the total amount
        $totalAmount = Cart::getTotal();

        // Create a new order
        $order = Order::create([
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'name'=>$request->name,
            'email'=>$request->email
        ]);

        // Loop through the cart items and create order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'attributes' => $item->attributes->toArray(), // Convert attributes to array
                'front_image' => $item->front_image,
                'front_design' => $item->front_design,
            ]);
        }

        // Clear the cart after order creation
        Cart::clear();

        // Return response or redirect
        return redirect()->route('orders.success')->with('success', 'Order placed successfully!');
    }
}
