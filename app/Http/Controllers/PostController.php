<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Resources\Post\PostResourse;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;
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
        $likedIds = LikedPost::where('user_id', auth()->id())
            ->get('post_id')->pluck('post_id')->toArray();

        foreach ($posts as $post) {
            if (in_array($post->id, $likedIds)) {
                $post->is_liked = true;
            }
        }

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
     * Summary of toggleLike
     *
     * @return bool[]
     */
    public function toggleLike(Post $post): array
    {
        $res = auth()->user()->likedPosts()->toggle($post->id);

        $data['is_liked'] = count($res['attached']) > 0;
        $data['likes_count'] = $post->likedUsers()->count();

        return $data;
    }
}
