<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_profile()
    {
        $user = User::factory()->create();

        $this
            ->get(route('profile.show', $user->name))
            ->assertRedirect(route('login'));

        $this->actingAs($user);

        $this
            ->get(route('profile.show', $user->name))
            ->assertSuccessful();
    }

    public function test_authenticated_user_can_update_profile_information()
    {
        $user = User::factory()->create(['name' => 'aung', 'email' => 'aung@email.com' ]);
        $this->actingAs($user);

        $this
            ->get(route('profile.edit'))
            ->assertSuccessful();

        $this->assertEquals('aung', $user->name);

        $this
            ->patch(route('profile.update'), [
                'name' => 'updated name',
                'email' => 'updated@email.com'
            ])
            ->assertRedirect(route('profile.edit'));

        $this->assertEquals('updated name', $user->name);
    }

    public function test_authenticated_user_can_update_profile_photo_image()
    {
        Storage::fake();
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('profile_photo.jpeg');

        $this
            ->patch(route('profile.update'), [
                'name' => $user->name,
                'email' => $user->email,
                'profile_photo' => $file
            ])
            ->assertSessionHasNoErrors();

        Storage::assertExists('profile-photos/' . $file->hashName());

        $file = UploadedFile::fake()->create('test.pdf');

        $this
            ->patch(route('profile.update'), [
                'name' => $user->name,
                'email' => $user->email,
                'profile_photo' => $file
            ])
            ->assertSessionHasErrors(['profile_photo']);
    }

    public function test_profile_edit_form_require_name_and_email()
    {
        $this->actingAs(User::factory()->create());

        $this
            ->patch(route('profile.update'))
            ->assertSessionHasErrors(['name', 'email']);
    }

    public function test_profile_edit_form_require_valid_email_format_and_unique()
    {
        $user = User::factory()->create(['email' => 'aung@email.com']);
        $this->actingAs($user);

        $otherUser =  User::factory()->create(['email' => 'other@email.com']);

        $this
            ->patch(route('profile.update'), [
                'name' => 'updated name',
                'email' => 'testemail'
            ])
            ->assertSessionHasErrors('email');
        $this
            ->patch(route('profile.update'), [
                'name' => 'updated name',
                'email' => 'other@email.com'
            ])
            ->assertSessionHasErrors('email');
        $this
            ->patch(route('profile.update'), [
                'name' => 'updated name',
                'email' => 'aung@email.com'
            ])
            ->assertRedirect();
    }

    public function test_password_edit_form_require_all_fields()
    {
        $this->actingAs(User::factory()->create());

        $this
            ->patch(route('profile-password.update'))
            ->assertSessionHasErrors(['current_password', 'password']);
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
