<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Rssfeed;
use App\Models\Category;
use Illuminate\Support\Arr;

class ManagingFeedsTest extends TestCase
{
	use RefreshDatabase, WithFaker;
	
	public $user;
	
	protected function setUp():void
	{
		parent::setUp();
		
		$this->user = User::factory()->create();
	}
    
	/** @test */
    public function authorized_user_can_add_a_feed()
    {
    	$this->withoutExceptionHandling();

        $rss = Rssfeed::factory()->raw();
        
        $this->assertDatabaseMissing('rss_feeds', $rss);
        
        $this->actingAs($this->user)
        	->get('/rss')
        	->assertStatus(200);
        	
        $response = $this->actingAs($this->user)
            ->post('/rss', $rss);
        
	    $this->followRedirects($response)
	    	->assertSee($rss['url']);
	
        $this->assertDatabaseHas('rss_feeds', $rss);
    }
    
    /** @test */
    public function feed_can_be_created_with_category()
    {
    	$this->withoutExceptionHandling();
    	
    	$categories = Category::factory()->count(3)->create();
    	
    	$this->actingAs($this->user)
	    	->get('/rss/create')
	    	->assertStatus(200)
	    	->assertSeeInOrder(Arr::pluck($categories->toArray(),'name'));
    	
	    $rss = Rssfeed::factory()->raw([
	    	'category_id' => $categories[0]->id
	    ]);
	    
	    $this->actingAs($this->user)
	    	->followingRedirects()
	    	->post('/rss', $rss)
	    	->assertSee($rss['title'])
	    	->assertSee($categories[0]->name);
	    
	    $this->assertDatabaseHas('rss_feeds', $rss);
	    	
    }
}
