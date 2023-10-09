<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index($user_id)
    {
        $posts = Post::where('user_id', $user_id)->with(['tags', 'user', 'userAccount.platform' => function ($query) {
            $query->where('name', 'Facebook');
        }])->get();
        $groupedPosts  = $posts->groupBy(function ($post) {
            return $post->tags->pluck('name')->toArray();
        });

        return view('posts.index', ['groupedPosts' => $groupedPosts]);
    }

    public function all()
    {
        dd("Asdfasdfasda");
    }

    public function facebookPosts()
    {
        $posts = Post::with(['tags', 'user', 'userAccount.platform' => function ($query) {
            $query->where('name', 'Facebook');
        }])->get();
        $groupedPosts  = $posts->groupBy(function ($post) {
            return $post->tags->pluck('name')->toArray();
        });

        return view('posts.facebook', ['groupedPosts' => $groupedPosts]);
    }

    public function twitterPosts()
    {
    }

    public function instagramPosts()
    {
    }

    public function userFacebookposts()
    {
        $posts = Post::where('user_id', auth()->user()->id)->with(['tags', 'user', 'userAccount.platform' => function ($query) {
            $query->where('name', 'Facebook');
        }])->get();
        $groupedPosts  = $posts->groupBy(function ($post) {
            return $post->tags->pluck('name')->toArray();
        });

        return view('users.posts', ['groupedPosts' => $groupedPosts]);
    }

    public function syncPosts()
    {
        return view('posts.sync');
    }
}
