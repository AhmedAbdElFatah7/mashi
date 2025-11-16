<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table = 'about_us';

    protected $fillable = [
        'main_title',
        'main_description',
        'mission_title',
        'mission_description',
        'vision_title',
        'vision_description',
        'stat_1_label',
        'stat_1_value',
        'stat_2_label',
        'stat_2_value',
        'stat_3_label',
        'stat_3_value',
    ];

    public static function getData()
    {
        return static::first();
    }

    public static function updateData(array $data)
    {
        $about = static::first();

        if ($about) {
            return $about->update($data);
        }

        return static::create($data);
    }
}
