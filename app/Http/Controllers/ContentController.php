<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentType;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class ContentController extends Controller
{
    function apis(Request $request)
	{
		$contents = Content::select(['content_id', 'content_title', 'is_publish', 'published_at', 'upcoming_date', 'created_by'])->where('is_publish', '=', '1')->orderBy('content_id', 'desc');

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
                $date = Carbon::parse($contents->published_at); 
				return $date->format('Y-m-d');
			}
            )
            ->editColumn('upcoming_date', function ($contents) {
                $date = Carbon::parse($contents->upcoming_date); 
				return $date->format('Y-m-d');
			}
            )
			->rawColumns(['action'])
			->make(true);
	}

    function post_draft(Request $request)
	{
		$contents = Content::select(['content_id', 'content_title', 'is_publish', 'published_at', 'upcoming_date', 'created_by'])->where('is_publish', '=', '0')->orderBy('content_id', 'desc');

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
                $date = Carbon::parse($contents->published_at); 
				return $date->format('Y-m-d');
			}
            )
            ->editColumn('upcoming_date', function ($contents) {
                $date = Carbon::parse($contents->upcoming_date); 
				return $date->format('Y-m-d');
			}
            )
			->rawColumns(['action'])
			->make(true);
	}

    function post_all(Request $request)
	{
		$contents = Content::select(['content_id', 'content_title', 'is_publish', 'published_at', 'upcoming_date', 'created_by'])->orderBy('content_id', 'desc');

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
                $date = Carbon::parse($contents->published_at); 
				return $date->format('Y-m-d');
			}
            )
            ->editColumn('upcoming_date', function ($contents) {
                $date = Carbon::parse($contents->upcoming_date); 
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
        $contenttypes = ContentType::all();
        $categories = Category::all();
        return view('admin.post.index', ['page_title'=>'List content type','contenttypes'=>$contenttypes, 'categories'=>$categories]);
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
