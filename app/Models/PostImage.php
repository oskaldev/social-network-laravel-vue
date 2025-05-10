<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public static function clearStorage(): void
    {
        $images = PostImage::where('user_id', auth()->id())
            ->whereNull('post_id')->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
    }
}
