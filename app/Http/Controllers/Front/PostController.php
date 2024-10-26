<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;

class PostController extends Controller
{
    function index()
    {
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $incl_type = ['NW', 'IF'];

        $latest_news = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'categories.category_name',
            'users.name',
            'posts.is_publish',
            'posts.event_at',
            'posts.notes',
            'posts.created_at',
            'posts.created_by',
            'top_media.file_name as image_name',
            DB::raw('LEFT(posts.post_desc, 400) as short_desc')
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('categories', 'posts.category_id', '=', 'categories.category_id')
            ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
            ->where('posts.is_publish', 1)
            ->wherein('posts.post_type', $incl_type)
            ->orderBy('posts.created_at', 'desc')
            ->paginate(3);

        return view('front.news', compact('latest_news'));
    }

    public function show($slug)
    {
        //get all news & information
        $incl_type = ['NW', 'IF'];

        $data = Post::with('media', 'users')
            ->where('slug', $slug)
            ->where('is_publish', 1)
            ->wherein('post_type', $incl_type)
            ->first();

        $filenames = $data->media->pluck('file_name')->toArray();
        $user = $data->users->name;

        //get related posts
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $getposts = Post::select(['posts.post_id', 'posts.post_type'])->where('slug', $slug)->first();

        $relatednews =  Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'categories.category_name',
            'users.name',
            'posts.created_at',
            'top_media.file_name as image_name',
            DB::raw('LEFT(posts.post_desc, 400) as short_desc')
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('categories', 'posts.category_id', '=', 'categories.category_id')
            ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', $getposts->post_type)
            ->where('posts.post_id', '<>', $getposts->post_id)
            ->orderBy('posts.created_at', 'desc')
            ->limit(4)
            ->get();

        return view('front.news-detail', ['news' => $data, 'filenames' => $filenames, 'relatednews' => $relatednews, 'user' => $user]);
    }

    public function index_facility()
    {

        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $facilities = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'categories.category_name',
            'users.name',
            'posts.is_publish',
            'posts.event_at',
            'posts.notes',
            'posts.created_at',
            'posts.created_by',
            'categories.category_name as category_name',
            'top_media.file_name as image_name',
            'users.name as user_name',
            DB::raw('LEFT(posts.post_desc, 300) as short_desc')
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('categories', 'posts.category_id', '=', 'categories.category_id')
            ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', '=', 'FC')
            ->get();

        // Mengirim data ke tampilan
        return view('front.facility', compact('facilities'));
    }

    public function show_facility($slug)
    {
        $data = Post::with('media')
            ->where('slug', $slug)
            ->where('is_publish', 1)
            ->where('post_type', 'FC')
            ->first();

        $filenames = $data->media->pluck('file_name')->toArray();

        return view('front.facility-detail', ['facility' => $data, 'filenames' => $filenames]);
    }

    public function profile()
    {
        $profile = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'posts.post_desc',
            'posts.category_id',
            'posts.notes',
            'users.name',
            'posts.is_publish',
            'posts.created_at',
            'posts.created_by',
            'media.file_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('media', 'posts.post_id', '=', 'media.post_id')
            ->where('posts.is_publish', 1)
            // ->where('posts.category_id','=',99)
            ->where('posts.post_type', '=', 'PROFILE')
            ->first();

        $secretary = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'posts.post_desc',
            'posts.category_id',
            'posts.notes',
            'users.name',
            'posts.is_publish',
            'posts.created_at',
            'posts.created_by',
            'media.file_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('media', 'posts.post_id', '=', 'media.post_id')
            ->where('posts.is_publish', 1)
            // ->where('posts.category_id','=',99)
            ->where('posts.post_type', '=', 'SECRETARY')
            ->first();


        return view('front.profile', ['profile' => $profile, 'secretary' => $secretary]);
    }
}
