<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_see_login_page(): void
    {
        $this->get(route('login'))->assertOk();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('workspaces.index'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_email_is_case_insensitive(): void
    {
        $user = User::factory()->create(['email' => 'abc@example.com', 'password' => 'password123']);

        $this->post(route('login.post'), [
            'email' => '  ABC@Example.com ',
            'password' => 'password123',
        ])->assertRedirect(route('workspaces.index'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->from(route('login'))->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'sai-mat-khau',
        ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('login_error');

        $this->assertGuest();
    }

    public function test_login_requires_email_and_password(): void
    {
        $this->post(route('login.post'), [])->assertSessionHasErrors(['email', 'password']);
    }

    public function test_login_is_locked_after_too_many_failed_attempts(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('login.post'), ['email' => $user->email, 'password' => 'sai']);
        }

        // Lần thứ 6 dù đúng mật khẩu vẫn bị khóa tạm.
        $this->post(route('login.post'), ['email' => $user->email, 'password' => 'password123'])
            ->assertSessionHasErrors('login_error');

        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_and_returns_to_intended_url_after_login(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->get(route('account.edit'))->assertRedirect(route('login'));

        $this->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('account.edit'));
    }

    public function test_guest_ajax_request_gets_401_json(): void
    {
        $this->getJson(route('account.edit'))->assertUnauthorized();
    }

    public function test_authenticated_user_is_redirected_away_from_guest_pages(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('login'))->assertRedirect(route('workspaces.index'));
        $this->get(route('register'))->assertRedirect(route('workspaces.index'));
        $this->get(route('password.request'))->assertRedirect(route('workspaces.index'));
    }

    public function test_user_can_logout(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('logout'))->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
