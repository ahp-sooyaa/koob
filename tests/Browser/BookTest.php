<?php

namespace Tests\Browser;

use App\Models\Book;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BookTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUserCanSeeAllBooks()
    {
        $books = Book::factory(3)->create();
        $this->browse(function (Browser $browser) use ($books) {
            $browser->visitRoute('books.index')
                    ->assertSee($books[0]->title)
                    ->assertSee($books[1]->title)
                    ->assertSee($books[2]->title);
        });
    }
}
