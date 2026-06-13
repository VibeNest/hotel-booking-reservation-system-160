<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'phone' => '0123456789',
                'address' => 'Hưng Yên',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'status' => '1',
            ]
        );

        // Instructor
        DB::table('users')->updateOrInsert(
            ['email' => 'instructor@gmail.com'],
            [
                'name' => 'Instructor',
                'username' => 'instructor',
                'phone' => '0123456789',
                'address' => 'Hưng Yên',
                'password' => Hash::make('12345678'),
                'role' => 'instructor',
                'status' => '1',
            ]
        );

        // User
        DB::table('users')->updateOrInsert(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'username' => 'user',
                'phone' => '0123456789',
                'address' => 'Hưng Yên',
                'password' => Hash::make('12345678'),
                'role' => 'user',
                'status' => '1',
            ]
        );
    }
}
