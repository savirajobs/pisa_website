<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContentController extends Controller
{
    function apis(Request $request)
	{
		$contents = Contents::select(['content_id', 'content_tittle', 'published_at', 'upcoming_date', 'created_by'])->orderBy('content_id', 'desc');

		return DataTables::of($contents)
			->addColumn('action', function ($row) {
				$deleteButton = $row->content_id == 1
					? '<button class="btn btn-sm btn-danger" disabled><i class="bi bi-person-x"></i></button>'
					: '<button data-id="' . $row->content_id . '" class="btn btn-sm btn-danger delete-btn"><i class="bi bi-person-x"></i></button>';

				return '
                <button data-id="' . $row->content_id . '" class="btn btn-sm btn-warning edit-btn"><i class="bi bi-person-gear"></i></button>
                ' . $deleteButton . '
            ';
			})
			->editColumn('published_at', function ($contents) {
				return $user->updated_at->format('Y-m-d H:i:s');
			}
            )
            ->editColumn('upcoming_date', function ($contents) {
				return $user->updated_at->format('Y-m-d H:i:s');
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
        return view('admin.post.index');
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
