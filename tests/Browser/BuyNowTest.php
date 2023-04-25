<?php

namespace Tests\Browser;

use App\Models\Book;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BuyNowTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testBuyNowGoDirectlyToCheckout()
    {
        Book::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('books.index')
                    ->pause(1000)
                    ->click('@buyNow')
                    ->pause(1000)
                    ->assertRouteIs('login')
                    ->loginAs(User::factory()->create())
                    ->visitRoute('books.index')
                    ->pause(1000)
                    ->click('@buyNow')
                    ->pause(1000)
                    ->assertRouteIs('checkout.index');
        });
    }

    public function testBuyNowSessionIsSeparateWithCart()
    {
        Book::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::factory()->create())
                    ->visitRoute('books.index')
                    ->pause(1000)
                    ->click('@buyNow')
                    ->pause(1000)
                    ->assertSeeIn('@cartItemsCount', 0)
                    ->assertSelected('quantity', 1)
                    ->select('quantity', 3)
                    ->pause(1000)
                    ->assertSeeIn('@cartItemsCount', 0);
        });
    }
}
