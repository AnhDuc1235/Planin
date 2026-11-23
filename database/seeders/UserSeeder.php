<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * 1 quản trị viên + 10 người dùng thường (mật khẩu: config('planin.seed_password')).
     */
    public function run(): void
    {
        $password = config('planin.seed_password', 'password123');

        // 1 Quản trị viên
        User::factory()->admin()->create([
            'name' => 'Quản trị viên Hệ thống',
            'email' => 'admin@example.com',
            'password' => $password,
        ]);

        // 10 người dùng thường: 1 tài khoản cố định + 9 tài khoản ngẫu nhiên
        User::factory()->create([
            'name' => 'Nguyễn Văn Thành Viên',
            'email' => 'member@example.com',
            'password' => $password,
        ]);

        User::factory()->count(9)->create([
            'password' => $password,
        ]);
    }
}
