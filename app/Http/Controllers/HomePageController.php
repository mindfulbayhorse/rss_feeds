<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    
    public function show(Request $request){

        return view('welcome', [ 'jwplayer' => app('jwplayer')]);
    }
}
