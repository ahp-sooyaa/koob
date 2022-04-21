<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Book;
use App\Models\Cart as ModelsCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        // give user's all cart data from inertia shared props
        return Inertia::render('Cart', ['appliedCoupon' => session('coupon') ?? null]);
    }

    public function update(Book $book, Cart $cart, Request $request)
    {
        // update cart product quantity when qty that user want to buy is not exceed over stock_count
        if ($book->stock_count < $request->input('qty')) {
            return response()->json([
                'message' => "Quantity is exceeding over stock. Available quantity($book->stock_count)"
            ], 422);
        }

        $cart->update($book, $request->input('qty'));

        return response()->json(['message' => 'Successfully updated']);
        // return back()->with('message', 'success');
    }

    public function store(Book $book, Cart $cart)
    {
        // add to cart session or table
        $cartItem = auth()->check() ? ModelsCart::where('book_id', $book->id)->first() : session("cart.{$book->id}");

        if ($book->stock_count < (is_null($cartItem) ? 0 : $cartItem['quantity']) + 1) {
            return response()->json([
                'message' => "Quantity is exceeding over stock. Available quantity($book->stock_count)"
            ], 422);
        }

        $cart->add($book);

        // return Redirect::back()->with('cart', ModelsCart::where('user_id', auth()->id())->get());
    }

    public function destroy(Book $book, Cart $cart)
    {
        // remove single cart data not clear the whole cart
        // i think clear cart don't need controller method
        $cart->remove($book);
    }
}
