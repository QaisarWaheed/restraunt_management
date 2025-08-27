<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    

 public function index(Request $request)
 {
     $products = Product::all();
     return view ('products.index', compact('products'));
 }


public function checkout()
{
    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

    $products = Product::all();
    $total_price = 0;
    $line_items = [];

    foreach ($products as $product) {
        $total_price += $product->price;
        $line_items[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $product->name,
                ],
                'unit_amount' => $product->price * 100,  
            ],
            'quantity' => 1,
        ];
    }

    $checkout_session = $stripe->checkout->sessions->create([
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => route('checkout.success', [], true),
        'cancel_url' => route('checkout.cancel', [], true),
    ]);

    $order = new Order();
    $order->status = 'unpaid';
    $order->total_price = $total_price;
    $order->stripe_session_id = $checkout_session->id;
    $order->save();

    return redirect($checkout_session->url);
}



public function success(){
}
public function cancel(){
}
}
