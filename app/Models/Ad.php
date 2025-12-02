<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'type',
        'additional_info',
        'images',
        'seller_name',
        'seller_phone',
        'allow_mobile_messages',
        'allow_whatsapp_messages',
        'fee_agree',
        'is_featured',
        'isNegotiable',
    ];

    protected $casts = [
        'images' => 'array',
        'allow_mobile_messages' => 'boolean',
        'allow_whatsapp_messages' => 'boolean',
        'fee_agree' => 'boolean',
        'is_featured' => 'boolean',
        'isNegotiable' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
