<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Events\ParseRss;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Rssfeed extends Model
{
	use HasFactory, Notifiable;
	
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
    
    public function routeNotificationForMail($notification)
    {
        return $this->user->email;
        
    }
    
    
}
