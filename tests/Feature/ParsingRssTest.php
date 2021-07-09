<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Rssfeed;
use App\Models\User;
use Carbon\Carbon;

class ParsingRssTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    public function last_build_date_can_be_saved()
    {
        
        $memoryStream = fopen('php://memory', 'rw');
        $dateCreated = Carbon::now();
        
        //create any carbon date
        fwrite($memoryStream, $this->fakeXMLFeed($dateCreated->toRssString()));
        
        $rss = Rssfeed::factory()->for(User::factory())->create(['url'=>'php://memory']);
        
        //check if it is XML
        $this->assertDatabaseHas('rss_feeds', [
            'id'=>$rss->id,
            'last_update' => $dateCreated->toDateTimeString()
        ]);
        
        $dateCreated->addDay();
        
        fwrite($memoryStream, $this->fakeXMLFeed($dateCreated->toRssString()));
        
        //change carbon date
        $rss->checkLastUpdate();
        
        $this->assertDatabaseHas('rss_feeds', [
            'id'=>$rss->id,
            'last_update' => $dateCreated->toDateTimeString()
        ]);
        
    }
    
    
    function fakeXMLFeed($buildDate){
        
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
}
