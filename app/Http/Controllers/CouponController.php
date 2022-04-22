<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function checkCouponValid()
    {
        $coupon = Coupon::where('code', request('couponCode'))->firstOrFail();

        if ($coupon->expired_at >= Carbon::now() && ! $coupon->users()->where('user_id', auth()->id())->exists()) {
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
