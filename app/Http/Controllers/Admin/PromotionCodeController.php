<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionCode;

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
        ]);

        $promotionCode = new PromotionCode();
        $promotionCode->code = Str::random(10);
        $promotionCode->discount = $request->input('discount');
        $promotionCode->expires_at = $request->input('expires_at');
        $promotionCode->save();

        return redirect()->route('promotion_code.lists')
            ->with('success', 'Promotion code created successfully.');
    }

    public function index()
    {
        $promotions  = PromotionCode::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.promotion_code.lists', compact('promotions'));
    }
}
