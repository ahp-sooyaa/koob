<?php

namespace App\Http\Controllers;

// use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index()
    {
        $hasItems = request('buynow') ? !empty(session('buyNow')) : !empty(session('cart'));

        if (Auth::check() && $hasItems) {
            return Inertia::render('Checkout', [
                'appliedCoupon' => session('coupon'),
                'checkoutMode' => request('buynow') ? 'buynow' : 'cart'
            ]);
        }

        return Redirect::route('books.index');
    }

    public function thankyou(Order $order)
    {
        return Inertia::render('Thankyou', ['order' => $order->load('books')]);
    }
}
