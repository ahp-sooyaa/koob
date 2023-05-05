<?php

namespace App\Http\Controllers;

use App\Models\Book;
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

        $cartData = ! empty(session('cart')) ? array_values(session('cart')) : [];

        if (! empty(session('cart'))) {
            foreach ($cartData as $key => $cartItem) {
                $book = Book::find($cartItem['id']);

                $cartItem['discount_amount'] = $book->promotions->first()?->discount_amount;
                $cartItem['is_percentage_discount'] = $book->promotions->first()?->is_percentage_discount;
                $cartData[$key] = $cartItem;
            }
        }
        if (Auth::check() && $hasItems) {
            return Inertia::render('Checkout', [
                'appliedCoupon' => session('coupon'),
                'isCartCheckout' => $request->input('buynow') ? false : true,
                'cartData' => $cartData,
            ]);
        }

        return Redirect::route('books.index');
    }

    public function thankYou(Order $order)
    {
        return Inertia::render('Thankyou', ['order' => $order->load('books')]);
    }
}
