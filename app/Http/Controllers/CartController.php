<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Book;
use App\Models\Cart as ModelsCart;
use App\Models\Saveforlater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        // if (! session('checkoutProcess')) {
        // give user's all cart data from inertia shared props
        return Inertia::render('Cart', [
            // 'message' => session('cartItemsCombined') ? session()->pull('cartItemsCombined') : '',
            'saveforlaterItems' => session('saveforlater') ? array_values(session('saveforlater')) : []
        ]);
        // }

        // return Inertia::render('Checkout');
    }

    public function update(Book $book, Cart $cart, Request $request)
    {
        // update cart product quantity when qty that user want to buy is not exceed over stock_count
        // $cartItem = Auth::check() ? ModelsCart::where('book_id', $book->id)->first() : session("cart.{$book->id}");
        // $cartItem = session("cart.{$book->id}");

        // $quantity = session('checkoutProcess') ? ($request->input('qty') - $cartItem['quantity']) : $request->input('qty');

        if ($book->stock_count < $request->input('qty')) {
            return response()->json([
                'message' => "Quantity is exceeding over available stock. Available quantity($book->stock_count)"
            ], 422);
        }

        $cart->update($book, $request->input('qty'));

        // return response()->json(['message' => 'Successfully updated']);
    }

    public function store(Book $book, Cart $cart, Request $request)
    {
        // if (session('checkoutProcess')) {
        //     return response()->json([
        //         'message' => 'Please cancel the checkout process to update cart items!'
        //     ], 422);
        // }

        $qty = $request->input('qty') ?: 1;
        $cartItem = session("cart.{$book->id}");

        if ($book->stock_count < (is_null($cartItem) ? 0 : $cartItem['quantity']) + $qty) {
            return response()->json([
                'message' => "Quantity is exceeding over available stock. Available quantity($book->stock_count)"
            ], 422);
        }

        $cart->add($book, $qty);
    }

    public function destroy(Book $book, Cart $cart)
    {
        // remove single cart data not clear the whole cart
        // i think clear cart don't need controller method
        // if (session('checkoutProcess')) {
        //     // $cartItem = ModelsCart::where('user_id', Auth::id())->where('book_id', $book->id)->first();
        //     $cartItem = session("cart.{$book->id}");
        //     $book->update([
        //         'stock_count' => $book->stock_count + $cartItem['quantity']
        //     ]);
        // }
        $cart->remove($book);
    }

    public function checkStockForCheckout()
    {
        // if (Auth::check()) {
        //     $overstockitems = Book::join('carts', 'books.id', '=', 'carts.book_id')
        //         ->where('carts.user_id', Auth::id())
        //         ->whereRaw('carts.quantity > books.stock_count')
        //         ->get();
        // } else {
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

//          this is for not available condition move to save for later
            if (count($notAvailableCart)) {
                foreach ($notAvailableCart as $overstockitem) {
                    $cartItem = session()->pull("cart.{$overstockitem['id']}");

                    session()->put("saveforlater.{$overstockitem['id']}", $cartItem);

                    if (Auth::check()) {
                        $cartItem = ModelsCart::where('user_id', Auth::id())->where('book_id', $overstockitem['id'])->first();

                        Saveforlater::create([
                            'user_id' => Auth::id(),
                            'book_id' => $cartItem['book_id'],
                            'title' => $cartItem['title'],
                            'quantity' => $cartItem['quantity'],
                            'price' => $cartItem['price']
                        ]);
                        $cartItem->delete();
                    }
                }
                // return Redirect::back()->with('error', 'Some items in your cart are not available right now and automatically move to save for later.');
            }
        }

        if (session()->has('saveforlater')) {
            $filterSaveForLater = array_filter(session('saveforlater'), function ($cartItem) {
                $book = Book::where('id', $cartItem['id'])->first();

                return $book->stock_count > 0;
            });
        }

        // $overstockitems = array_merge($filterCart, $filterSaveForLater);
        // if ($filterCart || $filterSaveForLater) {
        return response()->json([
            'overStockItems' => session('cart') ? array_values($overStockCart) : [],
            'filterSaveForLater' => session('saveforlater') ? array_values($filterSaveForLater) : []
        ]);
        // }

        // return Redirect::route('checkout.index');
        // return response()->json(['overStockItems' => array_values($overstockitems)]);
    }

    public function cancelCheckoutProcess()
    {
        $this->restoreStock();

        session()->put('checkoutProcess', false);
    }

    public function timeoutCheckoutProcess()
    {
        $this->restoreStock();

        Auth::logout();
        // Auth::guard('web')->logout();

        // request()->session()->invalidate();

        // request()->session()->regenerateToken();
    }

    public function restoreStock()
    {
        // $cart = ModelsCart::where('user_id', Auth::id())->get();

        // if ($cart) {
        foreach (session('cart') as $cartItem) {
            $book = Book::find($cartItem['id']);
            $book->update([
                'stock_count' => $book->stock_count + $cartItem['quantity']
            ]);
        }
        // }
    }

    public function saveforlater($id)
    {
        if (Auth::check()) {
            $cartItem = session()->pull("cart.{$id}");

            session()->put("saveforlater.{$id}", $cartItem);

            $cartItem = ModelsCart::where('user_id', Auth::id())->where('book_id', $id)->first();

            Saveforlater::create([
                'user_id' => Auth::id(),
                'book_id' => $cartItem['book_id'],
                'title' => $cartItem['title'],
                'quantity' => $cartItem['quantity'],
                'price' => $cartItem['price']
            ]);
            $cartItem->delete();
        }
    }

    public function movetocart($id)
    {
        $cartItem = session()->pull("saveforlater.{$id}");

        session()->put("cart.{$id}", $cartItem);

        if (Auth::check()) {
            $cartItem = Saveforlater::where('user_id', Auth::id())->where('book_id', $id)->first();

            ModelsCart::create([
                'user_id' => Auth::id(),
                'book_id' => $cartItem->book_id,
                'title' => $cartItem->title,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price
            ]);
            $cartItem->delete();
        }
    }
}
