<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Events\ParseRss;
use Carbon\Carbon;

class Rssfeed extends Model
{
	use HasFactory;
	
      //table name
    protected $table = 'rss_feeds';
    
    protected $guarded = [];
    
    protected $dispatchesEvents = [
        'created' => ParseRss::class
    ];
    
    public $timestamps = false;
    
    public function isActual($date){
    	
    	return $date == strtotime($this->updated_at);
    }
    
    public function findByURL($query, $url)
    {
    	
    	return $query->where('url', $url);
    	
    }
    
    public function user()
    {
    	
    	return $this->belongsTo(User::class);
    }
    
    public function category()
    {
    	
    	return $this->belongsTo(Category::class);
    }
    
    public function add($user = null)
    {
        
        $this->user_id = $user ? $user->id : auth()->id;
        
        $this->save();
    }
    
    public function checkLastUpdate()
    {
        $reader = new \XMLReader();
        $result = $reader->open($this->url);
        
        if (!$result) {
            $reader->close();
            return;
        }
        
        while ($reader->read()) {
            if ($reader->name === 'lastBuildDate') {
                $rssUpdate = $reader->readString();
                break;
            }
        }
        
        if (!$rssUpdate) {
            $reader->close();
            return;
        }
        
        $reader->close();
        
        $this->last_update=Carbon::createFromFormat(\DateTime::RSS, $rssUpdate);
        $this->save();
    }
    
}
