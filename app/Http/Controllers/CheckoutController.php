<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index()
    {
        if (auth()->check() && Cart::where('user_id', auth()->id())->get()->isNotEmpty()) {
            return Inertia::render('Checkout', [
                // notify user about the cart session is sync with cart table
                'message' => session('cart') ? 'Your cart session data are combined with cart data from database' : ''
            ]);
        }

        return Redirect::route('books.index');
    }

    public function thankyou(Order $order)
    {
        return Inertia::render('Thankyou', ['order' => $order->load('books')]);
    }
}
