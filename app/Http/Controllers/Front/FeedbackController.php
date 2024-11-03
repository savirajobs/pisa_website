<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\NumberRange;
use App\Models\Feedback;
use App\Models\FeedbackCategory;

class FeedbackController extends Controller
{
    function index()
    {
        $categories = FeedbackCategory::all();
        return view('front.feedback.feedback', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // Validator
        $validator = Validator::make($request->all(), [
            'fdb_name'     => 'required',
            'fdb_email'    => 'required|email',
            'fdb_phone'    => 'required|regex:/^[0-9]{10,15}$/',
            'fdb_title'    => 'required',
            'fdb_message'  => 'required',
        ], [
            'required' => ':attribute wajib diisi.',
            'email'    => 'Format :attribute tidak valid.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $post_type = 'FD';

        // To set slug with -
        $slug = Str::slug($request->post_title);
        $originalSlug = $slug;

        // Start of validator slug is already exist or not
        if (Feedback::where('slug', $request->slug)->exists()) {
            if (Feedback::where('phone', $request->fdb_phone)->exists()) {
                return response()->json(['error' => 'Konsultasi atau Pengaduan sudah terdaftar'], 500);
            } else {
                $count = DB::table('posts')->where('slug', $slug)->count();
                $counter = $count + 1;
                $slug = $originalSlug . '-' . $counter;
            }
        } else {
            $slug = Str::slug($request->post_title);
        }


        // // Get last number range
        // $id = NumberRange::select(['type', 'from', 'to', 'current'])
        //     ->where('type', '=', $post_type)->first();

        // if ($id->current == 0) {
        //     $post_id = $post_type . $id->from;
        //     $number = $id->from;
        // } else {
        //     $post_id = $post_type . $id->current + 1;
        //     $number = $id->current + 1;
        // }

        // // To update number range
        // NumberRange::where('type', $post_type)
        //     ->update([
        //         'current' => $number,
        //     ]);

        try {
            DB::table('feedbacks')->insert([
                'feedback_title' => $request->category_name,
                'slug' => $slug,
                'sender_name' => $request->fdb_name,
                'email' => $request->fdb_email,
                'phone' => $request->fdb_phone,
                'feedback_category' => $request->fdb_category,
                'feedback_desc' => $request->fdb_desc,
            ]);

            return response()->json(['success' => 'Feedback berhasil terkirim.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengirim feedback.'], 500);
        }
    }
}
