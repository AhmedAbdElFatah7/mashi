<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ad>
 */
class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition(): array
    {
        $arabicTitles = [
            'سيارة تويوتا كامري 2020 للبيع',
            'شقة 3 غرف وصالة في الرياض',
            'لابتوب ديل جديد بالكرتونة',
            'طقم صالون مودرن للبيع',
            'فستان زفاف أبيض جديد',
            'دراجة هوائية رياضية',
            'كتب جامعية للبيع',
            'قطة شيرازية أليفة',
            'جهاز آيفون 14 برو ماكس',
            'فيلا دوبلكس في جدة',
            'كاميرا كانون احترافية',
            'طاولة طعام خشبية',
            'حذاء رياضي نايكي',
            'معدات رياضية متنوعة',
            'مجموعة كتب أطفال',
            'كلب جولدن ريتريفر',
        ];

        $arabicDescriptions = [
            'حالة ممتازة، استعمال خفيف، سعر مناسب للجادين فقط',
            'موقع متميز، قريب من الخدمات، إطلالة رائعة',
            'جديد بالكرتونة، لم يستعمل، ضمان سنتين',
            'تصميم عصري، خامات عالية الجودة، حالة ممتازة',
            'مقاس متوسط، تصميم أنيق، مناسب للمناسبات',
            'حالة جيدة جداً، مناسبة للرياضة والتنقل',
            'كتب جامعية متنوعة، حالة جيدة، أسعار مخفضة',
            'أليفة ومدربة، تحب الأطفال، مطعمة بالكامل',
        ];

        $arabicNames = [
            'أحمد محمد', 'فاطمة علي', 'محمد عبدالله', 'عائشة حسن',
            'علي أحمد', 'خديجة محمد', 'عبدالرحمن سالم', 'مريم عبدالله',
            'يوسف إبراهيم', 'زينب محمود', 'عمر خالد', 'نور الهدى',
        ];

        $sampleImages = [
            'ads/sample1.jpg', 'ads/sample2.jpg', 'ads/sample3.jpg',
            'ads/sample4.jpg', 'ads/sample5.jpg', 'ads/sample6.jpg',
            'ads/sample7.jpg', 'ads/sample8.jpg', 'ads/sample9.jpg',
            'ads/sample10.jpg'
        ];

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'title' => $this->faker->randomElement($arabicTitles),
            'description' => $this->faker->optional(0.8)->randomElement($arabicDescriptions),
            'price' => $this->faker->optional(0.9)->randomFloat(2, 50, 50000),
            'type' => $this->faker->optional()->randomElement(['للبيع', 'للشراء', 'للإيجار']),
            'additional_info' => $this->faker->optional(0.3)->randomElement([
                'التواصل واتساب فقط',
                'السعر قابل للتفاوض',
                'استلام فوري',
                'ضمان متوفر',
                'توصيل مجاني داخل المدينة'
            ]),
            'images' => json_encode($this->faker->randomElements($sampleImages, $this->faker->numberBetween(1, 4))),
            'seller_name' => $this->faker->randomElement($arabicNames),
            'seller_phone' => $this->faker->randomElement([
                '0501234567', '0551234567', '0561234567', '0591234567',
                '0502345678', '0552345678', '0562345678', '0592345678',
            ]),
            'allow_mobile_messages' => $this->faker->boolean(80),
            'allow_whatsapp_messages' => $this->faker->boolean(90),
            'fee_agree' => $this->faker->boolean(85),
            'is_featured' => $this->faker->boolean(15),
        ];
    }
}
