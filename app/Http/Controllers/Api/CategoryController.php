<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return $this->success(Category::all(), 'Barcha kategoriyalar');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create($data);
        return $this->success($category, 'Kategoriya qo‘shildi', 201);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) return $this->error('Kategoriya topilmadi', 404);

        $category->delete();
        return $this->success([], 'Kategoriya o‘chirildi');
    }
}
