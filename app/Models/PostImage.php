<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $guarded = false;

    /**
     * Summary of getUrlAttribute
     */
    public function getUrlAttribute(): string
    {
        return url('storage/'.$this->path);
    }
}
