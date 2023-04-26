<?php

namespace Tests\Browser;

use App\Models\Book;
use App\Models\User;
use App\Models\Coupon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CouponTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUserCannotUseCouponWhenRequirementDoesntMeet()
    {
        Book::factory()->create();
        $user = User::factory()->create();
        $expiredCoupon = Coupon::factory()->create(['expired_at' => now()->subDay()]);
        $appliedCoupon = Coupon::factory()->hasAttached(
            $user,
            ['isApplied' => 1]
        )->create(['expired_at' => now()->addDay()]);

        $this->browse(function (Browser $browser) use ($user, $expiredCoupon, $appliedCoupon) {
            $browser
                ->loginAs($user)
                ->visitRoute('books.index')
                ->pause(1000)
                ->click('@buyNow')
                ->pause(1000)
                ->type('coupon_code', 'invalid')
                ->pause(1000)
                ->click('@apply')
                ->pause(1000)
                ->screenshot('coupon') 
                ->assertSee('This code is not from us.')
                ->type('coupon_code', $expiredCoupon->code)
                ->pause(1000)
                ->click('@apply')
                ->pause(1000)
                ->assertSee("You can't use this coupon anymore")
                ->type('coupon_code', $appliedCoupon->code)
                ->pause(1000)
                ->click('@apply')
                ->pause(1000)
                ->assertSee("You've already used this coupon");
        });
    }

    public function testPriceCalculateCorrectlyAfterCouponApplied()
    {
        $book = Book::factory()->create();
        $fixedDiscountCoupon = Coupon::factory()->create([
            'expired_at' => now()->addDay(),
            'type' => 'Fixed',
            'value' => 10,
        ]);
        $percentageDiscountCoupon = Coupon::factory()->create([
            'expired_at' => now()->addDay(),
            'type' => 'Percentage',
            'value' => 10,
        ]);

        $fixedAmount = 100 * ($book->price / 100 - $fixedDiscountCoupon->value);
        $percentageAmount = $book->price - $book->price * ($percentageDiscountCoupon->value / 100);

        $this->browse(function (Browser $browser) use ($fixedDiscountCoupon, $percentageDiscountCoupon, $fixedAmount, $percentageAmount) {
            $browser
                ->loginAs(User::factory()->create())
                ->visitRoute('books.index')
                ->pause(1000)
                ->click('@buyNow')
                ->pause(1000)
                ->type('coupon_code', $fixedDiscountCoupon->code)
                ->pause(1000)
                ->click('@apply')
                ->pause(1000)
                ->assertSee('Coupon applied successfully')
                ->assertSee(number_format($fixedAmount / 100, 2))
                ->click('@removeCoupon')
                ->pause(1000)
                ->type('coupon_code', $percentageDiscountCoupon->code)
                ->pause(1000)
                ->click('@apply')
                ->pause(1000)
                ->assertSee('Coupon applied successfully')
                ->assertSee(number_format($percentageAmount / 100, 2));
        });
    }
}
