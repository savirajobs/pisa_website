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

class LawController extends Controller
{
    function apis(Request $request)
    {

        $posts = Post::select([
            'posts.post_id',
            'posts.slug',
            'posts.post_title',
            'categories.category_name',
            'users.name',
            'posts.is_publish',
            'posts.event_at',
            'posts.notes',
            'posts.created_at',
            'posts.created_by'
        ])
            ->leftjoin('categories', 'posts.category_id', '=', 'categories.category_id')
            ->join('users', 'posts.created_by', '=', 'users.id')
            //->where('is_publish', '=', '1')
            ->where('post_type', '=', 'LW')
            ->orderBy('post_id', 'desc');

        return DataTables::of($posts)
            ->addColumn('action', function ($row) {
                $btn = '';

                $btn .= '
                        <a data-id="' . $row['post_id'] . '" href="#" class="btn btn-warning btn-sm btn-edit" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                        </a>
                        <a data-id="' . $row['post_id'] . '" href="#" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                        <i class="bi bi-trash3"></i>
                        </a>';
                return $btn;
            })
            ->editColumn(
                'created_at',
                function ($posts) {
                    $date = Carbon::parse($posts->created_at);
                    return $date->format('d-m-Y');
                }
            )
            ->editColumn(
                'is_publish',
                function ($posts) {
                    if ($posts->is_publish == 1) {
                        return 'Ya';
                    } else {
                        return 'Tidak';
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
        return view('admin.law.index', ['page_title' => 'Law Management']);
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
            'uploadPdf.*' => 'required|mimes:pdf|max:10240'
        ], [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah terdaftar.',
            'min'      => ':attribute harus memiliki minimal :min karakter.',
            'max'      => ':attribute harus memiliki maximal :max karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // End of Validator for input parameter

        // dd($request);

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
            ->where('type', '=', 'LW')->first();

        if ($id->current == 0) {
            $post_id = 'LW' . $id->from;
            $number = $id->from;
        } else {
            $post_id = 'LW' . $id->current + 1;
            $number = $id->current + 1;
        }

        // To update number range
        numberrange::where('type', 'LW')
            ->update([
                'current' => $number,
            ]);

        $date = Carbon::now();

        if ($request->hasFile('mediaPdf')) {
            foreach ($request->file('mediaPdf') as $pdf) {
                $extension = $pdf->getClientOriginalExtension();
                $name = date('dmY') . '_' .  $post_id . '.' . $extension;

                DB::table('media')->insert([
                    'post_id' => $post_id,
                    'file_name' => $name,
                    'created_by' => Auth::user()->id,
                    'created_at' => $date
                ]);

                $pdf->move(public_path('pdf'), $name);
            }
        } else {
            $name = $request->pdf;
        }

        try {
            Post::create([
                'post_id'       => $post_id,
                'post_title'    => $request->post_title,
                'slug'          => $slug,
                'post_type'     => 'LW',
                'is_publish'    => $request->is_publish,
                'created_by'    => Auth::user()->id,
                'created_at'    => $date
            ]);

            return response()->json(['success' => 'Dasar Hukum berhasil ditambahkan.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan.'], 500);
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
        $getPdf = DB::table('media')->where('post_id', $post_id)->get();

        return response()->json($getPdf);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_title'    => 'required',
            'is_publish'    => 'required'
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

        // DELETE ON PDF
        if ($request->has('deleted_pdf')) {
            $deletedPdf = explode(',', $request->deleted_pdf);
            foreach ($deletedPdf as $pdfId) {
                $getPdf = DB::table('media')->where('media_id', $pdfId)->first();
                if ($getPdf) {
                    $filePath = public_path('pdf/' . $getPdf->file_name);
                    if (file_exists($filePath) && is_file($filePath)) {
                        unlink($filePath);
                    }
                    $deleted = DB::table('media')->where('media_id', '=', $pdfId)->delete();
                }
            }
        }

        if ($request->hasFile('pdf')) {
            foreach ($request->file('pdf') as $pdfFile) {
                $extension = $pdfFile->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '_' . $request->post_id . '.' . $extension;

                DB::table('media')->insert([
                    'post_id' => $request->post_id,
                    'file_name' => $filename,
                    'created_by' => Auth::user()->id
                ]);

                $pdfFile->move(public_path('pdf'), $filename);
            }
        } else {
            $filename = $request->pdf;
        }

        $date = Carbon::now();

        try {
            $affected = DB::table('posts')
                ->where('post_id', $request->post_id)
                ->update([
                    'post_title'    => $request->post_title,
                    'is_publish'    => $request->is_publish,
                    'updated_by'    => Auth::user()->id,
                    'updated_at'    => $date
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Law updated successfully'
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

            foreach ($mediadelete as $pdf) {
                $filePath = public_path('pdf/' . $pdf->file_name);
                if (file_exists($filePath) && is_file($filePath)) {
                    unlink($filePath);
                }
                $deleted = DB::table('media')->where('media_id', '=', $pdf->media_id)->delete();
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
