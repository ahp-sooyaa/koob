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
        if (auth()->user()) {
            $cartItem = $this->cartItem($book);
            $cartItem->update(['quantity' => $qty]);
        } else {
            $cartItem = $this->cartItem($book);
            $cartItem['quantity'] = $qty;
            session()->put($this->cartKey($book->id), $cartItem);
        }
    }

    public function add($book, $qty)
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
                $cartItem['quantity']++;
                session()->put($this->cartKey($book->id), $cartItem);
            }
            // session()->increment($this->cartKey($book->id));
        } else {
            // otherwise use cart table to persist cart data
            // Cart::create($book);
            $cartItem = ModelsCart::where('book_id', $book->id)->first();
            if (! $cartItem) {
                ModelsCart::create([
                    'user_id' => auth()->id(),
                    'book_id' => $book->id,
                    'title' => $book->title,
                    'quantity' => $qty,
                    'price' => $book->price
                ]);
            } else {
                $cartItem->increment('quantity');
            }
        }
    }

    public function remove($book)
    {
        if (auth()->user()) {
            ModelsCart::where('book_id', $book->id)->delete();
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
