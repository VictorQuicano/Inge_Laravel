<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'SuperAdmin',
            'email' => 'test@test.com',
            'email_verified_at' => now(),
            'password' => 'password'
        ]);
        $admin->assignRole('admin');
        $assistant = User::create([
            'name' => 'Assistant',
            'email' => 'assis@test.com',
            'email_verified_at' => now(),
            'password' => 'password'
        ]);
        $assistant->assignRole('assistant');
    }
}
