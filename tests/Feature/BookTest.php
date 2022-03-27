<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_all_books_list()
    {
        $books = Book::factory(3)->create();

        $response = $this->get(route('books.index'));

        $response->assertSuccessful()
            ->assertSee($books[0]->title)
            ->assertSee($books[1]->title)
            ->assertSee($books[2]->title);
    }

    public function test_user_can_see_single_book()
    {
        $book = Book::factory()->create();

        $this->get(route('books.show', $book->id))
            ->assertSee($book->title);
    }
}
