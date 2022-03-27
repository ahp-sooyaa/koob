<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Book;
use App\Models\Cart as ModelsCart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        // give user's all cart data from inertia shared props
        // $cartFromDB = ModelsCart::query()
        // ->addSelect(
        //     ['book_title' => Book::select('title')
        //     ->whereColumn('id', 'carts.book_id')
        //     ->get()]
        // )->where('user_id', auth()->id())->get();

        return Inertia::render('Cart', [
            'cartFromDB' => ModelsCart::where('user_id', auth()->id())->get()
        ]);
    }

    public function update(Book $book, Cart $cart, Request $request)
    {
        // update cart product quantity when in view cart page
        if ($book->stock_count < $request->input('qty')) {
            return response()->json([
                'message' => "Quantity is exceeding over stock. Available quantity($book->stock_count)"
            ], 422);
        }

        $cart->update($book, $request->input('qty'));
        return response()->json(['message' => 'Successfully updated']);
    }

    public function store(Book $book, Cart $cart, Request $request)
    {
        // add to cart session or table
        $qty = $request->input('qty') ?: 1;
        $cart->add($book, $qty);
    }

    public function destroy(Book $book, Cart $cart)
    {
        // remove single cart data not clear the whole cart
        // i think clear cart don't need controller method
        $cart->remove($book);
    }
}
