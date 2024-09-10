<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    function index()
    {
        return view('front.index');
    }

    function profile()
    {
        return view('front.profile');
    }
}
