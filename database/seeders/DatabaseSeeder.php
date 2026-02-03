<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        if (!User::where('email', 'admin@example.com')->exists()) {
            User::factory()->withPersonalTeam()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        if (!User::where('email', 'user@example.com')->exists()) {
            User::factory()->withPersonalTeam()->create([
                'name' => 'Standard User',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]);
        }

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
