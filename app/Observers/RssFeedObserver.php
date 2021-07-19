<?php

namespace App\Observers;

use App\Models\Rssfeed;
use App\Jobs\NotifyAfterFeedUpdate;
use App\Jobs\ProcessRss;

class RssFeedObserver
{
    /**
     * Handle the Rssfeed "created" event.
     *
     * @param  \App\Models\Rssfeed  $rssfeed
     * @return void
     */
    public function created(Rssfeed $rssfeed)
    {
        ProcessRss::dispatch($rssfeed);
    }

    /**
     * Handle the Rssfeed "updated" event.
     *
     * @param  \App\Models\Rssfeed  $rssfeed
     * @return void
     */
    public function updated(Rssfeed $rssfeed)
    {

    }
    
    public function updating(Rssfeed $rssfeed)
    {
        
        if ($rssfeed->isDirty('last_update')){
            NotifyAfterFeedUpdate::dispatch($rssfeed->user);
        }
    }

    /**
     * Handle the Rssfeed "deleted" event.
     *
     * @param  \App\Models\Rssfeed  $rssfeed
     * @return void
     */
    public function deleted(Rssfeed $rssfeed)
    {
        //
    }

    /**
     * Handle the Rssfeed "restored" event.
     *
     * @param  \App\Models\Rssfeed  $rssfeed
     * @return void
     */
    public function restored(Rssfeed $rssfeed)
    {
        //
    }

    /**
     * Handle the Rssfeed "force deleted" event.
     *
     * @param  \App\Models\Rssfeed  $rssfeed
     * @return void
     */
    public function forceDeleted(Rssfeed $rssfeed)
    {
        //
    }
}
