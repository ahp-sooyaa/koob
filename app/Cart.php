<?php

namespace App;

use App\Models\Cart as ModelsCart;

/**
 *
 */
class Cart
{
    public function update($book, $qty)
    {
        $cartItem = $this->cartItem($book);

        if (auth()->user()) {
            if (session('checkoutProcess')) {
                $book->update(['available_stock_count' => $book->available_stock_count - ($qty - $cartItem->quantity)]);
            }

            $cartItem->update(['quantity' => $qty]);
        } else {
            $cartItem['quantity'] = $qty;
            session()->put($this->cartKey($book->id), $cartItem);
        }
    }

    public function add($book, $qty = 1)
    {
        // check user is logged in or not
        // if user is not logged in use session
        if (! auth()->check()) {
            $cartItem = $this->cartItem($book);
            if (! $cartItem) {
                session()->put($this->cartKey($book->id), [
                    'id' => $book->id,
                    'title' => $book->title,
                    'quantity' => $qty,
                    'price' => $book->price,
                ]);
            } else {
                $cartItem['quantity'] += $qty;
                session()->put($this->cartKey($book->id), $cartItem);
            }
        } else {
            // otherwise use cart table to persist cart data
            $cartItem = ModelsCart::where('book_id', $book->id)->where('user_id', auth()->id())->first();
            if (! $cartItem) {
                ModelsCart::create([
                    'user_id' => auth()->id(),
                    'book_id' => $book->id,
                    'title' => $book->title,
                    'quantity' => $qty,
                    'price' => $book->price
                ]);
            } else {
                $cartItem->update(['quantity' => $cartItem->quantity + $qty]);
            }
        }
    }

    public function remove($book)
    {
        if (auth()->user()) {
            ModelsCart::where('book_id', $book->id)->delete();

            if (! ModelsCart::where('user_id', auth()->id())->exists() && session('checkoutProcess')) {
                session()->put('checkoutProcess', false);
            }
        } else {
            session()->pull($this->cartKey($book->id));
        }
    }

    protected function cartKey($id)
    {
        return "cart.{$id}";
    }

    protected function cartItem($book)
    {
        if (auth()->user()) {
            return ModelsCart::where('book_id', $book->id)->first();
        }

        return session()->get($this->cartKey($book->id));
    }
}
