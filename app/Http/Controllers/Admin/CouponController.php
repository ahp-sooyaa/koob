<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
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
        $request->validate([
            'code' => ['required'],
            'program_name' => ['required'],
            'type' => ['required'],
            'value' => ['required'],
            'expired_at' => ['required'],
        ]);
        Coupon::create($request->only('code', 'program_name', 'type', 'value', 'quantity', 'expired_at'));

        return back()->with('message', 'Successfully created coupon');
    }
}
