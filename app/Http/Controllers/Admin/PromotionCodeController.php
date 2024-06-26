<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromotionCodeController extends Controller
{
    public function create()
    {
        $data = [
            'pageTitle' => trans('admin/pages/financial.new_promotion')
        ];
        return view('admin.promotion_code.new', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'discount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');

        $data = [];
        for ($i = 0; $i < $quantity; $i++) {
            array_push($data, [
                'code' => Str::random(10),
                'discount' => $request->input('discount'),
                'expires_at' => $request->input('expires_at'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
        PromotionCode::insert($data);

        return redirect()->route('promotion_code.lists')
            ->with('success', 'Promotion code created successfully.');
    }

    public function index()
    {
        $promotions  = PromotionCode::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.promotion_code.lists', compact('promotions'));
    }

    public function delete($id)
    {
        $this->authorize('admin_promotion_delete');

        $promotion = PromotionCode::findOrFail($id);

        $promotion->delete();

        return redirect(route('promotion_code.lists'));
    }
}
