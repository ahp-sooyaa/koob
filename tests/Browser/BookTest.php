<?php

namespace Tests\Browser;

use App\Models\Book;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BookTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUserCanSeeSingleBook()
    {
        $book = Book::factory()->create();

        $this->browse(function (Browser $browser) use ($book) {
            $browser->visitRoute('books.index')
                    ->pause(1000)
                    ->clickLink($book->title)
                    ->pause(1000)
                    ->assertRouteIs('books.show', $book->slug)
                    ->assertSee($book->title);
        });
    }

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

    public function testUserCanFilterBookByCategory()
    {
        $book1 = Book::factory()->create();
        $book2 = Book::factory()->create();

        $this->browse(function (Browser $browser) use ($book1, $book2) {
            $browser->visitRoute('books.index')
                    ->pause(1000)
                    ->press(Str::headline($book1->category->name))
                    ->pause(1000)
                    ->assertQueryStringHas('category', $book1->category->slug)
                    ->assertSee($book1->title)
                    ->assertDontSee($book2->title)
                    ->press(Str::headline($book2->category->name))
                    ->pause(1000)
                    ->assertQueryStringHas('category', $book2->category->slug)
                    ->assertSee($book2->title)
                    ->assertDontSee($book1->title);
        });
    }

    public function testUserCanFilterBookBySearch()
    {
        Book::factory()->create([
            'title' => 'Book 1',
        ]);
        Book::factory()->create([
            'title' => 'Book 2',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('books.index')
                    ->pause(1000)
                    ->type('search', 'book')
                    ->pause(1000)
                    ->assertQueryStringHas('search', 'book')
                    ->assertSee('Book 1')
                    ->assertSee('Book 2')
                    ->type('search', 'book 2')
                    ->pause(1000)
                    ->assertDontSee('Book 1');
        });
    }
}
