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
        $book = Book::factory()->create(['stock_count' => '5']);

        $this->browse(function (Browser $browser) {
            $browser
                ->visitRoute('books.index')
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

//    test function for the case stock quantity is deducted when click checkout but right now stock will only
//    be deducted after placed order
//    public function testCheckStockForCheckout()
//    {
//        $book = Book::factory()->create(['stock_count' => '1']);
//        User::factory(2)->create();
//
//        $this->browse(function ($first, $second) use ($book) {
//            $first->loginAs(User::find(1))
//                ->visitRoute('books.index')
//                ->screenshot('shop1')
//                ->press('@addToCart')
//                ->screenshot('addtocart1')
//                ->visitRoute('cart.index')
//                ->screenshot('cart1');
//
//            $second->loginAs(User::find(2))
//                ->visitRoute('books.index')
//                ->screenshot('shop2')
//                ->press('@addToCart')
//                ->pause(1000)
//                ->screenshot('addtocart2')
//                ->visitRoute('cart.index')
//                ->screenshot('cart2')
//                ->press('@checkout')
//                ->pause(1000)
//                ->assertPathIs('/checkout');
//
//            $first->press('@checkout')
//                ->screenshot('checkout1')
//                ->waitForText('Items in your Shopping Cart will always reflect the most recent price and stock quantity.')
//                ->assertSee('Items in your Shopping Cart will always reflect the most recent price and stock quantity.');
//        });
//    }
}
