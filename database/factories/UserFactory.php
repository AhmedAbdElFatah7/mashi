<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arabicNames = [
            'أحمد محمد علي', 'فاطمة عبدالله حسن', 'محمد أحمد سالم', 'عائشة علي محمود',
            'علي عبدالرحمن أحمد', 'خديجة محمد إبراهيم', 'عبدالرحمن سالم خالد', 'مريم عبدالله يوسف',
            'يوسف إبراهيم محمد', 'زينب محمود علي', 'عمر خالد أحمد', 'نور الهدى حسن',
            'حسام الدين محمد', 'أسماء عبدالله', 'كريم أحمد علي', 'هدى محمد سالم',
        ];

        $saudiCities = [
            'الرياض', 'جدة', 'مكة المكرمة', 'المدينة المنورة', 'الدمام', 'الخبر',
            'تبوك', 'بريدة', 'خميس مشيط', 'حائل', 'الجبيل', 'الطائف',
        ];

        return [
            'name' => $this->faker->randomElement($arabicNames),
            'email' => fake()->unique()->safeEmail(),
            'phone' => $this->faker->randomElement([
                '0501234567', '0551234567', '0561234567', '0591234567',
                '0502345678', '0552345678', '0562345678', '0592345678',
                '0503456789', '0553456789', '0563456789', '0593456789',
            ]),
            'city' => $this->faker->randomElement($saudiCities),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
