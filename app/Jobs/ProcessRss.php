<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Rssfeed;
use Carbon\Carbon;

class ProcessRss implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rss;
    
    public $tries = 3;
    public $timeout = 5;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Rssfeed $rss)
    {
        $this->rss = $rss;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reader = new \XMLReader();
       
  
        $result = $reader->open($this->rss->url);
        
        if (!$result) {
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

        }
        
        $reader->close();
 
        $updatingDate = Carbon::createFromFormat(\DateTime::RSS, $rssUpdate);
        
        if (!is_null($this->rss->last_update)){
            if ($this->rss->last_update->equalTo($updatingDate)){
                return;
            }
        }
        
        $this->rss->last_update=$updatingDate;
        
        $this->rss->save();

    }
}
