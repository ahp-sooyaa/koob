<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CouponTest extends TestCase
{
    public function test_authenticated_user_can_apply_valid_coupon_code()
    {
        //
    }

    public function test_authenticated_user_cannot_apply_invalid_coupon_code()
    {
        //
    }

    public function test_authenticated_user_cannot_apply_expired_coupon_code()
    {
        //
    }

    public function test_authenticated_user_cannot_apply_same_coupon_code_more_than_once()
    {
        //
    }
}
