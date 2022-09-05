<?php

namespace App;

use App\Models\Book;
use App\Models\SaveForLater;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class Cart
{
    protected function cartKey($id): string
    {
        return "cart.{$id}";
    }

    protected function cartItem($book)
    {
        return session()->get($this->cartKey($book->id));
    }

    public function update($book, $qty)
    {
        $cartItem = $this->cartItem($book);

        $cartItem['quantity'] = $qty;
        session()->put($this->cartKey($book->id), $cartItem);

        if (Auth::check()) {
            Auth::user()->carts()->where('book_id', $book->id)->update(['quantity' => $qty]);
        }
    }

    public function add($book, $qty)
    {
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
                'cover_url' => $book->cover_url,
            ]);
        }

        if (Auth::check()) {
            $cartItem = Auth::user()->carts()->where('book_id', $book->id)->first();

            if ($cartItem) {
                $cartItem->update(['quantity' => $cartItem->quantity + $qty]);
            } else {
                Auth::user()->carts()->create([
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
        session()->pull($this->cartKey($book->id));

        if (Auth::check()) {
            Auth::user()->carts()->where('book_id', $book->id)->delete();
        }
    }

    protected function filterAvailableSavedItems()
    {
        return array_filter(session('saveforlater'), function ($cartItem) {
            $book = Book::find($cartItem['id']);

            return $book->stock_count > 0;
        });
    }

    protected function filterOverStockCartItems()
    {
        return array_filter(session('cart'), function ($cartItem) {
            $book = Book::find($cartItem['id']);

            return $cartItem['quantity'] > $book->stock_count;
        });
    }

    protected function updateQuantity($items)
    {
        foreach ($items as $item) {
            $bookStockCount = Book::find($item['id'])->stock_count;
            $cartItem = session()->pull("cart.{$item['id']}");

            $cartItem['quantity'] = $bookStockCount;

            session()->put("cart.{$item['id']}", $cartItem);

            if (Auth::check()) {
                Auth::user()->carts()->where('book_id', $item['id'])->update(['quantity' => $bookStockCount]);
            }
        }
    }

    protected function filterNotAvailableCartItems() {
        return array_filter(session('cart'), function ($cartItem) {
            $book = Book::find($cartItem['id']);

            return $book->stock_count == 0;
        });
    }

    protected function moveToSaveForLater($items) {
        foreach ($items as $item) {
            $cartItem = session()->pull("cart.{$item['id']}");

            session()->put("saveforlater.{$item['id']}", $cartItem);

            if (Auth::check()) {
                $dbCartItem = Auth::user()->carts()->where('book_id', $item['id'])->first();

                SaveForLater::create([
                    'user_id' => Auth::id(),
                    'book_id' => $dbCartItem['book_id'],
                    'title' => $dbCartItem['title'],
                    'quantity' => $dbCartItem['quantity'],
                    'price' => $dbCartItem['price']
                ]);
                $dbCartItem->delete();
            }
        }
    }

    public function checkStockForCheckout(): array
    {
        if (!empty(session('saveforlater'))) {
            $availableSavedItems = $this->filterAvailableSavedItems();
        }

        if (!empty(session('cart'))) {
            $notAvailableCartItems = $this->filterNotAvailableCartItems();

            if (count($notAvailableCartItems)) {
                $this->moveToSaveForLater($notAvailableCartItems);
            }

            $overStockCartItems = $this->filterOverStockCartItems();

            if (count($overStockCartItems)) {
                $this->updateQuantity($overStockCartItems);
            }
        }

        return [
            'overStockItems' => isset($overStockCartItems) ? array_values($overStockCartItems) : [],
            'availableSavedItems' => isset($availableSavedItems) ? array_values($availableSavedItems) : []
        ];
    }
}
