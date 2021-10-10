<?php

namespace Tests\Feature\Auth;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_all_books_list()
    {
        // arrange books
        $books = Book::factory(3)->create();

        // act
        $response = $this->get('/books');

        // assert
        $response->assertStatus(200)
            ->assertSee($books[0]->title)
            ->assertSee($books[1]->title)
            ->assertSee($books[2]->title);

        $this->assertCount(3, $books);
    }
}
