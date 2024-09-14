<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class ProgramController extends Controller
{
    function index()
    {
          // Mengambil data untuk ditampilkan di halaman beranda
        $data = [
            'page_title'    => 'Program Anak',
            'latest_posts'  => Post::where('is_publish', 1)
                                ->where('post_type', 'CP')
                                ->orderby('post_id', 'desc')
                                ->limit(3)
                                ->get(),
            'categories'    => Category::all(),
        ];

         // Menambahkan data untuk paginasi
        $data['posts'] = Post::where('is_publish', 1)->latest()->paginate(6);

         // Mengirim data ke tampilan
        return view('front.index', $data);
    }
}
