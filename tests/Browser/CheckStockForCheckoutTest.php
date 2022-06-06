<?php

namespace Tests\Browser;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CheckStockForCheckoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUserCanNotSelectMoreThanAvailableStock()
    {
        $book = Book::factory()->create(['available_stock_count' => '5']);

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('books.index')
                    ->press('@addToCart')
                    ->pause(1000)
                    ->visitRoute('cart.index')
                    ->screenshot('cart')
                    ->select('quantity', '7')
                    ->waitForText('Quantity is exceeding over available stock. Available quantity(5)')
                    ->assertSee('Quantity is exceeding over available stock. Available quantity(5)')
                    ->screenshot('selectedQuantity')
                    ->select('quantity', '5')
                    ->waitForText('Successfully updated')
                    ->assertSee('Successfully updated');
        });
    }

    public function testCheckStockForCheckout()
    {
        $book = Book::factory()->create(['available_stock_count' => '1']);
        User::factory(2)->create();

        $this->browse(function ($first, $second) use ($book) {
            $first->loginAs(User::find(1))
                ->visitRoute('books.index')
                ->screenshot('shop1')
                ->press('@addToCart')
                ->screenshot('addtocart1')
                ->visitRoute('cart.index')
                ->screenshot('cart1');

            $second->loginAs(User::find(2))
                ->visitRoute('books.index')
                ->screenshot('shop2')
                ->press('@addToCart')
                ->pause(1000)
                ->screenshot('addtocart2')
                ->visitRoute('cart.index')
                ->screenshot('cart2')
                ->press('@checkout')
                ->pause(1000)
                ->assertPathIs('/checkout');

            $first->press('@checkout')
                ->screenshot('checkout1')
                ->waitForText('Some items in your cart are not available right now and automatically move to save for later.')
                ->assertSee('Some items in your cart are not available right now and automatically move to save for later.');
        });
    }
}
