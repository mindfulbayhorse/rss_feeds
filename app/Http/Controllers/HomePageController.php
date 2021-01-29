<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suite\Jwplayer;

class HomePageController extends Controller
{
    
    
    public function show(Jwplayer $jwplayer){

        return view('welcome', compact('jwplayer'));
    }
}
