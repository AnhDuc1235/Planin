<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_page_renders(): void
    {
        $this->get(route('password.request'))->assertOk();
    }

    public function test_reset_link_is_sent_to_existing_user(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_unknown_email_gets_same_message_and_no_notification(): void
    {
        Notification::fake();

        $this->post(route('password.email'), ['email' => 'khong-ton-tai@example.com'])
            ->assertSessionHas('status');

        Notification::assertNothingSent();
    }

    public function test_reset_page_renders_with_token(): void
    {
        $this->get(route('password.reset', ['token' => 'abc', 'email' => 'a@example.com']))
            ->assertOk()
            ->assertSee('a@example.com');
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::factory()->create(['password' => 'matkhaucu1']);
        $token = Password::createToken($user);

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'matkhaumoi1',
            'password_confirmation' => 'matkhaumoi1',
        ])->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $this->assertTrue(Hash::check('matkhaumoi1', $user->fresh()->password));
    }

    public function test_password_cannot_be_reset_with_invalid_token(): void
    {
        $user = User::factory()->create(['password' => 'matkhaucu1']);

        $this->post(route('password.update'), [
            'token' => 'token-sai',
            'email' => $user->email,
            'password' => 'matkhaumoi1',
            'password_confirmation' => 'matkhaumoi1',
        ])->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('matkhaucu1', $user->fresh()->password));
    }

    public function test_reset_validates_new_password(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'ngan',
            'password_confirmation' => 'ngan',
        ])->assertSessionHasErrors('password');
    }
}
