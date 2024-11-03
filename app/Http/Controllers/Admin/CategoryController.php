<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;
use Carbon\Carbon;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function apis(Request $request)
    {
        $category = Category::select([
            'categories.category_id',
            'categories.category_name',
            'categories.slug',
            'users.name',
            'categories.created_at',
            'categories.updated_at'
        ])
            ->join('users', 'categories.created_by', '=', 'users.id');

        return DataTables::of($category)
            ->addColumn('action', function ($row) {
                $deleteButton = $row->category_id == 99
                    ? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-database-x"></i></button>'
                    : '<button data-id="' . $row->category_id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-trash3"></i></button>';

                return '
                <button data-id="' . $row->category_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-pencil-square"></i></button>
                ' . $deleteButton . '
            ';
            })
            ->editColumn(
                'created_at',
                function ($category) {
                    $date = Carbon::parse($category->created_at);
                    return $date->format('Y-m-d');
                }
            )
            ->editColumn(
                'updated_at',
                function ($category) {
                    $date = Carbon::parse($category->update_at);
                    return $date->format('Y-m-d');
                }
            )
            ->rawColumns(['action'])
            ->make(true);
    }


    public function index()
    {
        if (Auth::user()->role == 'super-admin') {
            return view('admin.category.index');
        } else {

            return redirect('admin.dashboard');
        }
        // return view('admin.category.index');
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
        // Validator
        $validator = Validator::make($request->all(), [
            'category_name'     => 'required',
            'slug'              => 'required',
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

        if (Category::where('slug', $request->slug)->exists()) {
            return response()->json(['error' => 'Slug Name is already exists, please use another slug'], 500);
        }

        try {
            DB::table('categories')->insert([
                'category_name' => $request->category_name,
                'slug' => $request->slug,
                'created_by' => 1
            ]);

            return response()->json(['success' => 'Category has been added successfully.']);
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
    public function edit(Request $request)
    {
        $category_id = $request->category_id;
        $category = Category::where('category_id', $category_id)->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name'    => 'required',
            'slug'     => 'required'
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

        try {
            $affected = DB::table('categories')
                ->where('category_id', $request->category_id)
                ->update([
                    'category_name' => $request->category_name,
                    'slug'          => $request->slug
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $deleted = DB::table('categories')->where('category_id', '=', $request->category_id)->delete();

            // Jika berhasil dihapus, kembalikan respon sukses
            return response()->json([
                'success' => 'Category has been deleted successfully.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Jika user tidak ditemukan, tangani error ini
            return response()->json([
                'error' => 'Post not found.'
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
