<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_all_books()
    {
        [$bookA, $bookB, $bookC] = Book::factory(3)->create();

        $this
            ->get(route('books.index'))
            ->assertSuccessful()
            ->assertSee($bookA->title)
            ->assertSee($bookB->title)
            ->assertSee($bookC->title);
    }

    public function test_user_can_view_book_detail()
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
            ->get("/books?category=$category->slug&page=")
            ->assertSee($bookInCategory->title)
            ->assertDontSee($bookNotInCategory->title);
    }

    public function test_user_can_search_book_by_title()
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
            ->get("books?sort=price,asc")
            ->assertSeeInOrder([
                $bookWithLowerPrice->title,
                $bookWithHigherPrice->title,
            ]);

        $this
            ->get("books?sort=price,desc")
            ->assertSeeInOrder([
                $bookWithHigherPrice->title,
                $bookWithLowerPrice->title,
            ]);
    }

    public function test_user_can_sort_books_by_date()
    {
        $newBook = Book::factory()->create(['created_at' => Carbon::today()]);
        $oldBook = Book::factory()->create(['created_at' => Carbon::yesterday()]);

        $this
            ->get("books?sort=created_at,asc")
            ->assertSeeInOrder([
                $oldBook->title,
                $newBook->title
            ]);

        $this
            ->get("books?sort=created_at,desc")
            ->assertSeeInOrder([
                $newBook->title,
                $oldBook->title
            ]);
    }

    //Todo:
    // test_user_can_add_review_and_rating
    // test_user_can_view_related_book
}
