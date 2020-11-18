<?php

namespace App\Http\Controllers;

use App\Models\Rssfeed;
use Illuminate\Http\Request;
use App\Models\Category;

class RssFeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rss = Rssfeed::all();
        
        return view('rss.index', compact('rss'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$categories = Category::all();
    	
    	return view('rss.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	Rssfeed::create($this->validate($request, [
    			'url' => 'required|url',
    			'user_id' =>'required',
    			'title' => 'nullable',
    			'category_id' => 'nullable'
    	]));
    	
    	return redirect('rss');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RssFeed  $rssFeed
     * @return \Illuminate\Http\Response
     */
    public function show(RssFeed $rssFeed)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RssFeed  $rssFeed
     * @return \Illuminate\Http\Response
     */
    public function edit(RssFeed $rssFeed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RssFeed  $rssFeed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RssFeed $rssFeed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RssFeed  $rssFeed
     * @return \Illuminate\Http\Response
     */
    public function destroy(RssFeed $rssFeed)
    {
        //
    }
}
