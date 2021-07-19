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
    
    public $timestamps = false;
    
    
    public function setLastUpdateAttribute($value) {
        
        if (!empty($value)) {
            $this->attributes['last_update'] = Carbon::createFromFormat('Y-m-d H:i:s', $value);
        } else {
            $this->attributes['last_update'] = $value;
        }
       
    }
    
    public function getLastUpdateAttribute($value) {
       
        if (!empty($value)) return Carbon::parse($value);
        
        return null;
    }
    
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
    
    /*public function checkLastUpdate()
    {
        $reader = new \XMLReader();
        
        try {
            $result = $reader->open($this->url);
            
            if (!$result) {
                return false;
            }
            
            while ($reader->read()) {
                if ($reader->name === 'lastBuildDate') {
                    $rssUpdate = $reader->readString();
                    break;
                }
            }
            
            if (!$rssUpdate) {
                $reader->close();
                return false;
            }
            
            $reader->close();
        } catch (\ErrorException $e){
            
            return false;
        }
       
        $updatingDate = Carbon::createFromFormat(\DateTime::RSS, $rssUpdate);

        if (!is_null($this->last_update)){
            if ($this->last_update->equalTo($updatingDate)){
                return false;
            } 
        }
        
        $this->last_update=$updatingDate;
 
        $this->save();
        return true;
    }*/
    
}
