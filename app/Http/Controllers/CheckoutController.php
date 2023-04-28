<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $hasItems = $request->input('buynow') ? ! empty(session('buyNow')) : ! empty(session('cart'));

        if (Auth::check() && $hasItems) {
            return Inertia::render('Checkout', [
                'appliedCoupon' => session('coupon'),
                'isCartCheckout' => $request->input('buynow') ? false : true,
            ]);
        }

        return Redirect::route('books.index');
    }

    public function thankYou(Order $order)
    {
        return Inertia::render('Thankyou', ['order' => $order->load('books')]);
    }
}
