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
        $all_img = $this->getImageGallery()->paginate(8);;

        // Mengambil data untuk ditampilkan di halaman beranda
        $data = [
            'page_title'    => 'Images Gallery',
            'img_gallery'   => $all_img,
            'categories'    => Category::all(),
        ];

        // Mengirim data ke tampilan
        return view('front.img-gallery', $data);
    }

    public function getImageGallery()
    {
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $posts = Post::select([
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
            ->where('posts.category_id', 6)
            ->orderby('created_at', 'desc');

        return $posts;
    }

    public function show_gallery($slug)
    {
        $data = Post::with('media')
            ->where('slug', $slug)
            ->where('is_publish', 1)
            ->where('post_type', 'MD')
            ->first();

        // Format the event_at date using Carbon and set it to the locale
        Carbon::setLocale('id');
        $formattedDate = Carbon::parse($data->event_at)->translatedFormat('d F Y');

        $filenames = $data->media->pluck('file_name')->toArray();

        return view('front.gallery-detail', ['media' => $data, 'filenames' => $filenames,  'formattedDate' => $formattedDate]);
    }

    public function getVideos()
    {
        $posts = Post::select([
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
            'top_media.file_name as image_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->join('categories', 'posts.category_id', '=', 'categories.category_id')
            ->join('posts.post_id', '=', 'media.post_id')
            ->where('posts.is_publish', 1)
            ->where('posts.post_type', 'MD')
            ->where('posts.category_id', 7)
            ->orderby('created_at', 'desc');

        return $posts;
    }
}
