<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have users
        if (User::count() === 0) {
            User::factory(15)->create();
        }

        // Ensure we have categories
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        // Get existing users and categories
        $users = User::all();
        $categories = Category::all();

        // Create ads with existing users and categories
        for ($i = 0; $i < 60; $i++) {
            Ad::factory()->create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}
