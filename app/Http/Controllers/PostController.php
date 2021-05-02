<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PostController extends Controller
{
    public function index() {

        $posts = DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->get([
            'posts.id',
            'posts.name',
            'posts.content',
            'users.name AS user',
        ]);

        $tags = DB::table('tags')
        ->get();

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

        return view('post.index', [
            'posts' => $posts,
            'tags' => $tags,
        ]);
    
    }

    public function search(Request $request) {
        $name = $request->input('name');
        $tags = $request->input('tags');

        $allposts = DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->where('posts.name', 'LIKE', '%'.$name.'%')
        ->get([
            'posts.id',
            'posts.name',
            'posts.content',
            'users.name AS user',
        ]);
        
        $posts = collect([]);
        if ($request->input('tags') != null) {
            foreach ($allposts as $allpost)
            {
                $posttags = DB::table('post_has_tags')
                ->join('tags', 'tags.id', '=', 'post_has_tags.tag_id')
                ->where('post_has_tags.post_id', '=', $allpost->id)
                ->get([
                    'tags.name AS name'
                ]);
                
                $selected = False;
                foreach ($tags as $tag)
                {
                    $searchedtag = DB::table('tags')
                    ->where('tags.id', '=', $tag)
                    ->get([
                        'tags.name AS name'
                    ])->first();
                    foreach ($posttags as $posttag)
                    {
                        if ($posttag->name == $searchedtag->name)
                        {
                            $selected = True;
                        }
                    }
                }
                if ($selected == True)
                {
                    $posts->push($allpost);
                }
            }
        }
        else {
            $posts = $allposts;
        }

        $tags = DB::table('tags')
        ->get();

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

        return view('post.index', [
            'posts' => $posts,
            'tags' => $tags,
        ]);
    }

    public function show($id) {

        $post = DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->where('posts.id', '=', $id)
        ->get([
            'posts.name AS name',
            'posts.content AS content',
            'posts.created_at AS created_at',
            'users.name AS user',
            'users.id AS user_id',
            'posts.id AS id'
        ])
        ->first();
        $post->created = new Carbon($post->created_at);

        $tags = DB::table('post_has_tags')
        ->join('tags', 'tags.id', '=', 'post_has_tags.tag_id')
        ->where('post_has_tags.post_id', '=', $id)
        ->get([
            'tags.name AS name'
        ]);


        return view('post.show', [
            'post' => $post,
            'tags' => $tags,
        ]);
    }

    public function create() {
        $tags = DB::table('tags')
        ->get();

        return view('post.create', [
            'tags' => $tags,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:50',
            'tags.*' => 'exists:tags,id',
            'content' => 'required|max:2000',
        ]);

        $newID = DB::table('posts')->insertGetId([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'user_id' => Auth::user()->id,
            'created_at' => now(),
        ]);
        
        if ($request->input('tags') != null)
        {
            foreach ($request->input('tags') as $tag)
            {
                DB::table('post_has_tags')->insert([
                    'post_id' => $newID,
                    'tag_id' => $tag,
                ]);
            }
        }

        return redirect()
            ->route('post.show', [ 'id' => $newID ])
            ->with('success', "Successfully created {$request->input('name')}.");
    }

    public function bookmark() {
        $posts = DB::table('bookmarks')
        ->where('bookmarks.user_id', '=', Auth::user()->id)
        ->join('posts', 'posts.id', '=', 'bookmarks.post_id')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->get([
            'posts.id',
            'posts.name',
            'posts.content',
            'users.name AS user',
            'bookmarks.created_at AS timebookmarked_at',
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
                    $post->timebookmarked = new Carbon($post->timebookmarked_at);
                }
                else
                {
                    $post->bookmarked = false;
                }
            }
        }

        return view('post.bookmark', [
            'posts' => $posts,
        ]);
    }

    public function togglebookmark($id) {
        $alreadybookmarked = DB::table('bookmarks')
        ->where('bookmarks.user_id', '=', Auth::user()->id)
        ->where('post_id', '=', $id)
        ->join('posts', 'posts.id', '=', 'bookmarks.post_id')
        ->first();

        if ($alreadybookmarked != null)
        {
            DB::table('bookmarks')
            ->where('user_id', '=', Auth::user()->id)
            ->where('post_id', '=', $id)
            ->delete();

            return redirect()
            ->route('post.index')
            ->with('success', "Removed {$alreadybookmarked->name} from bookmarks.");
        }
        else
        {
            DB::table('bookmarks')->insert([
                'user_id' => Auth::user()->id,
                'post_id' => $id,
                'created_at' => now(),
            ]);
            $alreadybookmarked = DB::table('bookmarks')
            ->where('bookmarks.user_id', '=', Auth::user()->id)
            ->where('post_id', '=', $id)
            ->join('posts', 'posts.id', '=', 'bookmarks.post_id')
            ->first();

            return redirect()
            ->route('post.index')
            ->with('success', "Added {$alreadybookmarked->name} to bookmarks.");
        }
    }

    public function update($id, Request $request) {

        $request->validate([
            'name' => 'required|max:50',
            'tags.*' => 'exists:tags,id',
            'content' => 'required|max:2000',
        ]);

        DB::table('posts')
        ->where('id', '=', $id)
        ->update([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
        ]);

        DB::table('post_has_tags')
        ->where('post_id', '=', $id)
        ->delete();
        
        if ($request->input('tags') != null)
        {
            foreach ($request->input('tags') as $tag)
            {
                DB::table('post_has_tags')->insert([
                    'post_id' => $id,
                    'tag_id' => $tag,
                ]);
            }
        }

        return redirect()
            ->route('post.show', [ 'id' => $id ])
            ->with('success', "Successfully updated {$request->input('name')}.");
    }

    public function edit($id) {
        $post = DB::table('posts')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->where('posts.id', '=', $id)
        ->get([
            'posts.name AS name',
            'posts.content AS content',
            'users.name AS user',
            'users.id AS user_id',
            'posts.id AS id'
        ])
        ->first();

        $tags = DB::table('tags')
        ->get();

        $selectedtags = DB::table('post_has_tags')
        ->where('post_has_tags.post_id', '=', $id)
        ->join('tags', 'tags.id', '=', 'post_has_tags.tag_id')
        ->get();

        return view('post.edit', [
            'tags' => $tags,
            'post' => $post,
            'selectedtags' => $selectedtags,
        ]);
    }

    public function delete($id) {
        DB::table('post_has_tags')
        ->where('post_id', '=', $id)
        ->delete();

        DB::table('bookmarks')
        ->where('post_id', '=', $id)
        ->delete();

        $deletedpost = DB::table('posts')
            ->where('id', '=', $id)
            ->get(['posts.name AS name'])->first();

        DB::table('posts')
        ->where('id', '=', $id)
        ->delete();
        
        $posts = DB::table('posts')
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

        return redirect()
        ->route('post.index')
        ->with('success', "Successfully deleted {$deletedpost->name}.");
    }


}
