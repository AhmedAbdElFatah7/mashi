<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ad;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo',
    ];

    protected $casts = [
        'logo' => 'string',
    ];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
