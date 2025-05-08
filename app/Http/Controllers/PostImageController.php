<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostImage\StoreRequest;
use App\Http\Resources\PostImage\PostImageResource;
use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;

class PostImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): PostImageResource
    {
        $path = Storage::disk('public')->put('/images', $request['image']);
        $image = PostImage::create([
            'path' => $path,
            'user_id' => auth()->id(),
        ]);

        return new PostImageResource($image);
    }
}
