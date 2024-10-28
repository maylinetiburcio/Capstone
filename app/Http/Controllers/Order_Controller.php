<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order_model;
;

class Order_Controller extends Controller
{
    public function index()
    {
        $orders = Order_model::all();
        return response()->json($orders);
    }

   

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_street' => 'required|string|max:255',
            'customer_city' => 'required|string|max:255',
            'customer_zip_code' => 'required|string|max:10',
            'customer_phone' => 'required|string|max:15',
            'items' => 'required|array',
            'total_price' => 'required|numeric'
        ]);

        $order = Order_model::create($validatedData);
        
        return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
    }
}
