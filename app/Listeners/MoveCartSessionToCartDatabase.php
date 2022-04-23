<?php

namespace App\Listeners;

use App\Models\Cart;
use Illuminate\Auth\Events\Login;

class MoveCartSessionToCartDatabase
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // check if there any cart session data
        if (session('cart')) {
            if (Cart::where('user_id', $event->user->id)->get()) {
                session()->put('cartItemsCombined', 'Your cart items are combined with old cart items. So please check before continue the process');
            }

            // if there any cart session move to cart database
            foreach (session('cart') as $cartItem) {
                // i don't check stock_count before sum & update the quantity of cart item here
                // but i checked that in checkout page so user can't place order if one of cart item quantity is over stock count
                if ($cart = Cart::where('user_id', $event->user->id)->where('book_id', $cartItem['id'])->first()) {
                    // sum & update quantity
                    $cart->quantity += $cartItem['quantity'];
                    $cart->update(['quantity' => $cart->quantity]);
                } else {
                    Cart::create([
                        'user_id' => $event->user->id,
                        'book_id' => $cartItem['id'],
                        'title' => $cartItem['title'],
                        'quantity' => $cartItem['quantity'],
                        'price' => $cartItem['price']
                    ]);
                }
            }

            session()->forget('cart');
        }
    }
}
