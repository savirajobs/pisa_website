<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\PostType;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class PostController extends Controller
{
    function apis(Request $request)
	{
		$posts = Post::select(['post_id', 'post_title', 'is_publish', 'published_at', 'upcoming_date', 'created_by'])
        ->where('is_publish', '=', '1')->orderBy('post_id', 'desc');

		return DataTables::of($posts)
			->addColumn('action', function ($row) {
				$deleteButton = $row->post_id == 1
					? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-person-x"></i></button>'
					: '<button data-id="' . $row->post_id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-person-x"></i></button>';

				return '
                <button data-id="' . $row->post_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-person-gear"></i></button>
                ' . $deleteButton . '
            ';
			})
			->editColumn('published_at', function ($posts) {
                $date = Carbon::parse($posts->published_at); 
				return $date->format('Y-m-d');
			}
            )
            ->editColumn('upcoming_date', function ($posts) {
                $date = Carbon::parse($posts->upcoming_date); 
				return $date->format('Y-m-d');
			}
            )
			->rawColumns(['action'])
			->make(true);
	}

    function post_draft(Request $request)
	{
		$posts = Post::select(['post_id', 'post_title',  'is_publish', 'published_at', 'upcoming_date', 'created_by'])
        ->where('is_publish', '=', '0')->orderBy('post_id', 'desc');

		return DataTables::of($posts)
			->addColumn('action', function ($row) {
				$deleteButton = $row->post_id == 1
					? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-person-x"></i></button>'
					: '<button data-id="' . $row->post_id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-person-x"></i></button>';

				return '
                <button data-id="' . $row->post_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-person-gear"></i></button>
                ' . $deleteButton . '
            ';
			})
			->editColumn('published_at', function ($posts) {
                $date = Carbon::parse($posts->published_at); 
				return $date->format('Y-m-d');
			}
            )
            ->editColumn('upcoming_date', function ($posts) {
                $date = Carbon::parse($posts->upcoming_date); 
				return $date->format('Y-m-d');
			}
            )
			->rawColumns(['action'])
			->make(true);
	}

    function post_all(Request $request)
	{
		$posts = Post::select(['post_id', 'post_title',  'is_publish', 'published_at', 'upcoming_date', 'created_by'])
        ->orderBy('post_id', 'desc');

		return DataTables::of($posts)
			->addColumn('action', function ($row) {
				$deleteButton = $row->post_id == 1
					? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-person-x"></i></button>'
					: '<button data-id="' . $row->post_id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-person-x"></i></button>';

				return '
                <button data-id="' . $row->post_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-person-gear"></i></button>
                ' . $deleteButton . '
            ';
			})
			->editColumn('published_at', function ($posts) {
                $date = Carbon::parse($posts->published_at); 
				return $date->format('Y-m-d');
			}
            )
            ->editColumn('upcoming_date', function ($posts) {
                $date = Carbon::parse($posts->upcoming_date); 
				return $date->format('Y-m-d');
			}
            )
			->rawColumns(['action'])
			->make(true);
	}
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posttypes = PostType::all();
        $categories = Category::all();
        return view('admin.post.index', ['page_title'=>'List post type','posttypes'=>$posttypes, 'categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_title'    => 'required',
            'post_type'     => 'required',
            'category_id'   => 'required',
            'post_desc'     => 'required',
            'published_at'  => 'required',
            'upcoming_date' => 'required'
        ], [
			'required' => ':attribute wajib diisi.',
			'string'   => ':attribute harus berupa teks.',
			'max'      => ':attribute tidak boleh lebih dari :max karakter.',
			'email'    => 'Format :attribute tidak valid.',
			'unique'   => ':attribute sudah terdaftar.',
			'min'      => ':attribute harus memiliki minimal :min karakter.',
		]);

        if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}

        if($request->is_publish == 'on' ){
            $is_publish = 1;
        }else{
            $is_publish = 0;
        }

		try {
			Post::create([
                'post_id'       => 'CT00005',
                'post_title'    => $request->post_title,
                'slug'          => 'Trial Insert with is publish',
                'post_desc'     => $request->post_desc,
                'post_type'     => $request->post_type,
                'is_publish'    => $is_publish,
                'category_id'   => $request->category_id,
                'published_at'  => $request->published_at,
                'upcoming_date' => $request->upcoming_date,
                'created_by'    => 2
            ]);

			return response()->json(['success' => 'Post has been added successfully.']);
		} catch (\Exception $e) {
			return response()->json(['error' => $e], 500);
		}
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
