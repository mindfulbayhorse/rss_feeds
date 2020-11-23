<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\User;

class ManagingCategoriesTest extends TestCase
{
	use RefreshDatabase;
	
	public $user;
	
    /** @test */
    public function it_must_have_a_name()
    {
    	
        $category = Category::factory()->raw(['name'=>'']);
        $user = User::factory()->create();
        
        $this->actingAs($user)
        	->post('/categories', $category)
        	->assertSessionHasErrors('name');
        		
    }
    
    /** @test */
    public function guest_cannot_create_a_category()
    {
        //$this->withoutExceptionHandling();
        
        $category = Category::factory()->raw();
        
        $this->post('/categories', $category)
            ->assertRedirect('/login');       
        
    }
    
    /** @test */
    public function 
}
