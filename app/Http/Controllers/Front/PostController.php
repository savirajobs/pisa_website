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
    //display Berita
    function index()
    {
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        // $incl_type = ['NW', 'IF']; dihapus

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
            ->where('posts.post_type', 'NW')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(6);

        return view('front.news.news', compact('latest_news'));
    }

    //display detail Berita
    public function show($slug)
    {
        //get all news & information
        // $incl_type = ['NW', 'IF']; dihapus

        $data = Post::with('media', 'users')
            ->where('slug', $slug)
            ->where('is_publish', 1)
            ->where('post_type', 'NW')
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
            'posts.event_at',
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

        return view('front.news.news-detail', ['news' => $data, 'filenames' => $filenames, 'relatednews' => $relatednews, 'user' => $user]);
    }

    //display Artikel
    function index_article()
    {
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $latest_article = Post::select([
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
            ->where('posts.post_type', 'AR')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(6);

        return view('front.news.article', compact('latest_article'));
    }

    //display detail Artikel
    public function show_article($slug)
    {
        $data = Post::with('media', 'users')
            ->where('slug', $slug)
            ->where('is_publish', 1)
            ->where('post_type', 'AR')
            ->first();

        $filenames = $data->media->pluck('file_name')->toArray();
        $user = $data->users->name;

        //get related posts
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $getposts = Post::select(['posts.post_id', 'posts.post_type'])->where('slug', $slug)->first();

        $relatedarticle =  Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'categories.category_name',
            'users.name',
            'posts.created_at',
            'posts.event_at',
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

        return view('front.news.article-detail', ['article' => $data, 'filenames' => $filenames, 'relatedarticle' => $relatedarticle, 'user' => $user]);
    }

    //display Fasilitas
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
        return view('front.facility.facility', compact('facilities'));
    }

    //display detail Fasilitas
    public function show_facility($slug)
    {
        $data = Post::with('media', 'users')
            ->where('slug', $slug)
            ->where('is_publish', 1)
            ->where('post_type', 'FC')
            ->first();

        $user = $data->users->name;
        $filenames = $data->media->pluck('file_name')->toArray();

        return view('front.facility.facility-detail', ['facility' => $data, 'filenames' => $filenames, 'user' => $user]);
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
            ->where('posts.post_id', '=', 'PF01')
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


        return view('front.profile.profile', ['profile' => $profile, 'secretary' => $secretary]);
    }

    public function forumAnak()
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
            ->where('posts.post_type', '=', 'PROFILE')
            ->where('posts.post_id', '=', 'PF03')
            ->first();

        return view('front.profile.', compact('profile'));
    }

    //display Dasar Hukum
    public function index_law()
    {
        $laws = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'users.name',
            'posts.is_publish',
            'posts.event_at',
            'posts.notes',
            'posts.created_at',
            'posts.created_by',
            'media.file_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->join('media', 'posts.post_id', '=', 'media.post_id')
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'LW')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(8);

        return view('front.profile.law', compact('laws'));
    }

    //display detail Dasar Hukum
    public function show_law($slug)
    {
        $law = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'users.name',
            'posts.is_publish',
            'posts.notes',
            'posts.created_at',
            'posts.created_by',
            'posts.event_at',
            'media.file_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->join('media', 'posts.post_id', '=', 'media.post_id')
            ->where('posts.slug', $slug)
            ->first();

        $getposts = Post::select(['posts.post_id'])->where('slug', $slug)->first();

        $relatedlaws =  Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'users.name',
            'posts.is_publish',
            'posts.notes',
            'posts.created_at',
            'posts.created_by',
            'posts.event_at',
            'media.file_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->join('media', 'posts.post_id', '=', 'media.post_id')
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'LW')
            ->where('posts.post_id', '<>', $getposts->post_id)
            ->orderBy('posts.created_at', 'desc')
            ->limit(4)
            ->get();

        return view('front.profile.law-detail', ['law' => $law, 'relatedlaw' => $relatedlaws]);
    }
}
