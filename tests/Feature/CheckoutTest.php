<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_render_checkout_screen()
    {
        $this->get(route('checkout.index'))
            ->assertRedirect(route('login'));

        $book = Book::factory()->create();

        session()->put("cart.{$book->id}", [
            'id' => $book->id,
            'title' => $book->title,
            'quantity' => 1,
            'price' => $book->price,
        ]);

        $this->get(route('checkout.index'))
                ->assertRedirect(route('login'));
    }

    public function test_auth_user_cannot_render_checkout_screen_without_cart_items()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('checkout.index'))
            ->assertRedirect(route('books.index'));
    }

    public function test_auth_user_can_render_checkout_screen_with_cart_items()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $this->actingAs($user);

        $book = Book::factory()->create();

        session()->put("cart.{$book->id}", [
            'id' => $book->id,
            'title' => $book->title,
            'quantity' => 1,
            'price' => $book->price,
        ]);

        $this->get(route('checkout.index'))
            ->assertSuccessful();
    }

    /**
     * TODO:
     * test_user_cannot_checkout_without_filled_the_form
     * test_order_is_saved_after_checkout_successful
     * test_thankyou_page_is_render_after_checkout_successful
     * test_user_cannot_checkout_if_there_is_exceeded_stock_count_cart_item
     */
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

    public function validate_checkout_form($column)
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $this->actingAs($user);

        $checkoutForm = [
            'contact_name' => 'last name',
            'contact_email' => 'email@email.com',
            'address' => 'address',
            'city' => 'city',
            'state' => 'state',
            'zip_code' => '12345',
        ];

        $column ? $checkoutForm[$column] = null : '';

        return $this->post(route('orders.store', $checkoutForm))
                        ->assertSessionHasErrors($column);
    }

    public function test_deduct_stock_count_after_successfully_placed_order()
    {
        /** @var \App\Models\User */
        $user = User::factory()->create();
        $this->actingAs($user);
        $book = Book::factory()->create();

        $this->post(route('cart.store', $book->id))
            ->assertSuccessful();
        $this->assertEquals(
            1,
            Cart::where('user_id', $user->id)->where('book_id', $book->id)->value('quantity')
        );

        $checkoutForm = [
            'contact_name' => 'first name',
            'contact_email' => 'email@email.com',
            'address' => 'address',
            'city' => 'city',
            'state' => 'state',
            'zip_code' => '12345',
            'amount' => '1999',
            'payment_method_id' => 'pm_card_visa',
            'cart' => '[{"id":1,"user_id":1,"book_id":1,"title":"Nam repellat rerum repudiandae enim.","quantity":1,"price":4818,"created_at":"2022-05-19T14:37:43.000000Z","updated_at":"2022-05-19T14:37:43.000000Z","book":{"id":1,"category_id":1,"slug":"aut-architecto-nobis-autem-quod-accusantium-sint","title":"Nam repellat rerum repudiandae enim.","author":"Mrs. Elisa Raynor","excerpt":"Ratione hic natus veniam. Quasi cum harum reprehenderit voluptatum esse alias accusamus. Rem blanditiis rerum maxime omnis cupiditate ea eius animi. Possimus adipisci laudantium excepturi veritatis voluptatibus.","price":4818,"cover":"/images/cover.png","available_stock_count":4,"stock_count":8,"created_at":"2022-05-19T14:21:50.000000Z","updated_at":"2022-05-19T14:37:47.000000Z"}}]'
        ];

        $this->post(route('orders.store', $checkoutForm))
            ->assertSuccessful();

        $this->assertEquals(9, $book->fresh()->stock_count);
        $this->assertDatabaseMissing('carts', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);
    }
}
