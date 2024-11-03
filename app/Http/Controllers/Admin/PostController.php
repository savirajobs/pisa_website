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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    function apis(Request $request)
    {
        if (Auth::user()->role == 'super-admin') {
            $posts = Post::select([
                'posts.post_id',
                'posts.slug',
                'posts.post_title',
                'posttypes.type_desc',
                'categories.category_name',
                'users.name',
                'posts.is_publish',
                'posts.event_at',
                'posts.notes',
                'posts.created_at',
                'posts.created_by'
            ])
                ->join('posttypes', 'posts.post_type', '=', 'posttypes.type_id')
                ->leftjoin('categories', 'posts.category_id', '=', 'categories.category_id')
                ->join('users', 'posts.created_by', '=', 'users.id')
                ->where('is_publish', '=', '1')
                ->where('posttypes.type_id', '<>', 'MD')
                ->orderBy('post_id', 'desc');
        } else {
            $posts = Post::select([
                'posts.post_id',
                'posts.slug',
                'posts.post_title',
                'posttypes.type_desc',
                'categories.category_name',
                'users.name',
                'posts.is_publish',
                'posts.event_at',
                'posts.notes',
                'posts.created_at',
                'posts.created_by'
            ])
                ->join('posttypes', 'posts.post_type', '=', 'posttypes.type_id')
                ->leftjoin('categories', 'posts.category_id', '=', 'categories.category_id')
                ->join('users', 'posts.created_by', '=', 'users.id')
                ->where('is_publish', '=', '1')
                ->where('posttypes.type_id', '<>', 'MD')
                ->where('posts.created_by', '=', Auth::user()->id)
                ->orderBy('post_id', 'desc');
        }

        return DataTables::of($posts)
            ->addColumn('action', function ($row) {
                $deleteButton = $row->post_id == 1
                    ? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-trash3"></i></button>'
                    : '<button data-id="' . $row->post_id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-trash3"></i></button>';

                return '
                <button data-id="' . $row->post_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-pencil-square"></i></button>
                ' . $deleteButton . '
            ';
            })
            ->editColumn(
                'created_at',
                function ($posts) {
                    $date = Carbon::parse($posts->created_at);
                    return $date->format('d-m-Y');
                }
            )
            // ->editColumn(
            //     'upcoming_date',
            //     function ($posts) {
            //         $date = Carbon::parse($posts->upcoming_date);
            //         return $date->format('Y-m-d');
            //     }
            // )
            ->editColumn(
                'is_publish',
                function ($posts) {
                    if ($posts->is_publish == 1) {
                        return 'Yes';
                    } else {
                        return 'No';
                    }
                }
            )
            ->rawColumns(['action'])
            ->make(true);
    }

    function post_draft(Request $request)
    {
        if (Auth::user()->role == 'super-admin') {
            $posts = Post::select([
                'posts.post_id',
                'posts.slug',
                'posts.post_title',
                'posttypes.type_desc',
                'categories.category_name',
                'users.name',
                'posts.is_publish',
                'posts.event_at',
                'posts.notes',
                'posts.created_at',
                'posts.created_by'
            ])
                ->join('posttypes', 'posts.post_type', '=', 'posttypes.type_id')
                ->join('categories', 'posts.category_id', '=', 'categories.category_id')
                ->join('users', 'posts.created_by', '=', 'users.id')
                ->where('is_publish', '=', '0')
                ->where('posttypes.type_id', '<>', 'MD')
                ->orderBy('post_id', 'desc');
        } else {
            $posts = Post::select([
                'posts.post_id',
                'posts.slug',
                'posts.post_title',
                'posttypes.type_desc',
                'categories.category_name',
                'users.name',
                'posts.is_publish',
                'posts.event_at',
                'posts.notes',
                'posts.created_at',
                'posts.created_by'
            ])
                ->join('posttypes', 'posts.post_type', '=', 'posttypes.type_id')
                ->join('categories', 'posts.category_id', '=', 'categories.category_id')
                ->join('users', 'posts.created_by', '=', 'users.id')
                ->where('is_publish', '=', '0')
                ->where('posttypes.type_id', '<>', 'MD')
                ->where('posts.created_by', '=', Auth::user()->id)
                ->orderBy('post_id', 'desc');
        }

        return DataTables::of($posts)
            ->addColumn('action', function ($row) {
                $deleteButton = $row->post_id == 1
                    ? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-trash3"></i></button>'
                    : '<button data-id="' . $row->post_id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-trash3"></i></button>';

                return '
                <button data-id="' . $row->post_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-pencil-square"></i></button>
                ' . $deleteButton . '
            ';
            })
            ->editColumn(
                'created_at',
                function ($posts) {
                    $date = Carbon::parse($posts->created_at);
                    return $date->format('d-m-Y');
                }
            )
            // ->editColumn(
            //     'upcoming_date',
            //     function ($posts) {
            //         $date = Carbon::parse($posts->upcoming_date);
            //         return $date->format('Y-m-d');
            //     }
            // )
            ->editColumn(
                'is_publish',
                function ($posts) {
                    if ($posts->is_publish == 1) {
                        return 'Yes';
                    } else {
                        return 'No';
                    }
                }
            )
            ->rawColumns(['action'])
            ->make(true);
    }

    function post_all(Request $request)
    {
        if (Auth::user()->role == 'super-admin') {
            $posts = Post::select([
                'posts.post_id',
                'posts.slug',
                'posts.post_title',
                'posttypes.type_desc',
                'categories.category_name',
                'users.name',
                'posts.is_publish',
                'posts.event_at',
                'posts.notes',
                'posts.created_at',
                'posts.created_by'
            ])
                ->join('posttypes', 'posts.post_type', '=', 'posttypes.type_id')
                ->join('categories', 'posts.category_id', '=', 'categories.category_id')
                ->join('users', 'posts.created_by', '=', 'users.id')
                ->where('posttypes.type_id', '<>', 'MD')
                ->orderBy('post_id', 'desc');
        } else {
            $posts = Post::select([
                'posts.post_id',
                'posts.slug',
                'posts.post_title',
                'posttypes.type_desc',
                'categories.category_name',
                'users.name',
                'posts.is_publish',
                'posts.event_at',
                'posts.notes',
                'posts.created_at',
                'posts.created_by'
            ])
                ->join('posttypes', 'posts.post_type', '=', 'posttypes.type_id')
                ->join('categories', 'posts.category_id', '=', 'categories.category_id')
                ->join('users', 'posts.created_by', '=', 'users.id')
                ->where('posttypes.type_id', '<>', 'MD')
                ->where('posts.created_by', '=', Auth::user()->id)
                ->orderBy('post_id', 'desc');
        }

        return DataTables::of($posts)
            ->addColumn('action', function ($row) {
                $deleteButton = $row->post_id == 1
                    ? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-trash3"></i></button>'
                    : '<button data-id="' . $row->post_id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-trash3"></i></button>';

                return '
                <button data-id="' . $row->post_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-pencil-square"></i></button>
                ' . $deleteButton . '
            ';
            })
            ->editColumn(
                'created_at',
                function ($posts) {
                    $date = Carbon::parse($posts->created_at);
                    return $date->format('d-m-Y');
                }
            )
            // ->editColumn(
            //     'upcoming_date',
            //     function ($posts) {
            //         $date = Carbon::parse($posts->upcoming_date);
            //         return $date->format('Y-m-d');
            //     }
            // )
            ->editColumn(
                'is_publish',
                function ($posts) {
                    if ($posts->is_publish == 1) {
                        return 'Yes';
                    } else {
                        return 'No';
                    }
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
        $posttypes = PostType::select([
            'posttypes.type_id',
            'posttypes.type_desc'
        ])
            ->where('posttypes.type_id', '<>', 'PROFILE')
            ->orderBy('posttypes.type_id', 'desc')
            ->get();

        $categories = Category::select([
            'categories.category_id',
            'categories.category_name'
        ])
            ->whereNotIn('categories.category_name', ['Foto', 'Video'])
            ->orderBy('categories.category_id', 'desc')
            ->get();
        // $categories = Category::all();

        return view('admin.post.index', ['posttypes' => $posttypes, 'categories' => $categories]);
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
        // Start of Validator for input parameter
        $validator = Validator::make($request->all(), [
            'post_title'    => 'required',
            'post_type'     => 'required',
            //'category_id'   => 'required',
            'post_desc'     => 'required',
            'uploadImages.*' => 'required|mimes:jpg,jpeg,png|max:10240'
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
        // End of Validator for input parameter

        // To set slug with -
        $slug = Str::slug($request->post_title);
        $originalSlug = $slug;

        // Start of validator slug is already exist or not
        if (Post::where('slug', $slug)->exists()) {
            // Tambahkan counter ke slug jika sudah ada
            $count = DB::table('posts')->where('slug', $slug)->count();
            $counter = $count + 1;
            $slug = $originalSlug . '-' . $counter;
        } else { // To set slug with -
            $slug = Str::slug($request->post_title);
        }

        // Get last number range
        $id = numberrange::select(['type', 'from', 'to', 'current'])
            ->where('type', '=', $request->post_type)->first();

        if ($id->current == 0) {
            $post_id = $request->post_type . $id->from;
            $number = $id->from;
        } else {
            $post_id = $request->post_type . $id->current + 1;
            $number = $id->current + 1;
        }

        // To update number range
        numberrange::where('type', $request->post_type)
            ->update([
                'current' => $number,
            ]);

        $date = Carbon::now();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $extension = $image->getClientOriginalExtension();
                $name = date('dmY') . '_' . uniqid() . '_' . $post_id . '.' . $extension;

                DB::table('media')->insert([
                    'post_id' => $post_id,
                    'file_name' => $name,
                    'created_by' => Auth::user()->id,
                    'created_at' => $date
                ]);

                $image->move(public_path('images'), $name);
            }
        } else {
            $name = $request->images;
        }

        try {
            Post::create([
                'post_id'       => $post_id,
                'post_title'    => $request->post_title,
                'slug'          => $slug,
                'post_desc'     => $request->post_desc,
                'post_type'     => $request->post_type,
                'is_publish'    => $request->is_publish,
                'category_id'   => $request->category_id,
                'event_at'      => $request->event_date,
                'notes'         => $request->notes,
                'created_by'    => Auth::user()->id,
                'created_at'    => $date
            ]);

            // return response()->json(['success' => $name]);
            return response()->json(['success' => 'Post has been added successfully.']);
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

        return response()->json($post);
    }

    public function media(Request $request)
    {
        $post_id = $request->post_id;
        $photos = DB::table('media')->where('post_id', $post_id)->get();

        return response()->json($photos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_title'    => 'required',
            'slug'          => 'required',
            'post_type'     => 'required',
            'category_id'   => 'required',
            'post_desc'     => 'required',
            'is_publish'    => 'required'
            //'published_at'  => 'required',
            //'upcoming_date' => 'required'
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

        //dd($request)->all();

        //check duplication slug
        if ($request->old_slug != $request->slug) {
            if (Post::where('slug', $request->slug)->exists()) {
                return response()->json(['error' => 'Slug is already exists, please use another slug'], 500);
            }
        }

        // DELETE ON PHOTOS
        if ($request->has('deleted_photos')) {
            $deletedPhotos = explode(',', $request->deleted_photos);
            foreach ($deletedPhotos as $photoId) {
                // $photo = Photos::find($photoId);
                $photo = DB::table('media')->where('media_id', $photoId)->first();
                if ($photo) {
                    $filePath = public_path('images/' . $photo->file_name);
                    if (file_exists($filePath) && is_file($filePath)) {
                        unlink($filePath);
                    }
                    $deleted = DB::table('media')->where('media_id', '=', $photoId)->delete();
                }
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $extension = $photoFile->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '_' . $request->post_id . '.' . $extension;

                DB::table('media')->insert([
                    'post_id' => $request->post_id,
                    'file_name' => $filename,
                    'created_by' => Auth::user()->id
                ]);

                $photoFile->move(public_path('images'), $filename);
            }
        } else {
            $filename = $request->photos;
        }

        $date = Carbon::now();

        try {
            $affected = DB::table('posts')
                ->where('post_id', $request->post_id)
                ->update([
                    'post_title'    => $request->post_title,
                    'slug'          => $request->slug,
                    'post_type'     => $request->post_type,
                    'category_id'   => $request->category_id,
                    'post_desc'     => $request->post_desc,
                    'is_publish'    => $request->is_publish,
                    'event_at'      => $request->event_date,
                    'notes'         => $request->notes,
                    'updated_by'    => Auth::user()->id,
                    'updated_at'    => $date
                ]);

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
    public function destroy(Request $request)
    {
        try {
            $mediadelete = DB::table('media')->where('post_id', $request->post_id)
                ->select('media_id', 'file_name')
                ->get();

            foreach ($mediadelete as $photo) {
                $filePath = public_path('images/' . $photo->file_name);
                if (file_exists($filePath) && is_file($filePath)) {
                    unlink($filePath);
                }
                $deleted = DB::table('media')->where('media_id', '=', $photo->media_id)->delete();
            }

            $deleted = DB::table('posts')->where('post_id', '=', $request->post_id)->delete();

            // Jika berhasil dihapus, kembalikan respon sukses
            return response()->json([
                'success' => 'Post has been deleted successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika user tidak ditemukan, tangani error ini
            return response()->json([
                'error' => 'Post not found.'
            ], 404);
        } catch (\Exception $e) {
            // Jika terjadi error lain, tangani di sinis
            return response()->json([
                // 'error' => 'Failed to delete Post. Please try again later.'
                'error' => $e
            ], 500);
        }
    }
}
