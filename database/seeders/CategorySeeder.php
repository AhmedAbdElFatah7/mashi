<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Arabic categories based on SVG icons stored in storage/app/public/categories
        $categories = [
            [
                'name' => 'قصص وحكايات',
                'description' => 'قصص، حكايات، تجارب ومواقف متنوعة',
                'logo' => 'categories/anecdotes.svg',
            ],
            [
                'name' => 'حيوانات',
                'description' => 'حيوانات أليفة ومستلزماتها وطعامها',
                'logo' => 'categories/animals.svg',
            ],
            [
                'name' => 'عقارات ومبانٍ',
                'description' => 'مبانٍ، عقارات، منشآت سكنية وتجارية',
                'logo' => 'categories/buildings.svg',
            ],
            [
                'name' => 'سيارات ومركبات',
                'description' => 'سيارات، مركبات، وسائل نقل للبيع والشراء',
                'logo' => 'categories/car.svg',
            ],
            [
                'name' => 'إلكترونيات وأجهزة',
                'description' => 'هواتف، كمبيوترات، وأجهزة إلكترونية متنوعة',
                'logo' => 'categories/electronics.svg',
            ],
            [
                'name' => 'ملابس وأزياء',
                'description' => 'ملابس، موضة، إكسسوارات للرجال والنساء والأطفال',
                'logo' => 'categories/fashion.svg',
            ],
            [
                'name' => 'طعام ومواد غذائية',
                'description' => 'أطعمة، منتجات غذائية، ومستلزمات المطبخ',
                'logo' => 'categories/food.svg',
            ],
            [
                'name' => 'أثاث وتجهيزات',
                'description' => 'أثاث منزلي ومكتبي وتجهيزات ديكور',
                'logo' => 'categories/furniture.svg',
            ],
            [
                'name' => 'حدائق وزراعة',
                'description' => 'نباتات، أدوات زراعة، وحدائق منزلية',
                'logo' => 'categories/gardens.svg',
            ],
            [
                'name' => 'وظائف وفرص عمل',
                'description' => 'فرص عمل ووظائف في مختلف المجالات',
                'logo' => 'categories/jobs.svg',
            ],
            [
                'name' => 'خدمات متنوعة',
                'description' => 'خدمات مهنية، منزلية، وتعليمية وغير ذلك',
                'logo' => 'categories/services.svg',
            ],
            [
                'name' => 'سفر ورحلات',
                'description' => 'عروض سفر، سياحة، وأنشطة ترفيهية',
                'logo' => 'categories/trips.svg',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
