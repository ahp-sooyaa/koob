<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_all_books_list()
    {
        [$bookA, $bookB, $bookC] = Book::factory(3)->create();

        $this
            ->get(route('books.index'))
            ->assertSuccessful()
            ->assertSee($bookA->title)
            ->assertSee($bookB->title)
            ->assertSee($bookC->title);
    }

    public function test_user_can_see_single_book()
    {
        $book = Book::factory()->create();

        $this
            ->get(route('books.show', $book->slug))
            ->assertSuccessful()
            ->assertSee($book->title);
    }

    public function test_user_can_filter_books_by_categories()
    {
        $category = Category::factory()->create();
        $bookInCategory = Book::factory()->create([
            'category_id' => $category->id
        ]);
        $bookNotInCategory = Book::factory()->create();

        $this
            ->get("/books?filter[category_id]={$category->id}&page=&search=")
            ->assertSee($bookInCategory->title)
            ->assertDontSee($bookNotInCategory->title);
    }

    public function test_user_can_search_book()
    {
        $bookOne = Book::factory()->create();
        $bookTwo = Book::factory()->create();

        $this
            ->get("books?search={$bookOne->title}&page=")
            ->assertSee($bookOne->title)
            ->assertDontSee($bookTwo->title);
    }

    public function test_user_can_sort_books_by_price()
    {
        $bookWithHigherPrice = Book::factory()->create(['price' => '2000']);
        $bookWithLowerPrice = Book::factory()->create(['price' => '1000']);

        $this
            ->get("books?sort[price]=asc")
            ->assertSeeInOrder([
                $bookWithLowerPrice->title,
                $bookWithHigherPrice->title,
            ]);

        $this
            ->get("books?sort[price]=desc")
            ->assertSeeInOrder([
                $bookWithHigherPrice->title,
                $bookWithLowerPrice->title,
            ]);
    }
}
