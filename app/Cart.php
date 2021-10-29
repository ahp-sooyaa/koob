<?php

namespace App;

/**
 *
 */
class Cart
{
    public function update($book, $qty)
    {
        $cartItem = $this->cartItem($book);
        $cartItem['quantity'] = $qty;
        session()->put($this->cartKey($book->id), $cartItem);
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
        }

        // otherwise use session table to persist cart data
    }

    public function remove($book)
    {
        session()->pull($this->cartKey($book->id));
    }

    protected function cartKey($id)
    {
        return "cart.{$id}";
    }

    protected function cartItem($book)
    {
        return session()->get($this->cartKey($book->id));
    }
}
