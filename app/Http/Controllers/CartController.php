<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Book;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Cart $cart)
    {
        if (request()->wantsJson()) {
            return response()->json([
                'cartItems' => ! empty(session('cart')) ? array_values(session('cart')) : [],
            ]);
        }

        $filtered = $cart->checkStockForCheckout();

        return Inertia::render('Cart', array_merge($filtered, [
            'cartItems' => ! empty(session('cart')) ? array_values(session('cart')) : [],
            'allSavedItems' => ! empty(session('saveforlater')) ? array_values(session('saveforlater')) : [],
        ]));
    }

    public function update(Book $book, Cart $cart, Request $request)
    {
        if ($book->stock_count < $request->input('qty')) {
            return response()->json([
                'message' => "Sorry, we only have $book->stock_count items in stock.",
            ], 422);
        }

        $cart->update($book, $request->input('qty'));

        return response()->json(['message' => 'Successfully updated cart quantity.']);
    }

    public function store(Book $book, Cart $cart, Request $request)
    {
        $qty = $request->input('qty', 1);
        $cartItem = session("cart.{$book->id}");

        if ($book->stock_count < (is_null($cartItem) ? 0 : $cartItem['quantity']) + $qty) {
            return response()->json([
                'message' => "Sorry, we only have $book->stock_count items in stock.",
            ], 422);
        }

        $cart->add($book, $qty);

        return response()->json(['message' => 'Successfully added to cart.']);
    }

    public function destroy(Book $book, Cart $cart)
    {
        $cart->remove($book);

        return response()->json(['message' => 'Successfully removed from cart.']);
    }
}
