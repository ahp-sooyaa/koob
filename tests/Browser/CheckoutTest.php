<?php

namespace Tests\Browser;

use App\Models\Book;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CheckoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUserHaveToLoginToCheckout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('checkout.index')
                    ->pause(1000)
                    ->assertRouteIs('login');
        });
    }

    // public function testUserCanCheckout()
    // {
    //     Book::factory()->create();
    //     $user = User::factory()->create();

    //     $this->browse(function (Browser $browser) use ($user) {
    //         $browser->loginAs($user)
    //                 ->visitRoute('books.index')
    //                 ->press('@addToCart')
    //                 ->pause(1000)
    //                 ->visitRoute('cart.index')
    //                 ->screenshot('cart')
    //                 ->pause(1000)
    //                 ->visitRoute('checkout.index')
    //                 ->screenshot('checkout')
    //                 ->pause(1000)
    //                 ->type('label', 'home')
    //                 ->type('building', 'building')
    //                 ->type('street', 'street')
    //                 ->type('township', 'padauk')
    //                 ->type('city', 'yangon')
    //                 ->type('state', 'yangon')
    //                 ->pause(3000)
    //                 ->withinFrame('.__PrivateStripeElement iframe', function ($browser) {
    //                     $browser
    //                     ->type('[placeholder="Card number"]', '4242424242424242')
    //                     ->type('[placeholder="MM / YY"]', '0923')
    //                     ->type('[placeholder="CVC"]', '123')
    //                     ->type('[placeholder="ZIP"]', '12345');
    //                 })
    //                 ->press('Pay Now')
    //                 ->waitForText('Thank you for your purchase')
    //                 ->assertPathBeginsWith('/thankyou')
    //                 ->screenshot('thankyou');
    //     });
    // }

    public function testUserCanNotSelectMoreThanAvailableStock()
    {
        $book = Book::factory()->create(['stock_count' => '5']);

        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(User::factory()->create())
                ->visitRoute('books.index')
                ->press('@addToCart')
                ->pause(1000)
                ->visitRoute('cart.index')
                ->click('@checkout')
                ->pause(1000)
                ->select('quantity', '7')
                ->waitForText('Sorry, we only have 5 items in stock.')
                ->assertSee('Sorry, we only have 5 items in stock.')
                ->select('quantity', '5')
                ->waitForText('Successfully updated')
                ->assertSee('Successfully updated');
        });
    }
}
