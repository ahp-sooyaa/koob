<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        return auth()->user()->coupons->filter(function ($coupon) {
            return ! $coupon->pivot->isApplied && $coupon->expired_at >= Carbon::now();
        });
    }

    public function store(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json(['message' => 'This code is not from us.'], 404);
        }

        if ($coupon->expired_at < Carbon::now() || $coupon->isApplied()) {
            return response()->json(['message' => "You can't use this coupon anymore"], 422);
        }

        session()->put('coupon', $coupon);

        return response()->json(['message' => 'Successfully applied coupon.', 'coupon' => $coupon]);
    }

    public function destroy()
    {
        session()->pull('coupon');
    }
}
