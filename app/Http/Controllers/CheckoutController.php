<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $hasItems = $request->input('buynow') ? !empty(session('buyNow')) : !empty(session('cart'));

        if (Auth::check() && $hasItems) {
            return Inertia::render('Checkout', [
                'appliedCoupon' => session('coupon'),
                'checkoutMode' => $request->input('buynow') ? 'buynow' : 'cart',
                'addresses' => Auth::user()->addresses
            ]);
        }

        return Redirect::route('books.index');
    }

    public function thankYou(Order $order)
    {
        return Inertia::render('Thankyou', ['order' => $order->load('books')]);
    }
}
