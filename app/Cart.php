<?php

namespace App;

/**
 *
 */
class Cart
{
    public function add($book)
    {
        // check user is logged in or not
        // if user is not logged in use session
        if (! auth()->check()) {
            // $quantity = session()->get($this->cartKey($book->id));
            // session()->put($this->cartKey($book->id), $quantity++);
            session()->increment($this->cartKey($book->id));
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
}
