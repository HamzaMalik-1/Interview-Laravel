<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'isActive' => 1,
            'expire_at' => now()->addDays(30), // ✅ add default expiration
        ]);

         User::create([
            'name' => 'hamza',
            'username' => 'hamza',
            'email' => 'hamza@gmail.com',
            'password' => bcrypt('1'),
            'isActive' => 1,
            'expire_at' => now()->addDays(30), // ✅ add default expiration
        ]);
    }
}
