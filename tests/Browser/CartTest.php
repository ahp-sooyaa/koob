<?php

namespace Tests\Browser;

use App\Models\Book;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CartTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function tearDown():void
    {
        foreach (static::$browsers as $b) {
            $b->driver->manage()->deleteAllCookies();
        }
        parent::tearDown();
    }

    public function testUserCanAddProductsToCart()
    {
        $book = Book::factory()->create();

        $this->browse(function (Browser $browser) use ($book) {
            $browser->visitRoute('books.index')
                    ->pause(1000)
                    ->click('@addToCart')
                    ->pause(1000)
                    ->assertSeeIn('@cartItemsCount', 1)
                    ->assertSee('Successfully added to cart.')
                    ->click('@addToCart')
                    ->pause(1000)
                    ->assertSeeIn('@cartItemsCount', 2)
                    ->assertSee('Successfully added to cart.')
                    ->visitRoute('cart.index')
                    ->assertSee($book->title)
                    ->assertSelected('quantity', 2);
        });
    }

    public function testUserCanRemoveCartItems()
    {
        Book::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('books.index')
                    ->pause(1000)
                    ->click('@addToCart')
                    ->pause(1000)
                    ->visitRoute('cart.index')
                    ->click('@removeFromCart')
                    ->pause(1000)
                    ->assertSeeIn('@cartItemsCount', 0)
                    ->assertSee('Successfully removed from cart.');
        });
    }

    public function testUserCanUpdateCartItemsQuantity()
    {
        Book::factory()->create(['stock_count' => 3]);

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('books.index')
                    ->pause(1000)
                    ->click('@addToCart')
                    ->pause(1000)
                    ->visitRoute('cart.index')
                    ->select('quantity', 3)
                    ->pause(1000)
                    ->assertSeeIn('@cartItemsCount', 3)
                    ->assertSee('Successfully updated cart quantity.')
                    ->select('quantity', 5)
                    ->pause(1000)
                    ->assertSee('Sorry, we only have 3 items in stock.');
        });
    }

    public function testCartSummaryShowCorrectPrice()
    {
        $book = Book::factory()->create();

        $this->browse(function (Browser $browser) use ($book) {
            $browser->visitRoute('books.index')
                    ->pause(1000)
                    ->click('@addToCart')
                    ->pause(1000)
                    ->visitRoute('cart.index')
                    ->pause(1000)
                    ->assertSeeIn('@cartTotal', '$'.number_format($book->price / 100, 2))
                    ->select('quantity', 3)
                    ->pause(1000)
                    ->assertSeeIn('@cartTotal', '$'.number_format(($book->price * 3) / 100, 2));
        });
    }
}
