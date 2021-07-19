<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Rssfeed;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Event;

class RssTest extends TestCase
{
	use RefreshDatabase;
	
    /** @test */
    public function it_has_a_category()
    {
        
        Event::fake();
        
    	$category = Category::factory()->create();
    	$rss = Rssfeed::factory()
    	    ->for(User::factory())
    	    ->create(['category_id' => $category]);
    	        
        $this->assertInstanceOf(Category::class, $rss->category);
    }
}
