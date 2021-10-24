<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Book;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        // give user's all cart data from inertia shared props
        return Inertia::render('Cart');
    }

    public function update()
    {
        // update cart product quantity when in view cart page
    }

    public function store(Book $book, Cart $cart)
    {
        // add to cart session
        $cart->add($book);

        // flash('Book is added to cart'); flash from vue
        // give a feedback such as flash message
    }

    public function destroy(Book $book, Cart $cart)
    {
        // remove single cart data not clear the whole cart
        // i think clear cart don't need controller method
        $cart->remove($book);
    }
}
