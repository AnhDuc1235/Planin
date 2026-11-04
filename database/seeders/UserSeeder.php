<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tài khoản Quản trị viên mẫu
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Quản trị viên Hệ thống',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Tài khoản Thành viên mẫu
        User::updateOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Nguyễn Văn Thành Viên',
                'password' => Hash::make('password123'),
                'role' => 'member',
                'email_verified_at' => now(),
            ]
        );
    }
}
