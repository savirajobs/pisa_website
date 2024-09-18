<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\PostType;
use App\Models\Category;
use App\Models\numberrange;
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
					? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-building-x"></i></button>'
					: '<button data-id="' . $row->post_id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-building-x"></i></button>';

				return '
                <button data-id="' . $row->post_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-building-gear"></i></button>
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
					? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-building-x"></i></button>'
					: '<button data-id="' . $row->post_id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-building-x"></i></button>';

				return '
                <button data-id="' . $row->post_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-building-gear"></i></button>
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
					? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-building-x"></i></button>'
					: '<button data-id="' . $row->post_id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-building-x"></i></button>';

				return '
                <button data-id="' . $row->post_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-building-gear"></i></button>
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
        // Validator
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

        // Convert toggle on/off to value int
        if($request->is_publish == 'on' ){
            $is_publish = 1;
        }else{
            $is_publish = 0;
        }

        // To set slug with -
        $slug = \Str::replace(' ', '-', $request->post_title);
        
        // Get last number range
        $id = numberrange::select(['type', 'from', 'to', 'current'])
        ->where('type', '=', $request->post_type)->first();
        if($id->current == 0){
            $post_id = $request->post_type . $id->from;
            $number = $id->from;
        }else{
            $post_id = $request->post_type . $id->current + 1;
            $number = $id->current + 1;
        }

        // To update number range
        numberrange::where('type', $request->post_type)
             ->update(['current' => $number,
             ]);

		try {
			Post::create([
                'post_id'       => $post_id,
                'post_title'    => $request->post_title,
                'slug'          => $slug,
                'post_desc'     => $request->post_desc,
                'post_type'     => $request->post_type,
                'is_publish'    => $is_publish,
                'category_id'   => $request->category_id,
                'published_at'  => $request->published_at,
                'upcoming_date' => $request->upcoming_date,
                'created_by'    => 2
            ]);

			return response()->json(['success' => 'Post has been added successfully.']);
            // return response()->json(['success' => $request->is_publish]);

            // numberrange::where('type', $request->post_type)->update(['from' => $id->from, 'to' => $id->to, 'current' => $number]);

            // return response()->json(['success' => 'Post has been added successfully.']);
            // return response()->json(['success' => $request->is_publish]);
		} catch (\Exception $e) {
			return response()->json(['error' => $post_id], 500);
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
    public function edit(Request $request)
    {
        $post_id = $request->post_id;
        $post = Post::where('post_id', $post_id)->firstOrFail();

		return response()->json([
			'status' => 'success',
			'data' => $post
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
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
			return response()->json([
				'status' => 'error',
				'errors' => $validator->errors()
			], 422);
		}

        // Convert toggle on/off to value int
        if($request->is_publish == 'on' ){
            $is_publish = 1;
        }else{
            $is_publish = 0;
        }

        // To set slug with -
        $slug = \Str::replace(' ', '-', $request->post_title);

        try {
			$post = Post::findOrFail($request->post_id);

			$post->post_title  = $request->post_title;
            $post->slug = $slug;
			$post->post_type = $request->post_type;
			$post->category_id  = $request->category_id;
            $post->post_desc  = $request->post_desc;
            $post->is_publish  = $is_publish;
            $post->published_at  = $request->published_at;
            $post->upcoming_date  = $request->upcoming_date;

			$post->save();

			return response()->json([
				'status' => 'success',
				'message' => 'Post updated successfully'
			]);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 'error',
				'message' => 'An error occurred while updating Post'
			], 500);
		}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
