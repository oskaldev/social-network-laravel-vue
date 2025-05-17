<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResourse;
use App\Http\Resources\User\UserResource;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\SubscriberFollowing;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $followingIds = SubscriberFollowing::where('subscriber_id', auth()->id())
            ->get('following_id')->pluck('following_id')->toArray();

        foreach ($users as $user) {
            if (in_array($user->id, $followingIds)) {
                $user->is_followed = true;
            }
        }

        return UserResource::collection($users);
    }

    /**
     * Summary of post
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function post(User $user)
    {
        $posts = $user->posts()->latest()->get();
        $posts = $this->prepareLikedPOsts($posts);

        return PostResourse::collection($user->posts);
    }

    /**
     * Summary of toggleFollowing
     */
    public function toggleFollowing(User $user): array
    {
        $res = auth()->user()->followings()->toggle($user->id);

        $data['is_followed'] = count($res['attached']) > 0;

        return $data;
    }

    /**
     * Summary of followingPost
     */
    public function followingPost(): AnonymousResourceCollection
    {
        $followedIds = auth()->user()->followings()->latest()->get()->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $followedIds)->get();
        $likedIds = LikedPost::where('user_id', auth()->id())
            ->get('post_id')->pluck('post_id')->toArray();

        $posts = Post::whereIn('user_id', $followedIds)
            ->whereNotIn('id', $likedIds)
            ->get();

        $posts = $this->prepareLikedPOsts($posts);

        return PostResourse::collection($posts);
    }

    private function prepareLikedPOsts($posts): mixed
    {

        $likedIds = LikedPost::where('user_id', auth()->id())
            ->get('post_id')->pluck('post_id')->toArray();

        foreach ($posts as $post) {
            if (in_array($post->id, $likedIds)) {
                $post->is_liked = true;
            }
        }

        return $posts;
    }
}
