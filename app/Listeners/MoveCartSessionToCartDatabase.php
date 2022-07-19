<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Models\SaveForLater;
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
        }

        foreach ($event->user->carts as $dbCartItem) {
            if (! session()->has("cart.{$dbCartItem->book_id}")) {
                session()->put("cart.{$dbCartItem->book_id}", [
                    'id' => $dbCartItem->book_id,
                    'title' => $dbCartItem->title,
                    'quantity' => $dbCartItem->quantity,
                    'price' => $dbCartItem->price,
                ]);
            }
        }

        foreach ($event->user->saveForLaters as $dbSaveForLaterItem) {
            if (! session()->has("saveforlater.{$dbSaveForLaterItem->book_id}")) {
                session()->put("saveforlater.{$dbSaveForLaterItem->book_id}", [
                    'id' => $dbSaveForLaterItem->book_id,
                    'title' => $dbSaveForLaterItem->title,
                    'quantity' => $dbSaveForLaterItem->quantity,
                    'price' => $dbSaveForLaterItem->price,
                ]);
            }
        }
    }
}
