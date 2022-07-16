<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Cart;
use App\Models\User;
use App\Notifications\OrderPlaced;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function validate_checkout_form($column)
    {
        $this->actingAs(User::factory()->create());

        $checkoutForm = [
            'contact_name' => 'last name',
            'contact_email' => 'email@email.com',
            'address' => 'address',
            'city' => 'city',
            'state' => 'state',
            'zip_code' => '12345',
        ];

        unset($checkoutForm[$column]);

        return $this->post(route('orders.store', $checkoutForm))
                    ->assertSessionHasErrors($column);
    }

    public function test_guest_cannot_view_checkout_page()
    {
        $this
            ->get(route('checkout.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_cannot_view_checkout_page_without_cart_items()
    {
        $user = User::factory()->create();
//        $book = Book::factory()->create(['stock_count' => 0]);
        $this->actingAs($user);

        $this
            ->get(route('checkout.index'))
            ->assertRedirect(route('books.index'));

//        session()->put("cart.{$book->id}", [
//            'id' => $book->id,
//            'title' => $book->title,
//            'quantity' => 1,
//            'price' => $book->price,
//        ]);
//
//        $this
//            ->get(route('checkout.index'))
//            ->assertRedirect(route('books.index'));
    }

    public function test_authenticated_user_can_view_checkout_page_with_cart_items()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $this->actingAs($user);

        $this->post(route('cart.store', $book->id));

        $this
            ->get(route('checkout.index'))
            ->assertSuccessful();
    }

    public function test_order_requires_contact_name()
    {
        $this->validate_checkout_form('contact_name');
    }

    public function test_order_requires_contact_email()
    {
        $this->validate_checkout_form('contact_email');
    }

    public function test_order_requires_address()
    {
        $this->validate_checkout_form('address');
    }

    public function test_order_requires_city()
    {
        $this->validate_checkout_form('city');
    }

    public function test_order_requires_state()
    {
        $this->validate_checkout_form('state');
    }

    public function test_order_requires_zip_code()
    {
        $this->validate_checkout_form('zip_code');
    }

    // what about payment card number, cvc etc.

    public function test_user_can_place_order_successfully()
    {
        Notification::fake();
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $book = Book::factory()->create();
        $this->actingAs($user);

        $this
            ->post(route('cart.store', $book->id))
            ->assertSuccessful()
            ->assertSessionHas("cart.{$book->id}");

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);

        $checkoutForm = [
            'contact_name' => 'first name',
            'contact_email' => 'email@email.com',
            'address' => 'address',
            'city' => 'city',
            'state' => 'state',
            'zip_code' => '12345',
            'amount' => '1999',
            'payment_method_id' => 'pm_card_visa',
            'cart' => '[{"id": 1, "title": "test", "quantity": 1, "price": 1000}]',
        ];

        $this->post(route('orders.store', $checkoutForm))
            ->assertSuccessful();

        // deducted stock count of placed order book
        $this->assertEquals(9, $book->fresh()->stock_count);

        // remove from cart table
        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);

        // saved to order table
        $this->assertEquals(1, $user->orders->count());

        // sent notification to admin
        Notification::assertSentTo($admin, OrderPlaced::class);
    }
}
