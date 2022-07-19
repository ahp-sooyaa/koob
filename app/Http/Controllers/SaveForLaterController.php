<?php

namespace App\Http\Controllers;

use App\Models\Cart as ModelsCart;
use App\Models\SaveForLater;
use Illuminate\Support\Facades\Auth;

class SaveForLaterController extends Controller
{
    public function store($id)
    {
        $sessionCartItem = session()->pull("cart.{$id}");

        session()->put("saveforlater.{$id}", $sessionCartItem);

        $dbCartItem = ModelsCart::where([
            ['user_id', Auth::id()],
            ['book_id', $id],
        ])->first();

        SaveForLater::create([
            'user_id' => Auth::id(),
            'book_id' => $dbCartItem['book_id'],
            'title' => $dbCartItem['title'],
            'quantity' => $dbCartItem['quantity'],
            'price' => $dbCartItem['price']
        ]);
        $dbCartItem->delete();

        return response()->json(['message' => 'Successfully saved book for later']);
    }

    public function moveToCart($id)
    {
        $sessionCartItem = session()->pull("saveforlater.{$id}");

        session()->put("cart.{$id}", $sessionCartItem);

        $dbCartItem = SaveForLater::where([
            ['user_id', Auth::id()],
            ['book_id', $id],
        ])->first();

        ModelsCart::create([
            'user_id' => Auth::id(),
            'book_id' => $dbCartItem->book_id,
            'title' => $dbCartItem->title,
            'quantity' => $dbCartItem->quantity,
            'price' => $dbCartItem->price
        ]);
        $dbCartItem->delete();

        return response()->json(['message' => 'Successfully moved book to cart.']);
    }
}
