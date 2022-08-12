<?php

namespace App\Http\Controllers;

use App\BuyNow;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BuyNowController extends Controller
{
    public function store(BuyNow $buyNow, Book $book)
    {
        session()->forget('buyNow');

        $cartItem = session("buyNow.{$book->id}");

        if ($book->stock_count < (is_null($cartItem) ? 0 : $cartItem['quantity']) + 1) {
            return Redirect::back()->with('error', "Quantity is exceeding over available stock. Available quantity($book->stock_count)");
        }

        $buyNow->add($book, 1);

        return Redirect::route('checkout.index', ['buynow' => 1]);
    }

    public function update(Book $book, BuyNow $buyNow, Request $request)
    {
        if ($book->stock_count < $request->input('qty')) {
            return response()->json([
                'message' => "Quantity is exceeding over available stock. Available quantity($book->stock_count)"
            ], 422);
        }

        $buyNow->update($book, $request->input('qty'));

        return response()->json(['message' => 'Successfully updated cart quantity.']);
    }

    public function destroy(Book $book, BuyNow $buyNow)
    {
        $buyNow->remove($book);

        return Redirect::route('books.index')->with('success', 'Successfully removed buy now book.');
    }
}
