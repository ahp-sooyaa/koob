<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Book;
use App\Models\Cart as ModelsCart;
use App\Models\SaveForLater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        return Inertia::render('Cart', [
            'saveForLaterItems' => session()->has('saveforlater') ? array_values(session('saveforlater')) : []
        ]);
    }

    public function update(Book $book, Cart $cart, Request $request)
    {
        if ($book->stock_count < $request->input('qty')) {
            return response()->json([
                'message' => "Quantity is exceeding over available stock. Available quantity($book->stock_count)"
            ], 422);
        }

        $cart->update($book, $request->input('qty'));

        return response()->json(['message' => 'Successfully updated cart quantity.']);
    }

    public function store(Book $book, Cart $cart, Request $request)
    {
        $qty = $request->input('qty') ?: 1;
        $cartItem = session("cart.{$book->id}");

        if ($book->stock_count < (is_null($cartItem) ? 0 : $cartItem['quantity']) + $qty) {
            return response()->json([
                'message' => "Quantity is exceeding over available stock. Available quantity($book->stock_count)"
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

//    public function getFiltered($session)
//    {
//        return array_filter($session, function ($sessionItem) {
//            $book = Book::where('id', $sessionItem['id'])->first();
//
//            return $sessionItem['quantity'] > $book->stock_count;
//        });
//    }

    public function checkStockForCheckout()
    {
        if (session()->has('cart')) {
            $overStockCart = array_filter(session('cart'), function ($cartItem) {
                $book = Book::where('id', $cartItem['id'])->first();

                return $cartItem['quantity'] > $book->stock_count;
            });

            if (count($overStockCart)) {
                foreach ($overStockCart as $overstockitem) {
                    $cartItem = session()->pull("cart.{$overstockitem['id']}");

                    $cartItem['quantity'] = Book::find($overstockitem['id'])->stock_count;

                    session()->put("cart.{$overstockitem['id']}", $cartItem);
                }
            }

            $notAvailableCart = array_filter(session('cart'), function ($cartItem) {
                $book = Book::where('id', $cartItem['id'])->first();

                return $book->stock_count == 0;
            });

            if (count($notAvailableCart)) {
                foreach ($notAvailableCart as $overstockitem) {
                    $cartItem = session()->pull("cart.{$overstockitem['id']}");

                    session()->put("saveforlater.{$overstockitem['id']}", $cartItem);

                    if (Auth::check()) {
                        $cartItem = ModelsCart::where('user_id', Auth::id())->where('book_id', $overstockitem['id'])->first();

                        SaveForLater::create([
                            'user_id' => Auth::id(),
                            'book_id' => $cartItem['book_id'],
                            'title' => $cartItem['title'],
                            'quantity' => $cartItem['quantity'],
                            'price' => $cartItem['price']
                        ]);
                        $cartItem->delete();
                    }
                }
            }
        }

        if (session()->has('saveforlater')) {
            $filterSaveForLater = array_filter(session('saveforlater'), function ($cartItem) {
                $book = Book::where('id', $cartItem['id'])->first();

                return $book->stock_count > 0;
            });
        }

        return response()->json([
            'overStockItems' => session('cart') ? array_values($overStockCart) : [],
            'filterSaveForLater' => session('saveforlater') ? array_values($filterSaveForLater) : []
        ]);
    }
}
