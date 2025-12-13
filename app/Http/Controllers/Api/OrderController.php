<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return $this->success(Order::with('user', 'product')->get(), 'Barcha buyurtmalar');
    }

    public function show($id)
    {
        $order = Order::with('user', 'product')->find($id);
        return $order ? $this->success($order) : $this->error('Buyurtma topilmadi', 404);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric'
        ]);

        $order = Order::create($data);
        return $this->success($order, 'Buyurtma yaratildi', 201);
    }
}
