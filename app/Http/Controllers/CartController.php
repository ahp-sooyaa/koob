<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Book;
use App\Models\Cart as ModelsCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        if (! session('checkoutProcess')) {
            // give user's all cart data from inertia shared props
            return Inertia::render('Cart', [
                'message' => session('cartItemsCombined') ? session()->pull('cartItemsCombined') : ''
            ]);
        }

        return Redirect::route('checkout.index');
    }

    public function update(Book $book, Cart $cart, Request $request)
    {
        // update cart product quantity when qty that user want to buy is not exceed over stock_count
        $cartItem = ModelsCart::where('book_id', $book->id)->first();

        if ($book->available_stock_count < ($request->input('qty') - $cartItem->quantity)) {
            return response()->json([
                'message' => "Quantity is exceeding here over available stock. Available quantity($book->available_stock_count)"
            ], 422);
        }

        $cart->update($book, $request->input('qty'));

        return response()->json(['message' => 'Successfully updated']);
    }

    public function store(Book $book, Cart $cart, Request $request)
    {
        // add to cart session or table
        if (session('checkoutProcess')) {
            return response()->json([
                'message' => 'Please cancel the checkout process to update cart items!'
            ], 422);
        }

        $qty = $request->input('qty') ?: 1;
        $cartItem = auth()->check() ? ModelsCart::where('book_id', $book->id)->first() : session("cart.{$book->id}");

        if ($book->available_stock_count < (is_null($cartItem) ? 0 : $cartItem['quantity']) + $qty) {
            return response()->json([
                'message' => "Quantity is exceeding over available stock. Available quantity($book->available_stock_count)"
            ], 422);
        }

        $cart->add($book, $qty);
    }

    public function destroy(Book $book, Cart $cart)
    {
        // remove single cart data not clear the whole cart
        // i think clear cart don't need controller method
        if (session('checkoutProcess')) {
            $cartItem = ModelsCart::where('user_id', auth()->id())->where('book_id', $book->id)->first();
            $book->update(['available_stock_count' => $book->available_stock_count + $cartItem->quantity]);
        }
        $cart->remove($book);
    }

    public function checkStockForCheckout()
    {
        if (auth()->check()) {
            $overstockitems = Book::join('carts', 'books.id', '=', 'carts.book_id')
                ->where('carts.user_id', auth()->id())
                // ->where('carts.quantity', '>', 'books.available_stock_count')
                ->whereRaw('carts.quantity > books.available_stock_count')
                ->get();
        } else {
            $overstockitems = [];
            foreach (session('cart') as $cartItem) {
                $book = Book::where('id', $cartItem['id'])->first();
                if ($cartItem['quantity'] > $book->available_stock_count) {
                    $overstockitems[] = [
                        'id' => $cartItem['id'],
                        'title' => $cartItem['title'],
                        'quantity' => $cartItem['quantity'],
                        'available_stock_count' => $book->available_stock_count,
                    ];
                }
            }
        }

        if (count($overstockitems)) {
            return response()->json([
                'overstockitems' => $overstockitems
            ], 422);
        }

        return response()->json(['message' => 'ok']);
    }

    public function cancelCheckoutProcess()
    {
        $this->restoreStock();

        session()->put('checkoutProcess', false);
    }

    public function timeoutCheckoutProcess()
    {
        $this->restoreStock();

        Auth::guard('web')->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();
    }

    public function restoreStock()
    {
        $cart = ModelsCart::where('user_id', auth()->id())->get();

        if ($cart) {
            foreach ($cart as $cartItem) {
                $book = Book::find($cartItem->book_id);
                $book->update(['available_stock_count' => $book->available_stock_count + $cartItem->quantity]);
            }
        }
    }
}
