<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Resources\Post\PostResourse;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->latest()->get();

        return PostResourse::collection($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $data = $request->validated();
        $post = null;

        try {
            DB::transaction(function () use ($data, &$post) {
                $data['user_id'] = auth()->id();

                $imageId = $data['image_id'];
                unset($data['image_id']);

                $post = Post::create($data);

                if (isset($imageId)) {
                    $image = PostImage::find($imageId);
                    $image->update([
                        'status' => true,
                        'post_id' => $post->id,
                    ]);
                }
                PostImage::clearStorage();
            });

            return new PostResourse($post);
        } catch (\Throwable $th) {
            Log::error('Error while creating post: '.$th->getMessage());

            return response()->json([
                'message' => 'Произошла ошибка при создании поста. Попробуйте еще раз позже.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
