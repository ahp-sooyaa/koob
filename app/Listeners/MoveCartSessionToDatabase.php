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
        // dd(session('cart'));
        // check if there any cart session data
        if (session('cart')) {
            // if there any cart session move to cart database
            foreach (session('cart') as $cartItem) {
                // dd($cartItem['title']);
                Cart::create([
                    'user_id' => $event->user->id,
                    'book_id' => $cartItem['id'],
                    'title' => $cartItem['title'],
                    'quantity' => $cartItem['quantity'],
                    'price' => $cartItem['price']
                ]);
            }
            // $cartItem = session('cart');
            // $cartItem['user_id'] = $event->user->id;
            // Cart::insert($cartItem);
        }
    }
}
