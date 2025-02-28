<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'id' => 1,
            'name' => 'user',
            'email' => 'user@test.com',
            'password' => bcrypt('user123'),
            'email_verified_at' => time()
        ]);    
    }
}
