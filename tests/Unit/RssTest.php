<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Rssfeed;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class RssTest extends TestCase
{
	use RefreshDatabase;
	
    /** @test */
    public function it_has_a_category()
    {
        $user = User::factory()->create();
    	$category = Category::factory()->create();
    	$rss = Rssfeed::factory()->create([
    	    'category_id' => $category,
    	    'user_id' => $user
    	    ]);
        $this->assertInstanceOf(Category::class, $rss->category);
    }
}
