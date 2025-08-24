<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class WebCarController extends Controller
{
    public function loginForm() { return view('auth.login'); }
    public function index()     { return view('cars.index'); }
}
