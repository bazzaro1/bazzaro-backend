<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSellerRequest;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function register(StoreSellerRequest $request): JsonResponse
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // 1) Foydalanuvchi rolini seller ga o‘zgartirish
            $user = User::findOrFail($data['user_id']);
            $user->role = 'seller';
            $user->save();

            // 2) Seller ma'lumotini yaratish
            $seller = Seller::create([
                'user_id'        => $user->id,
                'business_type'  => $data['business_type'],
                'company_name'   => $data['company_name'],
                'tin'            => $data['tin'],
                'license_number' => $data['license_number'] ?? null,
                'store_name'     => $data['store_name'],
                'phone'          => $data['phone'],
                'address'        => $data['address'],
                'status'         => 'pending',
                'balance'        => 0,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Sotuvchi ro‘yxatdan o‘tdi. Tasdiqlash kutmoqda.',
                'seller'  => $seller
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Xatolik yuz berdi.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
