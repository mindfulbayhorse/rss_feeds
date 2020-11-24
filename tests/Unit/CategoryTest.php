<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Category;
use \Illuminate\Foundation\Testing\RefreshDatabase;
use \Illuminate\Foundation\Testing\WithFaker;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

	public function it_has_a_path()
	{
	    $category = Category::factory()->create();
	    
	    $this->assertEquals('categories/'.$category->id, $category->path());
	}
}
