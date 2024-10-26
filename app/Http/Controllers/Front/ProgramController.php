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

        return view('front.program', compact('programs'));
    }

    public function show($slug)
    {
        $data = Post::with('media')
            ->where('slug', $slug)
            ->where('is_publish', 1)
            ->where('post_type', 'CP')
            ->first();

        $filenames = $data->media->pluck('file_name')->toArray();

        return view('front.program-detail', ['program' => $data, 'filenames' => $filenames]);
    }
}
