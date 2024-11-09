<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feedback;
use App\Models\numberrange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    function consultation(Request $request)
    {
        $feedback = DB::table('feedbacks')->where('feedback_category', 1)->orderBy('created_at', 'desc')->get();

        return DataTables::of($feedback)
            ->addColumn('action', function ($row) {
                return '
                <button data-id="' . $row->feedback_id . '" class="btn btn-sm btn-warning reply-btn"><i class="bi bi-chat-left-text"></i></button>
            ';
            })

            ->addColumn('is_new', function ($row) {
                // Menghitung apakah `created_at` kurang dari atau sama dengan 3 hari dari hari ini
                return $row->created_at >= Carbon::now()->subDays(3);
            })

            ->editColumn(
                'created_at',
                function ($feedback) {
                    $date = Carbon::parse($feedback->created_at);
                    return $date->format('d-m-Y');
                }
            )

            ->rawColumns(['action'])
            ->make(true);
    }

    function complaint(Request $request)
    {
        $feedback = DB::table('feedbacks')->where('feedback_category', 2)->get();

        return DataTables::of($feedback)
            ->addColumn('action', function ($row) {
                return '
                <button data-id="' . $row->feedback_id . '" class="btn btn-sm btn-warning reply-btn"><i class="bi bi-chat-left-text"></i></button>
            ';
            })

            ->addColumn('is_new', function ($row) {
                return $row->created_at >= Carbon::now()->subDays(3);
            })

            ->editColumn(
                'created_at',
                function ($feedback) {
                    $date = Carbon::parse($feedback->created_at);
                    return $date->format('d-m-Y');
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
        return view('admin.feedback.index');
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
        $feedback_id = $request->feedback_id;
        $feedback = DB::table('feedbacks')->where('feedback_id', $feedback_id)->first();

        return response()->json([
            'status'    => 'success',
            'data'      => $feedback
        ]);
    }

    public function getReply(Request $request)
    {
        $feedback_id = $request->feedback_id;
        $reply = DB::table('replies')->where('feedback_id', $feedback_id)->first();

        return response()->json($reply);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'is_spam'   => 'required',
        //     'is_duplicate'  => 'required'
        //     //'reply'     => 'required',
        // ], [
        //     'required' => ':attribute wajib diisi.',
        // ]);

        // if (DB::table('replies')->where('feedback_id', $request->feedback_id)->exists()) {
        //     return response()->json(['error' => 'You replied this feedback already']);
        // }

        // $created_at = Carbon::now();

        // // Get last number range
        // $id = numberrange::select(['type', 'from', 'to', 'current'])
        //     ->where('type', '=', 'RP')->first();
        // if ($id->current == 0) {
        //     $reply_id = 'RP' . $id->from;
        //     $number = $id->from;
        // } else {
        //     $reply_id = 'RP' . $id->current + 1;
        //     $number = $id->current + 1;
        // }

        // DB::table('numberrange')
        //     ->where('type', 'RP')
        //     ->update(['current' => $number]);

        // DB::table('feedbacks')
        //     ->where('feedback_id', $request->feedback_id)
        //     ->update(['reply_status' => 1]);

        // try {
        //     DB::table('replies')->insert([
        //         'reply_id'      => $reply_id,
        //         'feedback_id'   => $request->feedback_id,
        //         'reply_desc'    => $request->reply,
        //         'created_at'    => $created_at
        //     ]);

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Reply sent'
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $request->reply], 500);
        // };

        // try {
        //     DB::table('feedbacks')
        //         ->where('feedback_id', $request->feedback_id)
        //         ->update([
        //             'spam_status'   => $request->spam_status,
        //             'updated_at'    => now()
        //         ]);

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Feedback updated successfully'
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'An error occurred while updating Feedback'
        //     ], 500);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
