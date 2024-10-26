<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use App\Models\Media;
use App\Models\numberrange;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{

    function apis(Request $request)
    {
        $posts = Post::select([
            'posts.post_id',
            'posts.post_title',
            'posts.slug',
            'posts.post_desc',
            'posts.post_type',
            'posts.created_at',
            'posts.created_by',
            'users.name',
            DB::raw("CASE WHEN posts.is_publish = 1 THEN 'Ya' ELSE 'Tidak' END as is_publish"),
            DB::raw('MIN(media.media_id) as media_id')
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->join('media', 'posts.post_id', '=', 'media.post_id')
            // ->where(DB::raw('posts.post_type'), '=', DB::raw("'MD'"))
            ->where('posts.post_type', '=', 'MD')
            ->WHERE('posts.category_id', '=', 6)
            ->groupBy('posts.post_id', 'posts.post_title', 'posts.slug', 'posts.post_desc', 'posts.post_type', 'posts.created_at', 'posts.created_by', 'users.name', 'posts.is_publish')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        // $sqlQuery = $posts->toSql();
        // dd($sqlQuery);

        return DataTables::of($posts)
            ->addColumn('action', function ($posts) {
                $btn = '';

                $btn .= '
                        <a data-id="' . $posts['post_id'] . '" href="#" class="btn btn-warning btn-sm btn-edit" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                        </a>
                        <a data-id="' . $posts['post_id'] . '" href="#" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                        <i class="bi bi-trash3"></i>
                        </a> 
';
                return $btn;
            })
            ->editColumn(
                'created_at',
                function ($posts) {
                    $date = Carbon::parse($posts->created_at);
                    return $date->format('d-m-Y');
                }
            )
            ->rawColumns(['action', 'created_at'])
            ->make(true);
    }

    function getVideo(Request $request)
    {
        $videos = Post::select([
            'posts.post_id',
            'posts.post_title',
            'posts.slug',
            'posts.post_desc',
            'posts.post_type',
            'posts.created_at',
            'posts.created_by',
            'users.name',
            DB::raw("CASE WHEN posts.is_publish = 1 THEN 'Ya' ELSE 'Tidak' END as is_publish"),
            DB::raw('MIN(media.media_id) as media_id')
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->join('media', 'posts.post_id', '=', 'media.post_id')
            // ->where(DB::raw('posts.post_type'), '=', DB::raw("'MD'"))
            ->where('posts.post_type', '=', 'MD')
            ->where('posts.category_id', '=', 7)
            ->groupBy('posts.post_id', 'posts.post_title', 'posts.slug', 'posts.post_desc', 'posts.post_type', 'posts.created_at', 'posts.created_by', 'users.name', 'posts.is_publish')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        // $sqlQuery = $posts->toSql();
        // dd($sqlQuery);

        return DataTables::of($videos)
            ->addColumn('action', function ($videos) {
                $btn = '';

                $btn .= '
                        <a data-id="' . $videos['post_id'] . '" href="#" class="btn btn-warning btn-sm btn-editVideo" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                        </a>
                        <a data-id="' . $videos['post_id'] . '" href="#" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                        <i class="bi bi-trash3"></i>
                        </a> 
';
                return $btn;
            })
            ->editColumn(
                'created_at',
                function ($videos) {
                    $date = Carbon::parse($videos->created_at);
                    return $date->format('d-m-Y');
                }
            )
            ->rawColumns(['action', 'created_at'])
            ->make(true);
    }

    function index()
    {
        return view('admin.gallery.index');
    }

    public function store(Request $request)
    {
        if ($request->category_id == 6){
            $validator = Validator::make($request->all(), [
                'post_title'        => 'required|string|max:100',
                'post_desc'         => 'nullable|string|max:100',
                'uploadImages.*'    => 'required|mimes:jpg,jpeg,png|max:10240',
                'is_publish'        => 'required'
            ], [
                'required' => ':attribute wajib diisi.',
                'string'   => ':attribute harus berupa teks.',
                'max'      => ':attribute tidak boleh lebih dari :max karakter.',
                'email'    => 'Format :attribute tidak valid.',
                'unique'   => ':attribute sudah terdaftar.',
                'min'      => ':attribute harus memiliki minimal :min karakter.',
            ]);
        }else{
            $validator = Validator::make($request->all(), [
                'post_title'        => 'required|string|max:100',
                'post_desc'         => 'nullable|string|max:100',
                'videos.*'          => 'required|mimes:mp4,avi,mpeg4|max:20480',
                'is_publish'        => 'required'
            ], [
                'required' => ':attribute wajib diisi.',
                'string'   => ':attribute harus berupa teks.',
                'max'      => ':attribute tidak boleh lebih dari :max karakter.',
                'email'    => 'Format :attribute tidak valid.',
                'unique'   => ':attribute sudah terdaftar.',
                'min'      => ':attribute harus memiliki minimal :min karakter.',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $post_type = 'MD';

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
            ->where('type', '=', $post_type)->first();

        if ($id->current == 0) {
            $post_id = $post_type . $id->from;
            $number = $id->from;
        } else {
            $post_id = $post_type . $id->current + 1;
            $number = $id->current + 1;
        }

        // To update number range
        numberrange::where('type', $post_type)
            ->update([
                'current' => $number,
            ]);

        // Simpan data post
        $post = Post::create([
            'post_id'       => $post_id,
            'post_title'    => $request->post_title,
            'slug'          => $slug,
            //'slug'          => Str::of($request->post_title)->slug('-'),
            'post_desc'     => $request->post_desc,
            'post_type'     => $post_type,
            'is_publish'    => $request->is_publish,
            'category_id'   => $request->category_id,
            'created_by'    => Auth::user()->id,
            'created_at'    => now()
        ]);

        // Simpan data foto / video
        if ($request->category_id == 6){
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $extension = $image->getClientOriginalExtension();
                    $name = date('dmY') . '_' . uniqid() . '-' . $post_id . '.' . $extension;
                    $image->move(public_path('images'), $name);

                    Media::create([
                        'post_id'       => $post_id,
                        'file_name'     => $name,
                        'created_by'    => Auth::user()->id,
                        'created_at'    => now()
                    ]);
                }
                // return redirect()->route('admin.gallery.index');
                return response()->json(['success' => 'Media has been added successfully.']);
            }
        }else{
            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {
                    $extension = $video->getClientOriginalExtension();
                    $name = date('dmY') . '_' . uniqid() . '-' . $post_id . '.' . $extension;
                    $video->move(public_path('videos'), $name);

                    Media::create([
                        'post_id'       => $post_id,
                        'file_name'     => $name,
                        'created_by'    => Auth::user()->id,
                        'created_at'    => now()
                    ]);
                }
                // return redirect()->route('admin.gallery.index');
                return response()->json(['success' => 'Media has been added successfully.']);
            }
        }

        return redirect()->back()->with('error', 'Failed to insert to the database');
    }

    //Show the form for editing the specified resource. 
    function edit(Request $request)
    {
        $post = Post::where('post_id', $request->id)->first();
        return response()->json($post);
    }

    function media(Request $request)
    {
        $media = Media::where('post_id', $request->id)->get();
        return response()->json($media);
    }

    public function update(Request $request)
    {
        //validate form
        $validator = Validator::make($request->all(), [
            'title'         => 'required|max:100',
            'desc'          => 'required|nullable|string|max:100',
            'images.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_publish'    => 'required',
            // 'old_slug'      => 'required',
        ], [
            'required' => ':attribute wajib diisi.',
            'string'   => ':attribute harus berupa teks.',
            'max'      => ':attribute tidak boleh lebih dari :max karakter.',
            'email'    => 'Format :attribute tidak valid.',
            'unique'   => ':attribute sudah terdaftar.',
            'min'      => ':attribute harus memiliki minimal :min karakter.',
        ]);

        // dd($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //check duplication slug
        if ($request->old_slug != $request->slug) {
            if (Post::where('slug', $request->slug)->exists()) {
                return response()->json(['error' => 'Slug is already exists, please use another slug'], 500);
            }
        }

        //update header table posts
        Post::where('post_id', $request->post_id)
            ->update([
                'post_title'    => $request->title,
                'slug'          => $request->slug,
                'post_desc'     => $request->desc,
                'is_publish'    => $request->is_publish,
                'updated_by'    => Auth::user()->id,
                'updated_at'    => now()
            ]);

        $post_id = $request->post_id;
        if ($request->category_id == 6){
            //add images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $extension = $image->getClientOriginalExtension();
                    $name = date('dmY') . '_' . uniqid() . '-' . $post_id . '.' . $extension;
                    $image->move(public_path('images'), $name);

                    Media::create([
                        'post_id'       => $post_id,
                        'file_name'     => $name,
                        'updated_by'    => Auth::user()->id,
                        'created_at'    => now()
                    ]);
                }
            }

            //delete images
            if ($request->has('deleted_images')) {
                $deletedImage = explode(',', $request->deleted_images);
                foreach ($deletedImage as $imageId) {
                    $image = DB::table('media')->where('media_id', $imageId)->first();
                    if ($image) {
                        $filePath = public_path('images/' . $image->file_name);
                        if (file_exists($filePath) && is_file($filePath)) {
                            unlink($filePath);
                        }
                        $deleted = DB::table('media')->where('media_id', '=', $imageId)->delete();
                    }
                }
            }
        }else{
            if ($request->hasFile('videos')) {
                $deleteVideo = DB::table('media')->where('post_id', $post_id)->first();
                if ($deleteVideo) {
                    $filePath = public_path('videos/' . $deleteVideo->file_name);
                    if (file_exists($filePath) && is_file($filePath)) {
                        unlink($filePath);
                    }
                    $deleted = DB::table('media')->where('post_id', '=', $post_id)->delete();
                }

                foreach ($request->file('videos') as $video) {
                    $extension = $video->getClientOriginalExtension();
                    $name = date('dmY') . '_' . uniqid() . '-' . $post_id . '.' . $extension;
                    $video->move(public_path('images'), $name);

                    Media::create([
                        'post_id'       => $post_id,
                        'file_name'     => $name,
                        'updated_by'    => Auth::user()->id,
                        'created_at'    => now()
                    ]);
                }
            }
        }
        return response()->json(['success' => true, 'message' => 'Gallery updated successfully']);
    }

    function destroy(Request $request)
    {
        try {
            $post_id = $request->id;

            $getCategory = DB::table('posts')->select('category_id')->where('post_id', '=', $post_id)->first();
            if($getCategory->category_id == 6){
                $media = Media::where('post_id', $post_id)->get();

                foreach ($media as $file_name) {
                    $filePath = public_path('images') . '/' . $file_name->file_name;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    DB::table('media')->where('media_id', '=', $file_name->media_id)->delete();
                }
            }else{
                $media = Media::where('post_id', $post_id)->get();

                foreach ($media as $file_name) {
                    $filePath = public_path('videos') . '/' . $file_name->file_name;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    DB::table('media')->where('media_id', '=', $file_name->media_id)->delete();
                }
            }

            DB::table('posts')->where('post_id', '=', $post_id)->delete();

            return response()->json(['message' => 'Gallery and associated images deleted successfully!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika gallery tidak ditemukan, tangani error ini
            return response()->json([
                'error' => 'Gallery not found.'
            ], 404);
        } catch (\Exception $e) {
            // Jika terjadi error lain, tangani di sini
            return response()->json([
                // 'error' => 'Failed to delete Post. Please try again later.'
                'error' => $e
            ], 500);
        }
    }
}
