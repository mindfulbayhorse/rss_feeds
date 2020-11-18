<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\Models\User;
use \App\Models\Rssfeed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\MailTrack;

class RSSFeedTest extends TestCase
{
	use RefreshDatabase, WithFaker, MailTrack;
	
	public $user;
	
	protected function setUp(): void
	{
		parent::setUp();
		
		$this->user = User::factory()->create();
		
		$this->actingAs($this->user);
			
	}
		
    /** @test */
    public function user_can_subscribe_to_feed()
    {
    	
    	$feed = Rssfeed::factory()->make([
    		'url'=>'https://www.foodsafetynews.com/food-recalls/feed/'
    	]);
    	
    	$this->user->addFeed($feed);
    	
    	$this->assertDatabaseHas('rss_feeds', $feed->ToArray());
    }
    
    /** @test */
    public function feed_can_be_checked_for_updating()
    {
    	$dateFeedCreated = mktime(date('H'), date('i'), date('s'),
    					date('n'), date('j')-1, date('Y'));
    	
    	$dateSQL = date('Y-m-d H:i:s', $dateFeedCreated);
    	
    	$feed = Rssfeed::factory()->make([
    		'url'=>'https://www.foodsafetynews.com/food-recalls/feed/',
    		'updated_at'=> $dateSQL,
    		'user_id'=>$this->user->id
    	]);
    	
    	$dateFeedUpdating = mktime(date('H'), date('i'), date('s'),
    					date('n'), date('j'), date('Y'));
    	
    	$this->assertTrue(
    		$feed->isActual($dateFeedCreated),
    		"The date of updating the feed is different:".$dateSQL." ".$feed->updated_at
    	);
    	
    	$dateSQLUpdating = date('Y-m-d H:i:s', $dateFeedUpdating);
    	
    	$this->assertNotTrue(
    		$feed->isActual($dateSQLUpdating),
    		"The date of updating the feed is the same:".$dateSQLUpdating." ".$feed->updated_at
    	);
    	
    }
    
    /** @test */
    public function email_is_sent_after_updating_the_feed()
    {
    	$this->withoutExceptionHandling();
    	
    	$dateFeedCreated = mktime(date('H'), date('i'), date('s'),
    					date('n'), date('j')-1, date('Y'));
    	
    	$dateSQL = date('Y-m-d H:i:s', $dateFeedCreated);
    	
    	$dateFeedUpdating = mktime(date('H'), date('i'), date('s'),
    					date('n'), date('j'), date('Y'));
    	
    	$feed = Rssfeed::factory()->make([
    		'url'=>'https://www.foodsafetynews.com/food-recalls/feed/',
    		'updated_at'=> $dateSQL,
    		'user_id'=>$this->user->id
    	]);
    	
    	if (!$feed->isActual($dateFeedUpdating)){
    	 
    		Mail::raw('Feed is updated', function($message){
    			$message->to('foo@bar.com');
    			$message->from('foofoo@bar.com');
    		});

    	}
    	
    	$this->seeEmailSentTo('foo@bar.com')
    		->seeEmailSentFrom('foofoo@bar.com')
    		->seeEmailEquals('Feed is updated')
    		->seeEmailContains('Feed');
    	
    }
}



