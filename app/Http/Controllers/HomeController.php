<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    // Home
    public function index()
    {
        return view('home.index');
    }
}
