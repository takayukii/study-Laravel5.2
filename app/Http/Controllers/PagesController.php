<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
    public function contact()
    {
        return view('contact');
    }
    
    public function about()
    {
        return view('pages.about');
    }
}
