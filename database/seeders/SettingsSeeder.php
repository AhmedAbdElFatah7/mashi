<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'title' => 'موقع الإعلانات المبوبة',
            'description' => 'أفضل موقع للإعلانات المبوبة في المملكة العربية السعودية. نوفر منصة آمنة وسهلة للبيع والشراء.',
            'logo' => null
        ]);
    }
}
