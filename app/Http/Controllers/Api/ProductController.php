<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return $this->success(Product::all(), 'Barcha mahsulotlar ro‘yxati');
    }

    public function show($id)
    {
        $product = Product::find($id);
        return $product ? $this->success($product) : $this->error('Mahsulot topilmadi', 404);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product = Product::create($data);
        return $this->success($product, 'Mahsulot muvaffaqiyatli qo‘shildi', 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) return $this->error('Mahsulot topilmadi', 404);

        $product->update($request->all());
        return $this->success($product, 'Mahsulot yangilandi');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) return $this->error('Mahsulot topilmadi', 404);

        $product->delete();
        return $this->success([], 'Mahsulot o‘chirildi');
    }
}
