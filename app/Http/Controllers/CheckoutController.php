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
        // $cart = Cart::where('user_id', auth()->id())->get();

        $hasItems = request('buynow') ? session()->has('buyNow') : session()->has('cart');
        // allow if there is buy now session
        if (Auth::check() && $hasItems) {
            // if (auth()->check() && $cart->isNotEmpty()) {
            // if (! session('checkoutProcess')) {
            //     // decrease available count when user click checkout
            //     foreach ($cart as $cartItem) {
            //         $book = Book::find($cartItem->book_id);
            //         $book->update(['available_stock_count' => $book->available_stock_count - $cartItem->quantity]);
            //     }

            //     session()->put('checkoutProcess', true);
            // }

            return Inertia::render('Checkout', [
                // notify user about the cart session is sync with cart table
                // 'message' => session('cartItemsCombined') ? session()->pull('cartItemsCombined') : '',
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
