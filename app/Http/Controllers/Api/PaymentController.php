<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|integer',
            'method' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        // To‘lov tizimi logikasini bu yerga yozasiz (Payme, Click, PayPal va h.k.)
        return $this->success($data, 'To‘lov muvaffaqiyatli amalga oshirildi');
    }
}
