<?php

namespace Tests\Browser;

use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CheckoutTest extends DuskTestCase
{
    // use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUserCanCheckout()
    {
        Book::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('books.index')
                    ->press('@addToCart')
                    ->pause(1000)
                    ->visitRoute('cart.index')
                    ->screenshot('cart')
                    ->pause(1000)
                    ->visitRoute('checkout.index')
                    ->screenshot('checkout')
                    ->type('first_name', 'aung')
                    ->type('last_name', 'paing')
                    ->type('email', 'newuser@email.com')
                    ->type('address', 'padauk')
                    ->type('city', 'yangon')
                    ->type('state', 'yangon')
                    ->type('zip_code', '12345')
                    ->withinFrame('.__PrivateStripeElement iframe', function ($browser) {
                        $browser
                        ->type('[placeholder="Card number"]', '4242424242424242')
                        ->type('[placeholder="MM / YY"]', '0923')
                        ->type('[placeholder="CVC"]', '123')
                        ->type('[placeholder="ZIP"]', '12345');
                    })
                    ->press('Pay Now')
                    ->waitForText('Thank you for your purchase')
                    ->assertPathBeginsWith('/thankyou')
                    ->screenshot('thankyou');
        });
    }
}
