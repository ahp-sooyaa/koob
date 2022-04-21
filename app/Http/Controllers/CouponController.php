<?php

namespace App\Http\Controllers;

use App\Models\Coupon;

class CouponController extends Controller
{
    public function checkCouponValid()
    {
        $coupon = Coupon::where('code', request('couponCode'))->firstOrFail();

        // if (empty($coupon)) {
        //     return response()->json(['message' => 'not valid coupon'], 404);
        // }
        session()->put('coupon', $coupon);
        return response()->json(['coupon' => $coupon]);
    }

    public function removeCoupon()
    {
        session()->pull('coupon');
    }
}
