<?php 
namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Suite\Jwplayer;

class JwPlayerFacade extends Facade{
    
    protected static function getFacadeAccessor()
    {
        return Jwplayer::class;
    }
}