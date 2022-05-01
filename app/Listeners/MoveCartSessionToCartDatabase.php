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
        if (session('cart')) {
            if (Cart::where('user_id', $event->user->id)->exists()) {
                session()->put(
                    'cartItemsCombined',
                    'Your cart items are combined with old cart items. So please check before continue the process'
                );
            }

            foreach (session('cart') as $cartItem) {
                if ($cart = Cart::where('user_id', $event->user->id)->where('book_id', $cartItem['id'])->first()) {
                    $cart->update(['quantity' => $cartItem['quantity']]);
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
