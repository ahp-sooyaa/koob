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
                        'slug' => $cartItem['slug'],
                        'quantity' => $cartItem['quantity'],
                        'price' => $cartItem['price'],
                        'cover_url' => $cartItem['cover_url'],
                    ]);
                }
            }
        }

        foreach ($event->user->carts as $dbCartItem) {
            if (! session()->has("cart.{$dbCartItem->book_id}")) {
                session()->put("cart.{$dbCartItem->book_id}", [
                    'id' => $dbCartItem->book_id,
                    'title' => $dbCartItem->title,
                    'slug' => $dbCartItem->slug,
                    'quantity' => $dbCartItem->quantity,
                    'price' => $dbCartItem->price,
                    'cover_url' => $dbCartItem->cover_url,
                ]);
            }
        }

        // should i move 'saveforlater' session to database which happen when visit cart page
        // with not available item without login

        foreach ($event->user->saveForLaters as $dbSaveForLaterItem) {
            if (! session()->has("saveforlater.{$dbSaveForLaterItem->book_id}")) {
                session()->put("saveforlater.{$dbSaveForLaterItem->book_id}", [
                    'id' => $dbSaveForLaterItem->book_id,
                    'title' => $dbSaveForLaterItem->title,
                    'slug' => $dbSaveForLaterItem->slug,
                    'quantity' => $dbSaveForLaterItem->quantity,
                    'price' => $dbSaveForLaterItem->price,
                    'cover_url' => $dbSaveForLaterItem->cover_url,
                ]);
            }
        }
    }
}
