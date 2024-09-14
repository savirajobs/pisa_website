<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    function index()
    {
        // Membuat instance dari model Post
        $postModel = new Post();
                
        // Memanggil metode getpost() dari model
        // $latest_programs = $postModel->getProgramAnak();
        $latest_programs = $postModel->getPostList();
        $latest_news = $postModel->getLatestNews();
        $latest_events = $postModel->getLatestEvent();

          // Mengambil data untuk ditampilkan di halaman beranda
        $data = [
            'page_title'        => 'Beranda',
            'latest_programs'   => $latest_programs,
            'latest_news'       => $latest_news,
            'latest_events'     => $latest_events,
            'categories'    => Category::all(),
        ];

        // Menambahkan data untuk paginasi
        $data['posts'] = Post::where('is_publish', 1)->latest()->paginate(6);

         // Mengirim data ke tampilan
        return view('front.index', $data);
    }
    

    function profile()
    {
        return view('front.profile');
    }
}
