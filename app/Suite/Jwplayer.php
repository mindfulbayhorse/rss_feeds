<?php 
namespace App\Suite;

class Jwplayer{
    
    protected $key='';
    
    protected $secret='';
    
    public function __construct($apiKey, $apiSecret){
        
        $this->key=$apiKey;
        $this->secret=$apiSecret;
        
    }
    
}
?>