<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\AdSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure a known test user exists with required fields
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '01000000000',
        ]);

        // Optionally create more users
        User::factory(9)->create();

        // Seed sample images first
        $this->call(SampleImagesSeeder::class);
        
        // Seed categories and ads
        $this->call([
            CategorySeeder::class,
            AdSeeder::class,
        ]);
    }
}
