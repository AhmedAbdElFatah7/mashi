<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            ['name' => 'السيارات', 'description' => 'سيارات جديدة ومستعملة للبيع', 'icon' => 'iconoir-car'],
            ['name' => 'العقارات', 'description' => 'شقق وفيلات ومحلات تجارية', 'icon' => 'iconoir-home'],
            ['name' => 'الإلكترونيات', 'description' => 'أجهزة كمبيوتر وهواتف ذكية', 'icon' => 'iconoir-laptop'],
            ['name' => 'الأثاث', 'description' => 'أثاث منزلي ومكتبي', 'icon' => 'iconoir-sofa'],
            ['name' => 'الملابس', 'description' => 'ملابس رجالية ونسائية وأطفال', 'icon' => 'iconoir-shirt'],
            ['name' => 'الرياضة', 'description' => 'معدات رياضية وألعاب', 'icon' => 'iconoir-basketball'],
            ['name' => 'الكتب', 'description' => 'كتب تعليمية وثقافية', 'icon' => 'iconoir-book'],
            ['name' => 'الحيوانات الأليفة', 'description' => 'حيوانات أليفة ومستلزماتها', 'icon' => 'iconoir-dog'],
        ];

        $category = $this->faker->randomElement($categories);
        
        return [
            'name' => $category['name'],
            'description' => $category['description'],
            'icon' => $category['icon'],
        ];
    }
}
