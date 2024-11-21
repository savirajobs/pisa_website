<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    function index()
    {
        // Memanggil metode getpost() dari model
        $latest_programs = $this->getChildProgram();
        $latest_news = $this->getLatestNews();
        $latest_article = $this->getLatestArticle();
        $profile = $this->getProfile();
        $gallery = $this->getImgGallery();
        $header = $this->headerimg();

        // Mengambil data untuk ditampilkan di halaman beranda
        $data = [
            'page_title'        => 'Beranda',
            'latest_programs'   => $latest_programs,
            'latest_news'       => $latest_news,
            'latest_article'    => $latest_article,
            'profile'           => $profile,
            'gallery_img'       => $gallery,
            'header_img'        => $header,
            'categories'        => Category::all(),
        ];

        // dd($data);

        // Menambahkan data untuk paginasi
        // $data['posts'] = Post::where('is_publish', 1)->latest()->paginate(4);

        // Impementation for cookie
        // Cek apakah cookie 'visitor_id' ada
        // if (!request()->hasCookie('visitor_id')) {
        //     // Jika tidak ada, buat ID pengunjung baru
        //     $visitorId = Str::uuid()->toString();
        //     $cookie = cookie('visitor_id', $visitorId, 10); // Cookie berlaku selama 10 menit

        //     // Mencatat pengunjung
        //     DB::table('visitor')->insert([
        //         'date_visitor'  => now(),
        //         'post_id'       => $visitorId,
        //         'created_at'    => now()
        //     ]);

        //     // return (new Response(view('front.index', $data)))->withCookie($cookie);
        //     return response(view('front.index', $data))->withCookie($cookie);
        // }

        $datetime = now();
        $monthYear = $datetime->format("m-Y"); // Output: 10-2024
        // dd($monthYear);

        $sessionKey = 'visited_front' . $monthYear;

        if (!session()->has($sessionKey)) {
            // Cek apakah data Visitor bulan ini sudah ada
            $visitordata = Visitor::firstOrCreate(
                ['monthyear' => $monthYear],
                ['visitor' => 0]
            );

            // Increment visitor dan set session
            $visitordata->increment('visitor');
            session()->put($sessionKey, true);
        }

        // if (Visitor::where('monthyear', $monthYear)->exists()) {
        //     $visitordata = Visitor::where('monthyear', $monthYear)->first();

        //     $sessionKey = 'visited_front' . $monthYear;
        //     if (!session()->has($sessionKey)) {
        //         $visitordata->increment('visitor');

        //         session()->put($sessionKey, true);
        //     }
        // } else {
        //     Visitor::create([
        //         'monthyear' => $monthYear,
        //         'visitor'   => 1
        //     ]);

        //     $visitordata = Visitor::where('monthyear', $monthYear)->first();

        //     $sessionKey = 'visited_front' . $monthYear;
        //     if (!session()->has($sessionKey)) {
        //         $visitordata->increment('visitor');

        //         session()->put($sessionKey, true);
        //     }
        // }

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

    public function getLatestArticle()
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
            ->where('posts.post_type', 'AR') // article
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
            ->first();

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

    public function search($request)
    {

        dd($request);

        $keyword = $request->input('keyword');

        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        $incl_type = ['NW', 'IF'];

        // CARI JUDUL POST
        $search = Post::select([
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
            ->leftjoin('categories', 'posts.category_id', '=', 'categories.category_id')
            ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
            ->where('posts.is_publish', 1)
            ->wherein('posts.post_type', $incl_type)
            ->where('posts.post_title', 'like', '%' . $keywords . '%')
            ->orWhere('posts.post_desc', 'like', '%' . $keywords . '%')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(3);

        $sqlQuery = $search->toSql();
        dd($sqlQuery);

        return view('front.search', compact('search'));
        // return view('front.search');
    }
}
