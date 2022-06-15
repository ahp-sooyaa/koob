<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Models\Saveforlater;
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
            // if (Cart::where('user_id', $event->user->id)->exists()) {
            //     session()->put(
            //         'cartItemsCombined',
            //         'Your cart items are combined with old cart items. So please check before continue the process'
            //     );
            // }

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
            // if ($sessionCartItem = session()->get("cart.{$dbCartItem->book_id}")) {
            //     $sessionCartItem['quantity'] = $dbCartItem->quantity;
            //     session()->put("cart.{$dbCartItem->book_id}", $sessionCartItem);
            // } else {
            //     session()->put("cart.{$dbCartItem->book_id}", [
            //         'id' => $dbCartItem->book_id,
            //         'title' => $dbCartItem->title,
            //         'quantity' => $dbCartItem->quantity,
            //         'price' => $dbCartItem->price,
            //     ]);
            // }
            if (! session()->has("cart.{$dbCartItem->book_id}")) {
                session()->put("cart.{$dbCartItem->book_id}", [
                    'id' => $dbCartItem->book_id,
                    'title' => $dbCartItem->title,
                    'quantity' => $dbCartItem->quantity,
                    'price' => $dbCartItem->price,
                ]);
            }
        }

        // if (session('saveforlater')) {
        //     foreach (session('saveforlater') as $saveForLaterItem) {
        //         if ($saveForLater = Saveforlater::where('user_id', $event->user->id)->where('book_id', $saveForLaterItem['id'])->first()) {
        //             $saveForLater->update(['quantity' => $saveForLaterItem['quantity']]);
        //         } else {
        //             Saveforlater::create([
        //                 'user_id' => $event->user->id,
        //                 'book_id' => $saveForLaterItem['id'],
        //                 'title' => $saveForLaterItem['title'],
        //                 'quantity' => $saveForLaterItem['quantity'],
        //                 'price' => $saveForLaterItem['price']
        //             ]);
        //         }
        //     }
        // }

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
