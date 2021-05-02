<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index () {
        $posts = DB::table('posts')
        ->where('user_id', '=', Auth::user()->id)
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->get([
            'posts.id',
            'posts.name',
            'posts.content',
            'users.name AS user',
        ]);

        if (Auth::user())
        {
            foreach ($posts as $post)
            {
                $alreadybookmarked = DB::table('bookmarks')
                ->where('bookmarks.user_id', '=', Auth::user()->id)
                ->where('post_id', '=', $post->id)
                ->join('posts', 'posts.id', '=', 'bookmarks.post_id')
                ->first();
                if ($alreadybookmarked != null)
                {
                    $post->bookmarked = true;
                }
                else
                {
                    $post->bookmarked = false;
                }
            }
        }

        return view('profile.index', [
            'user' => Auth::user(),
            'posts' => $posts,
            'id' => -1,
        ]);
    }

    public function view ($id) {
        $posts = DB::table('posts')
        ->where('user_id', '=', $id)
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->get([
            'posts.id',
            'posts.name',
            'posts.content',
            'users.name AS user',
        ]);

        $user = DB::table('users')
        ->where('id', '=', $id)
        ->get([
            'name',
            'id'
        ])->first();

        if (Auth::user())
        {
            foreach ($posts as $post)
            {
                $alreadybookmarked = DB::table('bookmarks')
                ->where('bookmarks.user_id', '=', Auth::user()->id)
                ->where('post_id', '=', $post->id)
                ->join('posts', 'posts.id', '=', 'bookmarks.post_id')
                ->first();
                if ($alreadybookmarked != null)
                {
                    $post->bookmarked = true;
                }
                else
                {
                    $post->bookmarked = false;
                }
            }
        }

        return view('profile.index', [
            'user' => $user,
            'posts' => $posts,
            'id' => $id,
        ]);
    }
}
