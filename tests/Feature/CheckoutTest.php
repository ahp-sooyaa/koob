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
        $this->actingAs(User::factory()->create(['id' => 2]));

        $this->get(route('checkout.index'))
            ->assertRedirect(route('books.index'));
    }

    public function test_auth_user_can_render_checkout_screen_with_cart_items()
    {
        $this->actingAs($user = User::factory()->create(['id' => 2]));

        Cart::factory()->create(['user_id' => $user->id]);

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
        $this->actingAs(User::factory()->create());

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

    // public function test_order_is_saved_after_checkout_successful()
    // {
    //     $this->actingAs(User::factory()->create());

    //     $checkoutForm = [
    //         'first_name' => 'first name',
    //         'last_name' => 'last name',
    //         'email' => 'email@email.com',
    //         'address' => 'address',
    //         'city' => 'city',
    //         'state' => 'state',
    //         'zip_code' => '12345',
    //     ];

    //     $this->post(route('orders.store', $checkoutForm))
    //         ->assertSuccessful();
    // }
}
