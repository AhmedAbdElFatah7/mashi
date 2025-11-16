<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'logo'
    ];

    /**
     * الحصول على الإعدادات الأساسية للموقع
     */
    public static function getSiteSettings()
    {
        return static::first();
    }

    /**
     * تحديث إعدادات الموقع
     */
    public static function updateSiteSettings($data)
    {
        $setting = static::first();
        
        if ($setting) {
            return $setting->update($data);
        } else {
            return static::create($data);
        }
    }
}
