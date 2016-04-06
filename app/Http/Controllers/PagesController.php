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
        $firstName = 'Luke';
        $lastName = 'Skywalker';
        return view('pages.about', compact('firstName', 'lastName'));
    }
}
