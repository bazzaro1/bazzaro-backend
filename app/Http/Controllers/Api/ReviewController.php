<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return $this->success(Review::with('user', 'product')->get(), 'Barcha fikr va baholar');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $review = Review::create($data);
        return $this->success($review, 'Fikr muvaffaqiyatli qo‘shildi', 201);
    }
}
