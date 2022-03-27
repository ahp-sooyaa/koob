<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_all_items_in_cart()
    {
        $bookInCart = Book::factory()->create();
        $bookNotInCart = Book::factory()->create();

        $this->post(route('cart.store', $bookInCart->id))
            ->assertSessionHas("cart.{$bookInCart->id}");
        // $this->post(route('cart.store', $bookInCart[1]->id))
        //     ->assertSessionHas("cart.{$bookInCart[1]->id}");
        $this->assertCount(1, session('cart'));

        $this->get(route('cart.index'))
            ->assertSee($bookInCart->title)
            // ->assertSee($bookInCart[1]->title)
            ->assertDontSee($bookNotInCart->title);
    }

    public function test_guest_cannot_add_books_to_cart_more_than_once()
    {
        $book = Book::factory()->create();

        $this->post(route('cart.store', $book->id))
            ->assertSessionHas("cart.{$book->id}");
        $this->assertCount(1, session('cart'));

        $this->post(route('cart.store', $book->id));
        $this->assertCount(1, session('cart'));
    }

    public function add_to_cart($book)
    {
        $this->post(route('cart.store', $book->id))
            ->assertSessionHas("cart.{$book->id}");
        $this->assertCount(1, session('cart'));
    }

    public function test_auth_user_can_update_book_quantity_in_cart_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $book = Book::factory()->create();

        $this->post(route('cart.store', $book->id))
            ->assertSuccessful();
        $this->assertEquals(
            1,
            Cart::where('user_id', $user->id)->where('book_id', $book->id)->value('quantity')
        );

        $this->patch(route('cart.update', $book->id) . '?qty=4')
            ->assertSuccessful();
        $this->assertEquals(
            4,
            Cart::where('user_id', $user->id)->where('book_id', $book->id)->value('quantity')
        );
    }

    public function test_guest_can_update_book_quantity_in_cart_page()
    {
        $book = Book::factory()->create();

        $this->add_to_cart($book);

        $this->patch(route('cart.update', $book->id) . '?qty=2')
            ->assertSuccessful();
        $this->assertEquals(2, session('cart')[$book->id]['quantity']);
    }

    public function test_auth_user_cannot_select_more_than_stock_quantity()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $book = Book::factory()->create(['stock_count' => 5]);

        $this->post(route('cart.store', $book->id))
            ->assertSuccessful();
        $this->assertEquals(
            1,
            Cart::where('user_id', $user->id)->where('book_id', $book->id)->value('quantity')
        );

        $this->patch(route('cart.update', $book->id) . '?qty=3')
            ->assertSuccessful();
        $this->assertEquals(
            3,
            Cart::where('user_id', $user->id)->where('book_id', $book->id)->value('quantity')
        );

        $this->patch(route('cart.update', $book->id) . '?qty=10')
            ->assertUnprocessable();
    }

    public function test_guest_cannot_select_more_than_stock_quantity()
    {
        $book = Book::factory()->create(['stock_count' => 5]);

        $this->add_to_cart($book);

        $this->patch(route('cart.update', $book->id) . '?qty=2')
            ->assertSuccessful();
        $this->assertEquals(2, session('cart')[$book->id]['quantity']);

        $this->patch(route('cart.update', $book->id) . '?qty=8')
            ->assertUnprocessable();
    }

    public function test_auth_user_can_remove_item_from_cart()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $book = Book::factory()->create(['stock_count' => 5]);

        $this->post(route('cart.store', $book->id))
            ->assertSuccessful();
        $this->assertEquals(
            1,
            Cart::where('user_id', $user->id)->where('book_id', $book->id)->value('quantity')
        );

        $this->delete(route('cart.destroy', $book->id))
            ->assertSuccessful();
        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);
    }

    public function test_guest_can_remove_item_from_cart()
    {
        $book = Book::factory()->create();

        $this->add_to_cart($book);

        $this->delete(route('cart.destroy', $book->id))
            ->assertSessionMissing("cart.{$book->id}");
        $this->assertCount(0, session('cart'));
    }
}
