<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Rssfeed;

class ParsingRssTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    public function last_build_date_can_be_saved()
    {
        $url = $this->faker->url('php://memory');
        //$title  = $this->faker->title();
        
        $memoryStream = fopen('php://memory', 'rw+');
        
        
        //create any carbon date
        fwrite($memoryStream, $this->fakeXMLFeed());
        
        $rss = Rssfeed::factory()->create();
        
        
        //change carbon date
        $rss->checkUpdate();

        //check if it is XML
        $this->assertDatabaseHas('rss_feeds', $data);
        
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
