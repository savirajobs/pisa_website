<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Media;
use App\Models\Post;

class ProgramController extends Controller
{
    function index()
    {
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $programs = Post::select([
            'posts.post_id',
            'posts.post_title',
            'posts.slug',
            'posts.post_desc',
            'posts.is_publish',
            'posts.category_id',
            'posts.event_at',
            'posts.notes',
            'posts.created_by',
            'posts.created_at',
            'top_media.file_name as image_name',
            'users.name as user_name',
            DB::raw('LEFT(posts.post_desc, 200) as short_desc')
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'CP')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return view('front.program.program', compact('programs'));
    }

    public function show($slug)
    {
        $data = Post::with('media', 'users')
            ->where('slug', $slug)
            ->where('is_publish', 1)
            ->where('post_type', 'CP')
            ->first();

        $user = $data->users->name;
        $filenames = $data->media->pluck('file_name')->toArray();

        return view('front.program.program-detail', ['program' => $data, 'filenames' => $filenames, 'user' => $user]);
    }

    public function showPLD()
    {
        $data = Post::select([
            'posts.post_id',
            'posts.post_title',
            'posts.slug',
            'posts.post_desc',
            'posts.is_publish',
            'posts.category_id',
            'posts.event_at',
            'posts.notes',
            'posts.created_by',
            'posts.created_at',
            'media.file_name',
            'users.name as user_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('media', 'media.post_id', '=', 'posts.post_id')
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'CP')
            ->where('posts.post_id', 'CP02')
            ->first();

        return view('front.program.pld-dikda', compact('data'));
    }

    public function showPerpusBK()
    {
        $data = Post::select([
            'posts.post_id',
            'posts.post_title',
            'posts.slug',
            'posts.post_desc',
            'posts.is_publish',
            'posts.category_id',
            'posts.event_at',
            'posts.notes',
            'posts.created_by',
            'posts.created_at',
            'media.file_name',
            'users.name as user_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('media', 'media.post_id', '=', 'posts.post_id')
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'CP')
            ->where('posts.post_id', 'CP01')
            ->first();

        return view('front.program.perpus-bk', compact('data'));
    }

    public function showLaporTP2A()
    {
        $data = Post::select([
            'posts.post_id',
            'posts.post_title',
            'posts.slug',
            'posts.post_desc',
            'posts.is_publish',
            'posts.category_id',
            'posts.event_at',
            'posts.notes',
            'posts.created_by',
            'posts.created_at',
            'media.file_name',
            'users.name as user_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('media', 'media.post_id', '=', 'posts.post_id')
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'CP')
            ->where('posts.post_id', 'CP03')
            ->first();

        return view('front.program.lapor-kekerasan', compact('data'));
    }
}
