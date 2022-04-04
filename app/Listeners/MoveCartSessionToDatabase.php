<?php

namespace App\Listeners;

use App\Models\Cart;
use Illuminate\Auth\Events\Login;

class MoveCartSessionToDatabase
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
        /**
         * TODO: i need to check is there same item in cart session & database
         * otherwise the same cart item will be display as two different items in cart page
         */

        // check if there any cart session data
        if (session('cart')) {
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
        }
    }
}
