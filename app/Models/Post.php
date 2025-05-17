<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    protected $guarded = false;

    protected $with = ['image', 'likedUsers'];

    public function image(): HasOne
    {
        return $this->hasOne(PostImage::class, 'post_id', 'id')
            ->whereNotNull('post_id');
    }
    public function likedUsers(): BelongsToMany
    {
      return $this->belongsToMany(User::class, 'liked_posts', 'post_id', 'user_id');
    }
}
