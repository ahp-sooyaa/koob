<?php

namespace Tests\Browser;

use App\Models\Book;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReviewTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testReviewAndRatingCRUD()
    {
        $book = Book::factory()->create();
        User::factory()->create(['email' => 'test@example.com', 'password' => bcrypt('password')]);

        $this->browse(function (Browser $browser) use ($book) {
            $browser->visitRoute('books.show', $book->slug)
                    ->pause(1000)
                    ->assertSee('Please login first to give review & rating.')
                    ->clickLink('login')
                    ->pause(1000)
                    ->assertRouteIs('login')
                    ->type('email', 'test@example.com')
                    ->type('password', 'password')
                    ->press('LOG IN')
                    ->pause(1000)
                    ->assertRouteIs('profile.edit')
                    ->visitRoute('books.show', $book->slug)
                    ->assertSee('SUBMIT REVIEW')
                    ->click('@rating-3')
                    ->type('review', 'This is a review')
                    ->press('SUBMIT REVIEW')
                    ->pause(1000)
                    ->assertSee('Successfully submitted your review & rating.')
                    ->click('@rating-5')
                    ->type('review', 'This is a updated review')
                    ->press('UPDATE REVIEW')
                    ->pause(1000)
                    ->assertSee('Successfully updated your review & rating.')
                    ->click('@delete-review-1')
                    ->pause(1000)
                    ->assertSee('Successfully deleted your review & rating.');
        });
    }

    public function testUserCannotSeeUnapprovedReviews()
    {
        $book = Book::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        $this->browse(function (Browser $first, Browser $second) use ($book, $admin) {
            $first->loginAs(User::factory()->create())
                    ->visitRoute('books.show', $book->slug)
                    ->pause(1000)
                    ->click('@rating-3')
                    ->type('review', 'This is a review')
                    ->press('SUBMIT REVIEW')
                    ->pause(1000);

            $second->visitRoute('books.show', $book->slug)
                    ->pause(1000)
                    ->assertDontSee('This is a review')
                    ->assertSee('Woh! No Rating Yet.');

            $first->loginAs($admin->id)
                    ->visitRoute('books.show', $book->slug)
                    ->pause(1000)
                    ->assertSee('This is a review')
                    ->click('@approve-review-1');

            $second->visitRoute('books.show', $book->slug)
                    ->pause(1000)
                    ->assertSee('This is a review')
                    ->assertDontSee('Woh! No Rating Yet.');
        });
    }
}
