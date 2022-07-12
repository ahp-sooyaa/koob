<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_see_own_profile()
    {
        $user = User::factory()->create();

        $this->get(route('profile.index'))
            ->assertRedirect(route('login'));

        $this->actingAs($user);

        $this->get(route('profile.index'))
            ->assertSuccessful();
    }

    public function test_user_can_update_profile_information()
    {
        $user = User::factory()->create(['name' => 'aung', 'email' => 'aung@email.com' ]);
        $this->actingAs($user);

        $this->get(route('profile.edit'))
            ->assertSuccessful();

        $this->assertEquals('aung', $user->name);

        $this->patch(route('profile.update'), ['name' => 'updated name', 'email' => 'updated@email.com'])
            ->assertRedirect(route('profile.edit'));

        $this->assertEquals('updated name', $user->name);
    }

    public function test_profile_update_form_require_name_and_email()
    {
        $this->actingAs(User::factory()->create());

        $this->patch(route('profile.update'))
            ->assertSessionHasErrors(['name', 'email']);
    }

    public function test_profile_update_form_require_valid_email_format_and_unique()
    {
        $user = User::factory()->create(['email' => 'aung@email.com']);
        $this->actingAs($user);

        $otherUser =  User::factory()->create(['email' => 'other@email.com']);

        $this->patch(route('profile.update'), ['name' => 'updated name', 'email' => 'testemail'])
            ->assertSessionHasErrors('email');
        $this->patch(route('profile.update'), ['name' => 'updated name', 'email' => 'other@email.com'])
            ->assertSessionHasErrors('email');
        $this->patch(route('profile.update'), ['name' => 'updated name', 'email' => 'aung@email.com'])
            ->assertRedirect();
    }

    public function test_user_can_update_password()
    {
        $user = User::factory()->create(['email' => 'aung@email.com']);
        $this->actingAs($user);

        $attributes = [
            'current_password' => 'password',
            'password' => 'updatedpassword',
            'password_confirmation' => 'updatedpassword'
        ];

        $this->assertTrue(Hash::check('password', $user->password));

        $this
            ->patch(route('profile-password.update'), $attributes)
            ->assertRedirect();

        $this->assertTrue(Hash::check('updatedpassword', $user->fresh()->password));
    }
}
