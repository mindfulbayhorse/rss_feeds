<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Rssfeed;
use App\Models\User;
use Carbon\Carbon;
use App\Jobs\ProcessRss;

class ParsingRssTest extends TestCase
{
    use WithFaker;
    
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
        
        
        $this->rss = Rssfeed::factory()
            ->for(User::factory())
            ->create(['url'=>url($this->testFolder.'/'.$this->xmlPath)]);
    }
    
    /** @test */
    public function last_build_date_can_be_saved()
    {
        $this->withoutExceptionHandling();
        //check if it is XML
        $this->assertDatabaseHas('rss_feeds', [
            'id'=>$this->rss->id,
            'last_update' => $this->updatingDate->toDateTimeString()
        ]);
        
        $this->updatingDate->addDay();

        $xml = fopen($this->xmlRss,'w');
        
        if ($xml) {
            fwrite($xml, $this->fakeXMLFeed($this->updatingDate->toRssString()));
            fclose($xml);
        }
        
        //change carbon date
        $this->rss->checkLastUpdate();
        
        $this->assertDatabaseHas('rss_feeds', [
            'id'=>$this->rss->id,
            'last_update' => $this->updatingDate->toDateTimeString()
        ]);

    }
    
    /** @test */
    public function notification_is_sent_after_last_rss_update()
    {
        //change carbon date
        $this->updatingDate->addDay();
        

        $xml = fopen($this->xmlRss, 'w');
        
        if ($xml) {
            fwrite($xml, $this->fakeXMLFeed($this->updatingDate->toRssString()));
            fclose($xml);
        }
  
        ProcessRss::dispatch($this->rss);
    }
    
    
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
        unlink($this->xmlRss);
        //if ($this->delete) unlink(public_path($this->testFolder));
    }
}
