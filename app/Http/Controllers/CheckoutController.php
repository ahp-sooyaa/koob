<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->get();

        if (auth()->check() && $cart->isNotEmpty()) {
            // decrease available count when user click checkout
            // return $cart->map(function ($item) {
            //     $book = Book::find($item->id);

            //     if ($book->available_stock_count != 0) {
            //         $book->update([
            //             'available_stock_count' => $book->available_stock_count - $item->quantity
            //         ]);
            //     } else {
            //         return response()->json([
            //             'message' => 'Sorry, your cart item ' . $book->title . ' is not available to checkout. All items are in reserved.'
            //         ], 422);
            //     }
            // });

            return Inertia::render('Checkout', [
                // notify user about the cart session is sync with cart table
                'message' => session('cartItemsCombined') ? session()->pull('cartItemsCombined') : '',
                'appliedCoupon' => session('coupon')
            ]);
        }

        return Redirect::route('books.index');
    }

    public function thankyou(Order $order)
    {
        return Inertia::render('Thankyou', ['order' => $order->load('books')]);
    }
}
