<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class PagenationController extends Controller
{
    function index()
    {
        $data = DB::table('winnumbers')->paginate(23);
        return view('winnumbers', compact('data'));
    }
}
