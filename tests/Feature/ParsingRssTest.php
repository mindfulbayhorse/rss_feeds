<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\Models\Rssfeed;
use App\Models\User;
use Carbon\Carbon;
use App\Jobs\ProcessRss;
use App\Notifications\FeedUpdated;
//use Illuminate\Support\Facades\Event;
//use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Bus;
use App\Jobs\NotifyAfterFeedUpdate;

class ParsingRssTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    private $delete = false;
    private $dateCreated;
    private $rss;
    private $xmlPath = 'test.xml';
    private $testFolder = 'test';
    private $updatingDate;
    private $xmlRss;
    
    protected function setUp():void
    {
        parent::setUp();
        
        if (!file_exists(public_path($this->testFolder))){
            mkdir(public_path($this->testFolder));
            $this->delete = true;
        }
        
        $this->xmlRss = public_path($this->testFolder.'\\'.$this->xmlPath);
        $xml = fopen($this->xmlRss, 'w');
        $this->updatingDate = Carbon::now();
        
        if ($xml){
            //create any carbon date
            fwrite($xml, $this->fakeXMLFeed($this->updatingDate->toRssString()));
            
            fclose($xml);
        }
        
        $this->withoutEvents();
        
        //job faking
        $this->rss = Rssfeed::factory()
            ->for(User::factory())
            ->create(['url'=>url($this->testFolder.'/'.$this->xmlPath)]);
            
    }
    
    
    /** @test */
    public function last_build_date_can_be_saved()
    {
        
        ProcessRss::dispatchNow($this->rss);
        
        //check if it is XML
        $this->assertDatabaseHas('rss_feeds', [
            'id'=>$this->rss->id,
            'last_update' => $this->updatingDate->toDateTimeString()
        ]);

    }
    
    /** @test */
    public function notification_is_sent_after_last_rss_update()
    {
        
        Notification::fake();
        
        //$this->rss->user->notify(new FeedUpdated);
        $this->rss->last_update = $this->updatingDate;
        $this->rss->save();
        
        Notification::assertSentTo(
            [$this->rss], FeedUpdated::class
            );
    }

    
    /** @test */
    public function creating_rss_feed_generates_parsing()
    {
        //Queue::fake();
        
        Bus::fake();
        
        //job faking
        $this->rss = Rssfeed::factory()
            ->for(User::factory())
            ->create(['url'=>url($this->testFolder.'/'.$this->xmlPath)]);
        
        Bus::assertDispatched(ProcessRss::class);
            
    }
    
    /*
     * creating testing xml
     */
    private function fakeXMLFeed($buildDate){
        
        $rssExample = '<?xml version="1.0" encoding="UTF-8"?>'.
            '<rss version="2.0">'.
                '<channel>'.
                	'<title>Food Recalls &#8211; Food Safety News</title>'.
                	'<link>https://www.foodsafetynews.com</link>'.
                	'<description>Breaking news for everyone&#039;s consumption</description>'.
                	'<lastBuildDate>'.$buildDate.'</lastBuildDate>'.
                	'<language>en-US</language>'.
                  '</channel>'.
            '</rss>';
        
        return $rssExample;
        
    }
    
    
    protected function tearDown(): void
    {
        parent::tearDown();
        //unlink($this->xmlRss);
        //if ($this->delete) unlink(public_path($this->testFolder));
    }
}
