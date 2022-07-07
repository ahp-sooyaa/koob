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
        $booksInCart = Book::factory(2)->create();
        $bookNotInCart = Book::factory()->create();

        $this->post(route('cart.store', $booksInCart[0]->id))
            ->assertSessionHas("cart.{$booksInCart[0]->id}");
        $this->post(route('cart.store', $booksInCart[1]->id))
            ->assertSessionHas("cart.{$booksInCart[1]->id}");
        $this->assertCount(2, session('cart'));

        $this->get(route('cart.index'))
            ->assertSee($booksInCart[0]->title)
            ->assertSee($booksInCart[1]->title)
            ->assertDontSee($bookNotInCart->title);
    }

    public function test_cart_item_quantity_increase_if_already_existed()
    {
        $book = Book::factory()->create();

        $this->post(route('cart.store', $book->id))
            ->assertSessionHas("cart.{$book->id}");
        $this->assertCount(1, session('cart'));

        $this->post(route('cart.store', $book->id));
        $this->assertCount(1, session('cart'));
        $this->assertEquals(2, session('cart')[$book->id]['quantity']);
    }

    public function test_auth_user_can_update_book_quantity_in_cart_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $book = Book::factory()->create();

        $this->add_to_cart_table($book, $user);

        $this->patch(route('cart.update', $book->id) . '?qty=4')
            ->assertSuccessful();
        $this->assertEquals(
            4,
            Cart::where('user_id', $user->id)->where('book_id', $book->id)->value('quantity')
        );
        $this->assertEquals(4, session('cart')[$book->id]['quantity']);
    }

    public function add_to_cart_session($book)
    {
        $this->post(route('cart.store', $book->id))
            ->assertSessionHas("cart.{$book->id}");
        $this->assertCount(1, session('cart'));
    }

    public function add_to_cart_table($book, $user)
    {
        $this->post(route('cart.store', $book->id))
            ->assertSuccessful();
        $this->assertEquals(
            1,
            Cart::where('user_id', $user->id)->where('book_id', $book->id)->value('quantity')
        );
    }

    public function test_guest_can_update_book_quantity_in_cart_page()
    {
        $book = Book::factory()->create();

        $this->add_to_cart_session($book);

        $this->patch(route('cart.update', $book->id) . '?qty=2')
            ->assertSuccessful();
        $this->assertEquals(2, session('cart')[$book->id]['quantity']);
    }

    public function test_auth_user_cannot_select_more_than_stock_quantity()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $book = Book::factory()->create(['stock_count' => 5]);

        $this->add_to_cart_table($book, $user);

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

        $this->add_to_cart_session($book);

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

        $this->add_to_cart_table($book, $user);

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

        $this->add_to_cart_session($book);

        $this->delete(route('cart.destroy', $book->id))
            ->assertSessionMissing("cart.{$book->id}");
        $this->assertCount(0, session('cart'));
    }

    public function test_guest_cannot_save_item_for_later()
    {
        $book = Book::factory()->create();

        $this->add_to_cart_session($book);

        $this->post(route('saveforlater', $book->id))
            ->assertSessionMissing("saveforlater.{$book->id}")
            ->assertSessionHas("cart.{$book->id}");
    }

    public function test_authenticated_user_can_save_item_for_later()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $book = Book::factory()->create();

        $this->add_to_cart_table($book, $user);

        $this->post(route('saveforlater', $book->id));

        $this->assertDatabaseHas('saveforlaters', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);
        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);
    }
}
