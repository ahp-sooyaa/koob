<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Cart;
use App\Models\SaveForLater;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_cart_page()
    {
        $this
            ->get(route('cart.index'))
            ->assertSuccessful();
    }

    public function test_user_can_view_all_shopping_cart_items()
    {
        [$bookA, $bookB] = Book::factory(2)->create();

        session()->put("cart.{$bookA->id}", [
            'id' => $bookA->id,
            'title' => $bookA->title,
            'quantity' => 1,
            'price' => $bookA->price,
        ]);

        session()->put("cart.{$bookB->id}", [
            'id' => $bookB->id,
            'title' => $bookB->title,
            'quantity' => 1,
            'price' => $bookB->price,
        ]);

        $this
            ->get(route('cart.index'))
            ->assertSee($bookA->title)
            ->assertSee($bookB->title);
    }

    public function test_user_can_add_book_to_cart_with_single_quantity()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->assertEmpty(session('cart'));

        $this
            ->post(route('cart.store', $book->id))
            ->assertSuccessful();

        $this->assertEquals(1, session("cart.{$book->id}.quantity"));
        $this->assertEquals($book->title, session("cart.{$book->id}.title"));
        $this->assertDatabaseCount('carts', 0);

        $this->actingAs($user);

        $this
            ->post(route('cart.store', $book->id))
            ->assertSuccessful();

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => 1,
        ]);
    }

    // for "Add to cart" action in  book detail page
    public function test_user_can_add_book_to_cart_with_multiple_quantity()
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->assertEmpty(session('cart'));

        $this
            ->post(route('cart.store', $book->id), ['qty' => 5])
            ->assertSuccessful();

        $this->assertEquals(5, session("cart.{$book->id}.quantity"));
        $this->assertEquals($book->title, session("cart.{$book->id}.title"));
        $this->assertDatabaseCount('carts', 0);

        $this->actingAs($user);

        $this
            ->post(route('cart.store', $book->id))
            ->assertSuccessful();

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }

    public function test_user_can_remove_book_from_cart()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        Cart::factory()->create(['book_id' => $book->id]);

        $this->post(route('cart.store', $book->id));

        $this->assertCount(1, session('cart'));

        $this
            ->delete(route('cart.destroy', $book->id))
            ->assertSuccessful();

        $this->assertCount(0, session("cart"));

        $this->actingAs($user);

        $this->post(route('cart.store', $book->id));

        $this->assertCount(1, session('cart'));

        $this
            ->delete(route('cart.destroy', $book->id))
            ->assertSuccessful();

        $this->assertCount(0, session("cart"));
        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }

    public function test_user_can_update_cart_item_quantity()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        session()->put("cart.{$book->id}", [
            'id' => $book->id,
            'title' => $book->title,
            'quantity' => 1,
            'price' => $book->price,
        ]);

        $this
            ->patch(route('cart.update', $book->id), ['qty' => 5])
            ->assertSuccessful();

        $this->assertEquals(5, session("cart.{$book->id}.quantity"));

        $this->actingAs($user);

        $this->post(route('cart.store', $book->id));

        $this
            ->patch(route('cart.update', $book->id), ['qty' => 3])
            ->assertSuccessful();

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => 3,
        ]);
    }

    public function test_cart_item_quantity_increase_if_already_existed()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this
            ->post(route('cart.store', $book->id))
            ->assertSessionHas("cart.{$book->id}");
        $this->assertCount(1, session('cart'));
        $this->assertEquals(1, session("cart.{$book->id}.quantity"));

        $this->post(route('cart.store', $book->id));
        $this->assertCount(1, session('cart'));
        $this->assertEquals(2, session("cart.{$book->id}.quantity"));

        $this->actingAs($user);

        $this
            ->post(route('cart.store', $book->id))
            ->assertSuccessful();

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => 1,
        ]);

        $this
            ->post(route('cart.store', $book->id))
            ->assertSuccessful();

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => 2,
        ]);
    }

    public function test_user_cannot_select_more_than_stock_quantity()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['stock_count' => 5]);
        Cart::factory()->create(['book_id' => $book->id, 'user_id' => $user->id]);

        session()->put("cart.{$book->id}", [
            'id' => $book->id,
            'title' => $book->title,
            'quantity' => 1,
            'price' => $book->price,
        ]);

        $this
            ->patch(route('cart.update', $book->id), ['qty' => 5])
            ->assertSuccessful();

        $this
            ->patch(route('cart.update', $book->id), ['qty' => 10])
            ->assertUnprocessable();

        $this->actingAs($user);

        $this
            ->patch(route('cart.update', $book->id), ['qty' => 3])
            ->assertSuccessful();

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => 3,
        ]);

        $this
            ->patch(route('cart.update', $book->id), ['qty' => 10])
            ->assertUnprocessable();
    }

    public function test_guest_cannot_save_item_for_later()
    {
        $book = Book::factory()->create();

        session()->put("cart.{$book->id}", [
            'id' => $book->id,
            'title' => $book->title,
            'quantity' => 1,
            'price' => $book->price,
        ]);

        $this
            ->post(route('saveForLater.store', $book->id))
            ->assertSessionMissing("saveforlater.{$book->id}")
            ->assertSessionHas("cart.{$book->id}");
    }

    public function test_authenticated_user_can_save_cart_item_for_later()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        Cart::factory()->create(['book_id' => $book->id, 'user_id' => $user->id]);

        $this->actingAs($user);

        $this
            ->post(route('saveForLater.store', $book->id))
            ->assertSuccessful();

        $this->assertDatabaseHas('save_for_later_items', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);

        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }

    public function test_authenticated_user_can_move_saved_items_to_cart()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        SaveForLater::factory()->create(['book_id' => $book->id, 'user_id' => $user->id]);

        $this->actingAs($user);

        $this
            ->post(route('moveToCart', $book->id))
            ->assertSuccessful();

        $this->assertDatabaseMissing('save_for_later_items', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }

    public function test_over_stock_cart_items_quantity_are_updated_when_visit_cart_page()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['stock_count' => 3]);
        $this->actingAs($user);

        session()->put("cart.{$book->id}", [
            'id' => $book->id,
            'title' => $book->title,
            'quantity' => 5,
            'price' => $book->price,
        ]);
        Cart::factory()->create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'quantity' => 5,
        ]);

        $this
            ->get(route('cart.index'))
            ->assertSuccessful();

        $this->assertEquals(3, session("cart.{$book->id}.quantity"));
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'quantity' => 3,
        ]);
    }

    public function test_not_available_cart_items_are_moved_to_save_for_later_list()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['stock_count' => 0]);
        $this->actingAs($user);

        session()->put("cart.{$book->id}", [
            'id' => $book->id,
            'title' => $book->title,
            'quantity' => 5,
            'price' => $book->price,
        ]);
        Cart::factory()->create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'quantity' => 5,
        ]);

        $this
            ->get(route('cart.index'))
            ->assertSuccessful();

        $this->assertEquals([], session("cart"));
        $this->assertEmpty(session("cart.{$book->id}"));
        $this->assertCount(1, session("saveforlater"));

        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
        $this->assertDatabaseHas('save_for_later_items', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }

    public function test_cart_session_and_database_sync_after_login()
    {
        $user = User::factory()->create();
        [$bookA, $bookB] = Book::factory(2)->create();
        session()->put("cart.{$bookA->id}", [
            'id' => $bookA->id,
            'title' => $bookA->title,
            'slug' => $bookA->slug,
            'quantity' => 5,
            'price' => $bookA->price,
            'cover_url' => $bookA->cover_url,
        ]);
        Cart::factory()->create([
            'user_id' => $user->id,
            'book_id' => $bookB->id,
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $bookA->id,
            'quantity' => 5,
        ]);
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $bookB->id,
        ]);

        $this->assertDatabaseCount('carts', 2);

        $this->assertEquals($bookA->id, session("cart.{$bookA->id}.id"));
        $this->assertEquals($bookB->id, session("cart.{$bookB->id}.id"));
    }

    //Todo:
    // test_authenticated_user_cannot_move_save_for_later_items_to_cart_if_not_available
    // test_user_can_not_add_out_of_stock_book_to_cart
    // test_authenticated_user_can_buy_book_now
    // test_guest_user_can_not_buy_book_now
    // test_guest_user_can_not_add_book_to_wish_list
}
