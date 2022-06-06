<?php

namespace App;

use App\Models\Cart as ModelsCart;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class Cart
{
    public function update($book, $qty)
    {
        // $cartItem = $this->cartItem($book);

        // if (auth()->user()) {
        //     if (session('checkoutProcess')) {
        //         $book->update(['available_stock_count' => $book->available_stock_count - ($qty - $cartItem->quantity)]);
        //     }

        //     $cartItem->update(['quantity' => $qty]);
        // } else {
        //     $cartItem['quantity'] = $qty;
        //     session()->put($this->cartKey($book->id), $cartItem);
        // }

        $cartItem = $this->cartItem($book);

        $cartItem['quantity'] = $qty;
        session()->put($this->cartKey($book->id), $cartItem);

        if (Auth::check()) {
            $cartItem = ModelsCart::where('book_id', $book->id)->where('user_id', Auth::id())->first();
            $cartItem->update(['quantity' => $qty]);

            if (session('checkoutProcess')) {
                $book->update(['available_stock_count' => $book->available_stock_count - ($qty - $cartItem->quantity)]);
            }
        }
    }

    public function add($book, $qty)
    {
        // check user is logged in or not
        // if user is not logged in use session
        // if (! auth()->check()) {
        //     $cartItem = $this->cartItem($book);
        //     if (! $cartItem) {
        //         session()->put($this->cartKey($book->id), [
        //             'id' => $book->id,
        //             'title' => $book->title,
        //             'quantity' => $qty,
        //             'price' => $book->price,
        //         ]);
        //     } else {
        //         $cartItem['quantity'] += $qty;
        //         session()->put($this->cartKey($book->id), $cartItem);
        //     }
        // } else {
        //     // otherwise use cart table to persist cart data
        //     $cartItem = ModelsCart::where('book_id', $book->id)->where('user_id', auth()->id())->first();
        //     if (! $cartItem) {
        //         ModelsCart::create([
        //             'user_id' => auth()->id(),
        //             'book_id' => $book->id,
        //             'title' => $book->title,
        //             'quantity' => $qty,
        //             'price' => $book->price
        //         ]);
        //     } else {
        //         $cartItem->update(['quantity' => $cartItem->quantity + $qty]);
        //     }
        // }

        $cartItem = $this->cartItem($book);

        if ($cartItem) {
            $cartItem['quantity'] += $qty;
            session()->put($this->cartKey($book->id), $cartItem);
        } else {
            session()->put($this->cartKey($book->id), [
                'id' => $book->id,
                'title' => $book->title,
                'quantity' => $qty,
                'price' => $book->price,
            ]);
        }

        if (Auth::check()) {
            $cartItem = ModelsCart::where('book_id', $book->id)->where('user_id', Auth::id())->first();
            if ($cartItem) {
                $cartItem->update(['quantity' => $cartItem->quantity + $qty]);
            } else {
                ModelsCart::create([
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                    'title' => $book->title,
                    'quantity' => $qty,
                    'price' => $book->price
                ]);
            }
        }
    }

    public function remove($book)
    {
        // if (auth()->user()) {
        //     ModelsCart::where('book_id', $book->id)->delete();

        //     if (! ModelsCart::where('user_id', auth()->id())->exists() && session('checkoutProcess')) {
        //         session()->put('checkoutProcess', false);
        //     }
        // } else {
        //     session()->pull($this->cartKey($book->id));
        // }

        session()->pull($this->cartKey($book->id));

        if (Auth::check()) {
            ModelsCart::where('book_id', $book->id)->where('user_id', Auth::id())->delete();

            if (! ModelsCart::where('user_id', Auth::id())->exists() && session('checkoutProcess')) {
                session()->put('checkoutProcess', false);
            }
        }
    }

    protected function cartKey($id)
    {
        return "cart.{$id}";
    }

    protected function cartItem($book)
    {
        // if (auth()->user()) {
        //     return ModelsCart::where('book_id', $book->id)->first();
        // }

        return session()->get($this->cartKey($book->id));
    }
}
