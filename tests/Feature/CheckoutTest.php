<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_render_checkout_screen_without_cart_items()
    {
        $book = Book::factory()->create();

        $this->get(route('checkout.index'))
            ->assertRedirect(route('books.index'));

        $this->post(route('cart.store', $book->id))
            ->assertSessionHas("cart.{$book->id}");

        $this->get(route('checkout.index'))->assertSuccessful();
    }
}
