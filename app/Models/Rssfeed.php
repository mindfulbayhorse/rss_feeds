<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \App\Models\User;

class Rssfeed extends Model
{
	use HasFactory;
	
      //table name
    protected $table = 'rss_feeds';
    
    protected $guarded = [];
    
    public $timestamps = false;
    
    public function isActual($date){
    	
    	return $date == strtotime($this->updated_at);
    }
    
    public function findByURL($query, $url){
    	
    	return $query->where('url', $url);
    	
    }
    
    public function user(){
    	
    	return $this->belongsTo(User::class);
    }
    
    public function category(){
    	
    	return $this->belongsTo(Category::class);
    }
    
}
