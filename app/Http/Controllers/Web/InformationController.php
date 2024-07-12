<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    //
    public function index($slug)
    {
        return view('web_v2.pages.information', compact('slug'));
    }
}
