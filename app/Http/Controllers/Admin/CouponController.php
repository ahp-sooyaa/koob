<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CouponController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Coupons/Index', [
            'coupons' => Coupon::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Coupons/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required'],
            'program_name' => ['required'],
            'type' => ['required'],
            'value' => ['required'],
            'quantity' => ['required'],
            'expired_at' => ['required'],
        ]);
        Coupon::create($validated);

        return back()->with('message', 'Successfully created coupon');
    }

    public function edit(Coupon $coupon)
    {
        return Inertia::render('Admin/Coupons/Edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => ['required'],
            'program_name' => ['required'],
            'type' => ['required'],
            'value' => ['required'],
            'expired_at' => ['required'],
        ]);

        $coupon->update($validated);

        return Redirect::route('admin.coupons.index')->with('success', 'Coupon updated successfully.');
    }
}
