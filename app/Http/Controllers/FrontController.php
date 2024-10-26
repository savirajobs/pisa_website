<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    function index()
    {
        // Memanggil metode getpost() dari model
        $latest_programs = $this->getChildProgram();
        $latest_news = $this->getLatestNews();
        $latest_events = $this->getLatestEvent();
        $profile = $this->getProfile();
        $gallery = $this->getImgGallery();
        $header = $this->headerimg();

        // Mengambil data untuk ditampilkan di halaman beranda
        $data = [
            'page_title'        => 'Beranda',
            'latest_programs'   => $latest_programs,
            'latest_news'       => $latest_news,
            'latest_events'     => $latest_events,
            'profile'           => $profile,
            'gallery_img'       => $gallery,
            'header_img'        => $header,
            'categories'        => Category::all(),
        ];

        // Menambahkan data untuk paginasi
        $data['posts'] = Post::where('is_publish', 1)->latest()->paginate(6);

        // Mengirim data ke tampilan
        return view('front.index', $data);
    }

    public function headerimg()
    {
        $incl_type = ['NW', 'IF'];

        $header = Post::select([
            'posts.post_id',
            'posts.slug',
            'media.file_name'
        ])
            ->join('media', 'posts.post_id', '=', 'media.post_id')
            ->where('posts.is_publish', 1)
            ->wherein('posts.post_type', $incl_type)
            ->orderBy('posts.created_at', 'desc')
            ->limit(12)
            ->get();

        return $header;
    }

    public function getChildProgram()
    {
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $posts = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'posts.is_publish',
            'posts.event_at',
            'posts.notes',
            'posts.created_at',
            'posts.created_by',
            'top_media.file_name as image_name',
            'users.name as user_name',
            DB::raw('LEFT(posts.post_desc, 100) as short_desc')
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'CP')
            ->orderBy('posts.created_at', 'desc')
            ->limit(3)
            ->get();

        return $posts;
    }

    public function getLatestNews()
    {
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $posts = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'categories.category_name',
            'posts.is_publish',
            'posts.event_at',
            'posts.notes',
            'posts.created_at',
            'posts.created_by',
            'categories.category_name as category_name',
            'top_media.file_name as image_name',
            'users.name as user_name',
            DB::raw('LEFT(posts.post_desc, 100) as short_desc')
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('categories', 'posts.category_id', '=', 'categories.category_id')
            ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'NW') // News
            ->orderBy('posts.created_at', 'desc')
            ->limit(3)
            ->get();

        return $posts;
    }

    public function getLatestEvent()
    {
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $posts = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'categories.category_name',
            'posts.is_publish',
            'posts.event_at',
            'posts.notes',
            'posts.created_at',
            'posts.created_by',
            'categories.category_name as category_name',
            'top_media.file_name as image_name',
            'users.name as user_name',
            DB::raw('LEFT(posts.post_desc, 100) as short_desc')
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('categories', 'posts.category_id', '=', 'categories.category_id')
            ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'IF') // information
            ->orderBy('posts.created_at', 'desc')
            ->limit(3)
            ->get();

        return $posts;
    }

    public function getProfile()
    {
        $profile = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'posts.post_desc',
            'users.name',
            'posts.is_publish',
            'posts.created_at',
            'posts.created_by'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('media', 'posts.post_id', '=', 'media.post_id')
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', '=', 'PROFILE')
            ->get();

        return $profile;
    }

    public function getImgGallery()
    {
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $gallery = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'posts.is_publish',
            'posts.created_at',
            'top_media.file_name as image_name',
            'users.name as user_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('categories', 'posts.category_id', '=', 'categories.category_id')
            ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'MD')
            ->where('posts.category_id', 6)
            ->orderBy('posts.created_at', 'desc')
            ->limit(4)
            ->get();

        return $gallery;
    }
}
