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
    public function it_can_be_deleted()
    {
        $category = Category::factory()->create();
        
        $this->assertDatabaseHas('categories', $category->toArray());
        
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->delete($category->path());
        
        $this->assertDatabaseMissing('categories', $category->toArray());
    }
    
    /** @test */
    public function it_can_be_changed()
    {
        $category = Category::factory()->create();
        
        $user = User::factory()->create();
        
        $this->actingAs($user)->get($category->path().'/edit')->assertSee($category->name);
            
        $this->actingAs($user)->patch($category->path(),['name'=>'Changed name']);
        
        $this->assertDatabaseHas('categories', [
            'name'=>'Changed name',
            'id' => $category->id
        ]);
    }
    
    
}
