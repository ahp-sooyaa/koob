<?php

namespace App\Http\Controllers;

use App\BuyNow;
use App\Models\Book;
use Illuminate\Http\Request;

class BuyNowController extends Controller
{
    public function store(BuyNow $buyNow, Book $book)
    {
        $cartItem = session("buyNow.{$book->id}");

        if ($book->stock_count < (is_null($cartItem) ? 0 : $cartItem['quantity']) + 1) {
            return response()->json([
                'message' => "Quantity is exceeding over available stock. Available quantity($book->stock_count)"
            ], 422);
        }

        $buyNow->add($book, 1);
    }

    public function update(Book $book, BuyNow $buyNow, Request $request)
    {
        if ($book->stock_count < $request->input('qty')) {
            return response()->json([
                'message' => "Quantity is exceeding over available stock. Available quantity($book->stock_count)"
            ], 422);
        }

        $buyNow->update($book, $request->input('qty'));
    }

    public function destroy(Book $book, BuyNow $buyNow)
    {
        $buyNow->remove($book);
    }
}
