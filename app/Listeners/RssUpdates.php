<?php

namespace App\Listeners;

use App\Events\ParseRss;
use App\Jobs\ProcessRss;

class RssUpdates
{
    
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  ParseRss  $event
     * @return void
     */
    public function handle(ParseRss $event)
    {
        ProcessRss::dispatch($event->rss);
        //$event->rss->checkLastUpdate();

    }
}
