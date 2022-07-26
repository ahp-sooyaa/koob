<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SaveForLaterController extends Controller
{
    public function store($id)
    {
        $sessionCartItem = session()->pull("cart.{$id}");

        session()->put("saveforlater.{$id}", $sessionCartItem);

        $dbCartItem = Auth::user()->carts()->where('book_id', $id)->first();

        Auth::user()->saveForLaters()->create([
            'book_id' => $dbCartItem->book_id,
            'title' => $dbCartItem->title,
            'quantity' => $dbCartItem->quantity,
            'price' => $dbCartItem->price,
        ]);
        $dbCartItem->delete();

        return response()->json(['message' => 'Successfully saved book for later']);
    }

    public function moveToCart($id)
    {
        $sessionCartItem = session()->pull("saveforlater.{$id}");

        session()->put("cart.{$id}", $sessionCartItem);

        $dbCartItem = Auth::user()->saveForLaters()->where('book_id', $id)->first();

        Auth::user()->carts()->create([
            'book_id' => $dbCartItem->book_id,
            'title' => $dbCartItem->title,
            'quantity' => $dbCartItem->quantity,
            'price' => $dbCartItem->price,
        ]);
        $dbCartItem->delete();

        return response()->json(['message' => 'Successfully moved book to cart.']);
    }
}
