<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParseRss
{
    use Dispatchable, SerializesModels;
    
    public $rss;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($rss)
    {
    
        $this->rss = $rss;
    }

}
