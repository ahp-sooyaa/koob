<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index()
    {
        return auth()->user()->coupons->filter(function ($coupon) {
            return ! $coupon->pivot->isApplied && $coupon->expired_at >= Carbon::now();
        });
    }

    public function checkCouponValid()
    {
        $coupon = Coupon::where('code', request('couponCode'))->firstOrFail();

        if ($coupon->users()->where('user_id', auth()->id())->exists()) {
            $isApplied = $coupon->users()->where('user_id', auth()->id())->first()->pivot->isApplied;
        } else {
            $coupon->users()->attach(auth()->id(), ['isApplied' => false]);
            $isApplied = false;
        }

        if ($coupon->expired_at >= Carbon::now() && ! $isApplied) {
            session()->put('coupon', $coupon);
        } else {
            return response()->json(['message' => 'Sorry you can\'t use this coupon anymore'], 422);
        }

        return response()->json(['coupon' => $coupon]);
    }

    public function removeCoupon()
    {
        session()->pull('coupon');
    }
}
