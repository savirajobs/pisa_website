<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Media;


class ProgramController extends Controller
{
    function index()
    {
        // Membuat instance dari model Post
        $postModel = new Post();

        $all_programs = $postModel->getProgramList();

          // Mengambil data untuk ditampilkan di halaman beranda
        $data = [
            'page_title'        => 'Program Anak',
            'latest_programs'   => $all_programs,
            'categories'        => Category::all(),
        ];

         // Menambahkan data untuk paginasi
        $data['posts'] = Post::where('is_publish', 1)->latest()->paginate(6);

         // Mengirim data ke tampilan
        return view('front.program', $data);
    }

    public function show($slug)
    {
        $data = Post::with('media')
            ->where('slug', $slug)
            ->where('is_publish', 1)
            ->where('post_type','CP')
            ->first();

            $filenames = $data->media->pluck('file_name')->toArray();

            return view('front.showprogram', ['program' => $data, 'filenames' => $filenames]);

        // if (!$data) {
        //     return redirect()->route('404'); // Atau penanganan lain jika tidak ditemukan
        //     }

        // $postModel = new Post();
        // $showprogram = $postModel->showprogram();

        // $data = [
        //     'page_title'        => 'Program Anak',
        //     'program'           => $showprogram,
        //     'categories'        => Category::all(),
        // ];

        // return view('front.showprogram', ['program'=>$data]);
        // return view('front.showprogram', $data);
    }
}
