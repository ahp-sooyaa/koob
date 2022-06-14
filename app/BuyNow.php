<?php

namespace App;

/**
 *
 */
class BuyNow
{
    public function update($book, $qty)
    {
        $buyNowItem = $this->buyNowItem($book);

        $buyNowItem['quantity'] = $qty;
        session()->put($this->buyNowKey($book->id), $buyNowItem);
    }

    public function add($book, $qty)
    {
        $buyNowItem = $this->buyNowItem($book);

        if ($buyNowItem) {
            $buyNowItem['quantity'] += $qty;
            session()->put($this->buyNowKey($book->id), $buyNowItem);
        } else {
            session()->put($this->buyNowKey($book->id), [
                'id' => $book->id,
                'title' => $book->title,
                'quantity' => $qty,
                'price' => $book->price,
            ]);
        }
    }

    public function remove($book)
    {
        session()->pull($this->buyNowKey($book->id));
    }

    protected function buyNowKey($id)
    {
        return "buyNow.{$id}";
    }

    protected function buyNowItem($book)
    {
        return session()->get($this->buyNowKey($book->id));
    }
}
