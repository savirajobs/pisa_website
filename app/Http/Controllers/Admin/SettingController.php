<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\Media;
use Carbon\Carbon;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function apis(Request $request)
    {
        $settingPage = Post::select([
            'posts.post_id',
            'posts.post_title',
            'posts.post_type',
            'posts.post_desc',
            'posts.updated_at',
            'users.name',
            'media.file_name'
        ])
            ->join('users', 'posts.created_by', '=', 'users.id')
            ->leftjoin('media', 'posts.post_id', '=', 'media.post_id')
            ->where('category_id', '=', 99)
            ->orderBy('updated_at', 'desc');

        return DataTables::of($settingPage)
            ->addColumn('action', function ($row) {
                return '
                <button data-id="' . $row->post_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-gear"></i></button>
            ';
            })
            ->editColumn(
                'updated_at',
                function ($settingPage) {
                    $date = Carbon::parse($settingPage->updated_at);
                    return $date->format('Y-m-d');
                }
            )
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        if (Auth::user()->role == 'super-admin') {
            return view('admin.setting.index');
        } else {

            return redirect('admin.dashboard');
        }
        // return view('admin.setting.index');
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
    public function store(Request $request)
    {
        //
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

    public function media(Request $request)
    {
        $image = Media::where('post_id', $request->post_id)->get();
        return response()->json($image);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'post_desc' => 'required'
            //'images.*'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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

        // DELETE ON PHOTOS
        // var_dump($request->deleted_photos);

        // if ($request->has('deleted_photos')) {
        if($request->deleted_photos){
            $photo = DB::table('media')->where('post_id', $request->post_id)->first();
            if ($photo) {
                $filePath = public_path('images/' . $photo->file_name);
                if (file_exists($filePath) && is_file($filePath)) {
                    unlink($filePath);
                }
                $deleted = DB::table('media')->where('post_id', '=', $request->post_id)->delete();
            }
        }

        if ($request->hasFile('images')) {
            $photo = DB::table('media')->where('post_id', $request->post_id)->first();
            if ($photo) {
                $filePath = public_path('images/' . $photo->file_name);
                if (file_exists($filePath) && is_file($filePath)) {
                    unlink($filePath);
                }
                $deleted = DB::table('media')->where('post_id', '=', $request->post_id)->delete();
            }

            foreach ($request->file('images') as $image) {
                $extension = $image->getClientOriginalExtension();
                $name = date('dmY') . '_' . uniqid() . '_' . $request->post_id . '.' . $extension;

                DB::table('media')->insert([
                    'post_id' => $request->post_id,
                    'file_name' => $name,
                    'created_by' => Auth::user()->id
                ]);

                $image->move(public_path('images'), $name);
            }
        } 

        $date = Carbon::now();

        try {
            $affected = DB::table('posts')
                ->where('post_id', $request->post_id)
                ->update([
                    'post_desc'     => $request->post_desc,
                    'updated_by'    => Auth::user()->id,
                    'notes'         => $request->embed_video,
                    'updated_at'    => $date
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Post updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating Post',
                'error' => $e->getMessage()
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
