<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;


class MediaController extends Controller
{
    function index()
    {
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $images = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'posts.post_desc',
            'users.name',
            'posts.is_publish',
            'posts.event_at',
            'posts.notes',
            'posts.created_at',
            'posts.created_by',
            'categories.category_name as category_name',
            'top_media.file_name as image_name',
            'users.name as user_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->join('categories', 'posts.category_id', '=', 'categories.category_id')
            ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'MD')
            ->where('posts.category_id', 1)
            ->orderby('created_at', 'desc')
            ->paginate(4);

        return view('front.gallery.img-gallery', compact('images'));
    }

    public function show_gallery($slug)
    {
        $data = Post::with('media', 'users')
            ->where('slug', $slug)
            ->where('is_publish', 1)
            ->where('post_type', 'MD')
            ->first();

        $user = $data->users->name;
        $filenames = $data->media->pluck('file_name')->toArray();

        return view('front.gallery.gallery-detail', ['media' => $data, 'filenames' => $filenames,  'user' => $user]);
    }

    public function index_video()
    {
        $videos = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'posts.post_desc',
            'users.name',
            'posts.is_publish',
            'posts.event_at',
            'posts.notes',
            'posts.created_at',
            'posts.created_by',
            'categories.category_name as category_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->join('categories', 'posts.category_id', '=', 'categories.category_id')
            // ->join('posts.post_id', '=', 'media.post_id')
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'MD')
            ->where('posts.category_id', 2)
            ->orderby('created_at', 'desc')
            ->paginate(4);

            return view('front.gallery.vid-gallery', compact('videos'));
    }
}
