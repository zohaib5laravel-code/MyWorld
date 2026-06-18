<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123123123'),
                
                'email_verified_at' => now(),
           ]
        );


    }
}
