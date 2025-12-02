<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'ad_id',
        'comment',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['likes_count'];

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ad that the comment belongs to.
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * Get all likes for this comment.
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'comment_likes')->withTimestamps();
    }

    /**
     * Get the likes count attribute.
     */
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    /**
     * Check if the comment is liked by a specific user.
     */
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
