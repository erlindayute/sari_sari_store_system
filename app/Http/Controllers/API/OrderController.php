<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'total' => 0, // Will be updated later
        ]);

        $total = 0;
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);

            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);

            // deduct stock
            $product->stock -= $item['quantity'];
            $product->save();
        }

        $order->update(['total' => $total]);

        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }
}
