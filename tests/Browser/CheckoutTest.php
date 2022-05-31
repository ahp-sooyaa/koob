<?php

namespace Tests\Browser;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CheckoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUserCanCheckout()
    {
        Book::factory()->create();
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visitRoute('books.index')
                    ->press('@addToCart')
                    ->pause(1000)
                    ->visitRoute('cart.index')
                    ->screenshot('cart')
                    ->pause(1000)
                    ->visitRoute('checkout.index')
                    // ->assertSee('LOG IN')
                    ->screenshot('checkout')
                    // ->type('email', 'aunghtetpaing.mtkn@gmail.com')
                    // ->type('password', 'password')
                    // ->press('@login-button')
                    ->pause(1000)
                    // ->type('contact_name', 'aung')
                    // ->type('contact_email', 'newuser@email.com')
                    ->type('address', 'padauk')
                    ->type('city', 'yangon')
                    ->type('state', 'yangon')
                    ->type('zip_code', '12345')
                    ->pause(3000)
                    ->withinFrame('.__PrivateStripeElement iframe', function ($browser) {
                        $browser
                        ->type('[placeholder="Card number"]', '4242424242424242')
                        ->type('[placeholder="MM / YY"]', '0923')
                        ->type('[placeholder="CVC"]', '123')
                        ->type('[placeholder="ZIP"]', '12345');
                        // ->pause(1000)
                    })
                    ->press('Pay Now')
                    ->waitForText('Thank you for your purchase')
                    ->assertPathBeginsWith('/thankyou')
                    ->screenshot('thankyou');
        });
    }
}
