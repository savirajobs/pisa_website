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
use Mews\Captcha\Facades\Captcha;


class FeedbackController extends Controller
{
    function index()
    {
        $categories = FeedbackCategory::all();
        return view('front.feedback.feedback', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        session_start(); 
        // Validator
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email',
            'phone'    => 'required|regex:/^[0-9]{10,15}$/',
            'title'    => 'required',
            'message'  => 'required',
            'captcha' => 'required|captcha'
        ], [
            'required' => ':attribute wajib diisi.',
            'email'    => 'Format :attribute tidak valid.',
            'phone.regex' => 'Nomor Whatsapp harus terdiri dari 10 hingga 15 digit angka.',
            'captcha'   => 'Captcha telah kedaluwarsa atau tidak sesuai, silahkan reload captcha.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // To set slug with -
        $slug = Str::of($request->title)->slug('-');
        $originalSlug = $slug;

        // Validator slug is already exist or not
        if (Feedback::where('slug', $slug)->exists()) {
            if (Feedback::where('phone', $request->phone)->exists()) {
                return response()->json(['error' => 'Konsultasi atau Pengaduan sudah terdaftar'], 500);
            } else {
                $count = DB::table('feedbacks')->where('slug', $slug)->count();
                $counter = $count + 1;
                $slug = $originalSlug . '-' . $counter;
            }
        } else {
            $slug = Str::of($request->title)->slug('-');
        }

        try {
            DB::table('feedbacks')->insert([
                'feedback_title' => $request->title,
                'slug' => $slug,
                'sender_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'feedback_category' => $request->category,
                'feedback_desc' => $request->message,
                'spam_status' => 0,
                'duplication_status' => 0,
                'created_at' => now()
            ]);

            // $this->createAndStoreOTP($request->phone);
            $webServiceController = new WebServiceController();
            $webServiceController->createAndStoreOTP($request->phone);

            return response()->json([
                'otp_phone' => $request->phone
            ]);
            // return response()->json(['success' => 'Feedback berhasil terkirim.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengirim feedback.'], 500);
        }
    }
}
