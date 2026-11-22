<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    private function validRegistration(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Nguyễn Văn A',
            'email' => 'vana@example.com',
            'password' => 'matkhau123',
            'password_confirmation' => 'matkhau123',
        ], $overrides);
    }

    // ---------------------------- ĐĂNG KÝ ----------------------------

    public function test_user_can_register_and_is_logged_in(): void
    {
        $this->post(route('register.post'), $this->validRegistration())
            ->assertRedirect(route('workspaces.index'));

        $user = User::where('email', 'vana@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('member', $user->role);
        $this->assertTrue(Hash::check('matkhau123', $user->password));
        $this->assertAuthenticatedAs($user);
    }

    public function test_registration_ignores_role_sent_by_client(): void
    {
        $this->post(route('register.post'), $this->validRegistration(['role' => 'admin']));

        $this->assertSame('member', User::where('email', 'vana@example.com')->value('role'));
    }

    public function test_registration_validation_rules(): void
    {
        User::factory()->create(['email' => 'trung@example.com']);

        $this->post(route('register.post'), $this->validRegistration([
            'email' => 'trung@example.com',
        ]))->assertSessionHasErrors('email');

        $this->post(route('register.post'), $this->validRegistration([
            'password' => 'ngan',
            'password_confirmation' => 'ngan',
        ]))->assertSessionHasErrors('password');

        $this->post(route('register.post'), $this->validRegistration([
            'password_confirmation' => 'khac-hoan-toan',
        ]))->assertSessionHasErrors('password');

        $this->post(route('register.post'), [])->assertSessionHasErrors(['name', 'email', 'password']);

        $this->assertGuest();
    }

    // ---------------------------- HỒ SƠ ----------------------------

    public function test_guest_cannot_access_account_pages(): void
    {
        $this->get(route('account.edit'))->assertRedirect(route('login'));
        $this->put(route('account.update'), ['name' => 'X'])->assertRedirect(route('login'));
        $this->put(route('account.password.update'), [])->assertRedirect(route('login'));
    }

    public function test_user_can_view_account_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('account.edit'))
            ->assertOk()
            ->assertSee($user->email);
    }

    public function test_user_can_update_name(): void
    {
        $user = User::factory()->create(['name' => 'Tên cũ']);

        $this->actingAs($user)->put(route('account.update'), ['name' => 'Tên mới'])
            ->assertRedirect(route('account.edit'));

        $this->assertSame('Tên mới', $user->fresh()->name);
    }

    public function test_update_cannot_change_email_or_role(): void
    {
        $user = User::factory()->create(['email' => 'giu@example.com', 'role' => 'member']);

        $this->actingAs($user)->put(route('account.update'), [
            'name' => 'Ten',
            'email' => 'doi@example.com',
            'role' => 'admin',
        ]);

        $fresh = $user->fresh();
        $this->assertSame('giu@example.com', $fresh->email);
        $this->assertSame('member', $fresh->role);
    }

    public function test_user_can_upload_replace_and_remove_avatar(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('account.update'), [
            'name' => $user->name,
            'avatar' => UploadedFile::fake()->image('a.jpg', 200, 200),
        ])->assertSessionHasNoErrors();

        $first = $user->fresh()->avatar;
        $this->assertNotNull($first);
        Storage::disk('public')->assertExists($first);

        // Thay ảnh -> file cũ bị xóa.
        $this->put(route('account.update'), [
            'name' => $user->name,
            'avatar' => UploadedFile::fake()->image('b.png', 200, 200),
        ]);

        $second = $user->fresh()->avatar;
        $this->assertNotSame($first, $second);
        Storage::disk('public')->assertMissing($first);
        Storage::disk('public')->assertExists($second);

        // Xóa ảnh.
        $this->put(route('account.update'), ['name' => $user->name, 'remove_avatar' => '1']);

        $this->assertNull($user->fresh()->avatar);
        Storage::disk('public')->assertMissing($second);
    }

    public function test_avatar_must_be_a_small_raster_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('account.update'), [
            'name' => $user->name,
            'avatar' => UploadedFile::fake()->create('doc.pdf', 10, 'application/pdf'),
        ])->assertSessionHasErrors('avatar');

        $this->put(route('account.update'), [
            'name' => $user->name,
            'avatar' => UploadedFile::fake()->image('lon.jpg', 200, 200)->size(3000), // 3000 KB > 2 MB
        ])->assertSessionHasErrors('avatar');

        $this->assertNull($user->fresh()->avatar);
    }

    // ---------------------------- ĐỔI MẬT KHẨU ----------------------------

    public function test_user_can_change_password(): void
    {
        $user = User::factory()->create(['password' => 'matkhaucu1']);

        $this->actingAs($user)->put(route('account.password.update'), [
            'current_password' => 'matkhaucu1',
            'password' => 'matkhaumoi1',
            'password_confirmation' => 'matkhaumoi1',
        ])->assertRedirect(route('account.edit'))
            ->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('matkhaumoi1', $user->fresh()->password));
    }

    public function test_change_password_requires_correct_current_password(): void
    {
        $user = User::factory()->create(['password' => 'matkhaucu1']);

        $this->actingAs($user)->put(route('account.password.update'), [
            'current_password' => 'sai-roi',
            'password' => 'matkhaumoi1',
            'password_confirmation' => 'matkhaumoi1',
        ])->assertSessionHasErrors('current_password', null, 'updatePassword');

        $this->assertTrue(Hash::check('matkhaucu1', $user->fresh()->password));
    }

    public function test_new_password_must_be_valid_and_different(): void
    {
        $user = User::factory()->create(['password' => 'matkhaucu1']);

        // Quá ngắn
        $this->actingAs($user)->put(route('account.password.update'), [
            'current_password' => 'matkhaucu1',
            'password' => 'ngan',
            'password_confirmation' => 'ngan',
        ])->assertSessionHasErrors('password', null, 'updatePassword');

        // Trùng mật khẩu hiện tại
        $this->put(route('account.password.update'), [
            'current_password' => 'matkhaucu1',
            'password' => 'matkhaucu1',
            'password_confirmation' => 'matkhaucu1',
        ])->assertSessionHasErrors('password', null, 'updatePassword');
    }
}
